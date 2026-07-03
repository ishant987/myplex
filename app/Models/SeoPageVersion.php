<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoPageVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'seo_page_id',
        'content_snapshot',
        'saved_at',
    ];

    protected $casts = [
        'content_snapshot' => 'array',
        'saved_at' => 'datetime',
    ];

    public function page()
    {
        return $this->belongsTo(SeoPage::class, 'seo_page_id');
    }
}
