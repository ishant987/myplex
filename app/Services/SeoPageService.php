<?php

namespace App\Services;

use App\Models\SeoPage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SeoPageService
{
    public const PAGE_TYPES = ['blog' => 'Blog Post', 'landing' => 'Landing Page', 'guide' => 'Guide', 'faq' => 'FAQ Page'];
    public const CATEGORIES = ['Mutual Funds', 'SIP', 'NFO', 'Tax Planning', 'Market Insights', 'Financial Planning'];
    public const SCHEMA_TYPES = ['Article', 'FAQPage', 'HowTo', 'BlogPosting'];

    public function normalizeSlug($slug, $title = '')
    {
        $source = trim((string) $slug) ?: (string) $title;
        $source = preg_replace('#^https?://[^/]+#i', '', $source);
        $source = trim($source, '/');
        $parts = array_filter(explode('/', $source));

        $clean = collect($parts)->map(function ($part) {
            return Str::slug($part);
        })->filter()->implode('/');

        return $clean ?: Str::slug($title ?: uniqid('page-'));
    }

    public function prepare(array $data, ?UploadedFile $featuredImage = null, ?UploadedFile $ogImage = null, ?SeoPage $page = null)
    {
        $data['url_slug'] = $this->normalizeSlug($data['url_slug'] ?? '', $data['page_title'] ?? '');
        $data['status'] = $data['status'] ?? 'draft';
        $data['is_indexed'] = isset($data['is_indexed']) ? (bool) $data['is_indexed'] : true;
        $data['full_content'] = $this->sanitizeHtml($data['full_content'] ?? '');
        $data['short_description'] = Str::limit(trim((string) ($data['short_description'] ?? '')), 160, '');
        $data['seo_title'] = Str::limit(trim((string) ($data['seo_title'] ?? '')), 60, '');
        $data['meta_description'] = Str::limit(trim((string) ($data['meta_description'] ?? '')), 160, '');
        $data['seo_title'] = $data['seo_title'] ?: ($data['page_title'] ?? '');
        $data['meta_description'] = $data['meta_description'] ?: $data['short_description'];
        $data['canonical_url'] = trim((string) ($data['canonical_url'] ?? '')) ?: 'https://www.myplexus.com/' . $data['url_slug'];
        $data['og_title'] = trim((string) ($data['og_title'] ?? '')) ?: $data['seo_title'];
        $data['image_alt_text'] = trim((string) ($data['image_alt_text'] ?? '')) ?: ($data['page_title'] ?? '');
        $data['tags'] = $this->normalizeTags($data['tags'] ?? '');

        if ($featuredImage) {
            $data['featured_image_url'] = $this->storeImage($featuredImage);
        } elseif ($page && empty($data['featured_image_url'])) {
            $data['featured_image_url'] = $page->featured_image_url;
        }

        if ($ogImage) {
            $data['og_image_url'] = $this->storeImage($ogImage);
        } elseif (empty($data['og_image_url'])) {
            $data['og_image_url'] = $data['featured_image_url'] ?? ($page ? $page->og_image_url : null);
        }

        $data['seo_score'] = $this->score($data);

        return $data;
    }

    public function snapshot(SeoPage $page)
    {
        $page->versions()->create([
            'content_snapshot' => $page->only($page->getFillable()),
            'saved_at' => now(),
        ]);

        $oldVersions = $page->versions()->skip(5)->take(100)->pluck('id');
        if ($oldVersions->count()) {
            $page->versions()->whereIn('id', $oldVersions)->delete();
        }
    }

    public function score(array $data)
    {
        $score = 0;
        $seoTitle = trim((string) ($data['seo_title'] ?? ''));
        $meta = trim((string) ($data['meta_description'] ?? ''));
        $keyword = Str::lower(trim((string) ($data['focus_keyword'] ?? '')));
        $content = (string) ($data['full_content'] ?? '');
        $plain = trim(strip_tags($content));
        $firstParagraph = Str::lower($this->firstParagraph($content));

        if ($seoTitle && mb_strlen($seoTitle) <= 60) $score += 15;
        if ($meta && mb_strlen($meta) <= 160) $score += 15;
        if ($keyword) $score += 10;
        if ($keyword && Str::contains(Str::lower($seoTitle), $keyword)) $score += 10;
        if ($keyword && Str::contains($firstParagraph, $keyword)) $score += 10;
        if (!empty($data['featured_image_url'])) $score += 10;
        if (!empty($data['image_alt_text'])) $score += 10;
        if (str_word_count($plain) > 500) $score += 10;
        if (preg_match('/href=["\']\/(?!\/)/i', $content) || preg_match('/href=["\']https?:\/\/(www\.)?myplexus\.com\//i', $content)) $score += 5;
        if (!empty($data['tags'])) $score += 5;

        return min(100, $score);
    }

    public function sitemapXml()
    {
        $pages = SeoPage::where('status', 'published')->orderBy('updated_at', 'desc')->get();
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($pages as $page) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . e($page->public_url) . "</loc>\n";
            $xml .= '    <lastmod>' . $page->updated_at->format('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }

        return $xml . '</urlset>';
    }

    private function normalizeTags($tags)
    {
        if (is_array($tags)) {
            $tags = implode(',', $tags);
        }

        return collect(explode(',', (string) $tags))
            ->map(function ($tag) {
                return trim($tag);
            })
            ->filter()
            ->unique()
            ->implode(', ');
    }

    private function sanitizeHtml($html)
    {
        $html = (string) $html;
        $html = preg_replace('#<script\b[^>]*>(.*?)</script>#is', '', $html);
        $html = preg_replace('/\son[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);
        $html = preg_replace('/(href|src)\s*=\s*([\'"])\s*javascript:[^\'"]*\2/i', '$1=$2#$2', $html);

        return strip_tags($html, '<p><br><h1><h2><h3><strong><b><em><i><ul><ol><li><blockquote><a><img><figure><figcaption><table><thead><tbody><tr><th><td>');
    }

    private function firstParagraph($html)
    {
        if (preg_match('/<p[^>]*>(.*?)<\/p>/is', $html, $matches)) {
            return strip_tags($matches[1]);
        }

        return Str::limit(strip_tags($html), 300, '');
    }

    private function storeImage(UploadedFile $file)
    {
        $path = $file->store('seo-pages', 'public');
        return Storage::disk('public')->url($path);
    }
}
