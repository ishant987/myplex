<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\SeoPage;
use App\Models\SeoPageVersion;
use App\Services\SeoPageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SeoPageController extends BaseController
{
    private $service;

    public function __construct(SeoPageService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $query = SeoPage::query();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('page_title', 'like', "%{$search}%")
                    ->orWhere('focus_keyword', 'like', "%{$search}%")
                    ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        foreach (['status', 'page_type', 'category'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->get($field));
            }
        }

        $sort = $request->get('sort', 'updated_at');
        $direction = $sort === 'seo_score' ? 'asc' : 'desc';
        if (!in_array($sort, ['created_at', 'updated_at', 'seo_score'])) {
            $sort = 'updated_at';
        }

        $pages = $query->orderBy($sort, $direction)->paginate(20)->appends($request->query());

        return view('themes.backend.pages.seo_pages.index', $this->viewData(compact('pages')));
    }

    public function create()
    {
        $page = new SeoPage([
            'publish_date' => now(),
            'status' => 'draft',
            'schema_type' => 'BlogPosting',
            'is_indexed' => true,
        ]);

        return view('themes.backend.pages.seo_pages.form', $this->viewData(compact('page')) + ['versions' => collect()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data = $this->service->prepare($data, $request->file('featured_image'), $request->file('og_image'));

        if ($data['status'] === 'published' && !empty($data['featured_image_url']) && empty($data['image_alt_text'])) {
            return back()->withErrors(['image_alt_text' => 'Image alt text is required before publishing.'])->withInput();
        }

        $page = SeoPage::create($data);
        $this->service->snapshot($page);

        return redirect()->route('admin.seo-pages.index')->with('message', 'SEO page created successfully.');
    }

    public function edit(SeoPage $seoPage)
    {
        $versions = $seoPage->versions()->take(5)->get();

        return view('themes.backend.pages.seo_pages.form', $this->viewData(['page' => $seoPage, 'versions' => $versions]));
    }

    public function update(Request $request, SeoPage $seoPage)
    {
        $data = $this->validated($request, $seoPage->id);
        $data = $this->service->prepare($data, $request->file('featured_image'), $request->file('og_image'), $seoPage);

        if ($data['status'] === 'published' && !empty($data['featured_image_url']) && empty($data['image_alt_text'])) {
            return back()->withErrors(['image_alt_text' => 'Image alt text is required before publishing.'])->withInput();
        }

        $seoPage->update($data);
        $this->service->snapshot($seoPage->fresh());

        return redirect()->route('admin.seo-pages.edit', $seoPage)->with('message', 'SEO page updated successfully.');
    }

    public function duplicate(SeoPage $seoPage)
    {
        $data = $seoPage->replicate()->toArray();
        $data['page_title'] = $data['page_title'] . ' Copy';
        $data['url_slug'] = $this->service->normalizeSlug($data['url_slug'] . '-copy');
        $data['status'] = 'draft';
        unset($data['seo_score']);

        $copy = SeoPage::create($this->service->prepare($data));
        $this->service->snapshot($copy);

        return redirect()->route('admin.seo-pages.edit', $copy)->with('message', 'Page duplicated as draft.');
    }

    public function destroy(Request $request, SeoPage $seoPage)
    {
        $request->validate(['confirm_delete' => ['accepted']]);
        $seoPage->delete();

        return redirect()->route('admin.seo-pages.index')->with('message', 'SEO page deleted.');
    }

    public function bulk()
    {
        $rows = session('seo_bulk_rows', []);
        return view('themes.backend.pages.seo_pages.bulk', $this->viewData([
            'rows' => $rows,
            'errorsByRow' => session('bulk_errors', [])
        ]));
    }

    public function template()
    {
        $columns = 'page_title,url_slug,page_type,category,author,publish_date,short_description,full_content,tags,seo_title,meta_description,focus_keyword,schema_type,status,featured_image_url';

        return response($columns . "\n", 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="seo-page-template.csv"',
        ]);
    }

    public function previewCsv(Request $request)
    {
        $request->validate(['csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:2048']]);
        $content = file_get_contents($request->file('csv_file')->getRealPath());

        if (!mb_check_encoding($content, 'UTF-8')) {
            return back()->withErrors(['csv_file' => 'CSV must be UTF-8 encoded.']);
        }

        $lines = array_filter(preg_split('/\r\n|\n|\r/', $content));
        $header = str_getcsv(array_shift($lines));
        $rows = [];
        $errors = [];
        $seen = [];

        foreach (array_slice($lines, 0, 10) as $index => $line) {
            $row = array_combine($header, array_pad(str_getcsv($line), count($header), ''));
            $row['url_slug'] = $this->service->normalizeSlug($row['url_slug'] ?? '', $row['page_title'] ?? '');
            $rowNo = $index + 1;
            $validator = Validator::make($row, $this->rules());

            if (isset($seen[$row['url_slug']])) {
                $validator->after(function ($v) {
                    $v->errors()->add('url_slug', 'Duplicate slug in CSV.');
                });
            }

            $seen[$row['url_slug']] = true;

            if ($validator->fails()) {
                $errors[$rowNo] = array_merge($errors[$rowNo] ?? [], $validator->errors()->all());
            }

            $rows[] = $row;
        }

        session(['seo_bulk_rows' => $rows]);

        return redirect()->route('admin.seo-pages.bulk')->with('bulk_errors', $errors);
    }

    public function publishCsv(Request $request)
    {
        $rows = session('seo_bulk_rows', []);
        $status = $request->get('bulk_status', 'draft');

        foreach (array_slice($rows, 0, 10) as $row) {
            $row['status'] = $status;
            $data = $this->service->prepare($row);
            $page = SeoPage::create($data);
            $this->service->snapshot($page);
        }

        session()->forget('seo_bulk_rows');

        return redirect()->route('admin.seo-pages.index')->with('message', count($rows) . ' SEO pages created.');
    }

    public function restore(SeoPage $seoPage, SeoPageVersion $version)
    {
        abort_unless($version->seo_page_id === $seoPage->id, 404);
        $data = $this->service->prepare($version->content_snapshot, null, null, $seoPage);
        $seoPage->update($data);
        $this->service->snapshot($seoPage->fresh());

        return redirect()->route('admin.seo-pages.edit', $seoPage)->with('message', 'Version restored.');
    }

    private function validated(Request $request, $id = null)
    {
        return $request->validate($this->rules($id) + [
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    private function rules($id = null)
    {
        return [
            'page_title' => ['required', 'string', 'max:255'],
            'url_slug' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9\-\/]+$/', Rule::unique('seo_pages', 'url_slug')->ignore($id)],
            'page_type' => ['required', Rule::in(array_keys(SeoPageService::PAGE_TYPES))],
            'category' => ['nullable', 'string', 'max:100'],
            'author' => ['nullable', 'string', 'max:100'],
            'publish_date' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'short_description' => ['nullable', 'string', 'max:160'],
            'full_content' => ['nullable', 'string'],
            'tags' => ['nullable', 'string'],
            'featured_image_url' => ['nullable', 'string'],
            'image_alt_text' => ['nullable', 'string', 'max:255'],
            'seo_title' => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'focus_keyword' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'string'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_image_url' => ['nullable', 'string'],
            'schema_type' => ['required', Rule::in(SeoPageService::SCHEMA_TYPES)],
            'is_indexed' => ['nullable', 'boolean'],
        ];
    }

    private function viewData(array $data)
    {
        return $data + [
            'pageTypes' => SeoPageService::PAGE_TYPES,
            'categories' => SeoPageService::CATEGORIES,
            'schemaTypes' => SeoPageService::SCHEMA_TYPES,
        ];
    }
}
