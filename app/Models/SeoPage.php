<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeoPage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'page_title',
        'url_slug',
        'page_type',
        'category',
        'author',
        'publish_date',
        'status',
        'short_description',
        'full_content',
        'tags',
        'featured_image_url',
        'image_alt_text',
        'seo_title',
        'meta_description',
        'focus_keyword',
        'canonical_url',
        'og_title',
        'og_image_url',
        'schema_type',
        'is_indexed',
        'seo_score',
    ];

    protected $casts = [
        'publish_date' => 'date',
        'is_indexed' => 'boolean',
    ];

    public function versions()
    {
        return $this->hasMany(SeoPageVersion::class)->latest('saved_at');
    }

    public function getTagListAttribute()
    {
        return collect(explode(',', (string) $this->tags))
            ->map(function ($tag) {
                return trim($tag);
            })
            ->filter()
            ->values();
    }

    public function getPublicUrlAttribute()
    {
        return 'https://www.myplexus.com/' . ltrim($this->url_slug, '/');
    }
}
