<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\PageTemplateModel;
use App\Models\AdminModel;

class PageOptionsModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pg_options';

    protected $primaryKey = 'pg_option_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'field_name',
        'field_label',
        'field_type',
        'field_info',
        'template_id',
        'c_order',
        'updated_id'
    ];

    protected $guarded = [
        'pg_option_id'
    ];



    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public function pagetemplate()
    {
        return $this->hasOne(PageTemplateModel::class, 'template_id', 'template_id');
    }

    public function updatedby()
    {
        return $this->hasOne(AdminModel::class, 'admin_id', 'updated_id');
    }

    public static function getPageTemplateOptionList($templateId, $fields = false)
    {
        if ($fields == false) {
            $fields = ['pg_option_id', 'field_name', 'field_label', 'field_type', 'field_info'];
        }

        return PageOptionsModel::select($fields)->where('template_id', '=', $templateId)->orderBy('c_order', 'ASC')->get();
    }

    public static function getPgTemplateData($dataId)
    {
        return PageTemplateModel::select('title', 'template_id')->where('template_id', '=', $dataId)->first();
    }

    public static function getPgTemplateList()
    {
        return PageTemplateModel::select('title', 'template_id')->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Frontent (API / Website) Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for api panel.
    |
    */
}
