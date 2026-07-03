<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use App\Models\SeoPage;
use App\Services\SeoPageService;

class SeoPageController extends BaseController
{
    public function show($slug)
    {
        $page = SeoPage::where('url_slug', trim($slug, '/'))->where('status', 'published')->firstOrFail();
        $related = SeoPage::where('status', 'published')
            ->where('category', $page->category)
            ->where('id', '<>', $page->id)
            ->latest()
            ->take(3)
            ->get();

        $gallery = $this->galleryFor($page);

        return view('themes.frontend.pages.seo.show', compact('page', 'related', 'gallery'));
    }

    public function sitemap(SeoPageService $service)
    {
        return response($service->sitemapXml(), 200)->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        return response("User-agent: *\nAllow: /\nSitemap: https://www.myplexus.com/sitemap.xml\n", 200)
            ->header('Content-Type', 'text/plain');
    }

    private function galleryFor(SeoPage $page)
    {
        $base = asset('themes/frontend/assets/images');

        if ($page->category === 'SIP') {
            return [
                $base . '/sip-planner-banner.jpg',
                $base . '/inflation-calc-chart-data.jpg',
                $base . '/investing-tools-bg.jpg',
            ];
        }

        return [
            $base . '/financial-advisor.jpg',
            $base . '/graph-image.jpg',
            $base . '/about-us-image-01.jpg',
        ];
    }
}
