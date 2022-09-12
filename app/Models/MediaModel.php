<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Lib\Core\Core;

use App\Models\AdminModel;

class MediaModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media';


    protected $primaryKey = 'media_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'mime_type',
        'media_info',
        'title',
        'alt',
        'descp',
        'status',
        'updated_id',
        'migration_at'
    ];

    protected $guarded = [
        'media_id'
    ];



    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public static function getMediaPath($dataId)
    {
        return MediaModel::where('media_id', '=', $dataId)->value('path');
    }

    public static function getModuleVars()
    {
        return ["view_txt" => __('admin.view_txt'), "target" => Config('commonconstants.target_opt1'), "media_folder" => Core::getUploadedURL(Config('commonconstants.media_dir_name')), "img_width" => Config('adminconstants.image_width'), "media_folder_name" => Config('commonconstants.media_dir_name')];
    }

    public static function setMediainfoArr($file)
    {
        $mediaInfoArr = [];

        $filename   = $file->getClientOriginalName();
        if ($filename) {
            $mediaInfoArr['filename'] = $filename;
        }
        $extension  = $file->getClientOriginalExtension();
        if ($extension) {
            $mediaInfoArr['extension'] = $extension;
        }
        // $tempPath   = $file->getRealPath();
        $fileSize   = $file->getSize();
        if ($fileSize) {
            $mediaInfoArr['size'] = $fileSize;
        }
        $mimeType   = $file->getMimeType();
        if ($mimeType) {
            $mediaInfoArr['type'] = $mimeType;
        }

        list($width, $height) = getimagesize($file);
        if ($width && $height) {
            $mediaInfoArr['width'] = $width;
            $mediaInfoArr['height'] = $height;
        }
        return $mediaInfoArr;
    }

    public function scopeSearch($query, $fltrDataArr)
    {
        if (empty($fltrDataArr)) {
            return $query;
        } else {
            $searchKey = $fltrDataArr['search_key'] ?? '';
            if ($searchKey) {
                $query->where('path', 'LIKE', "%{$searchKey}%")->orWhere('title', 'LIKE', "%{$searchKey}%")->orWhere('alt', 'LIKE', "%{$searchKey}%");
            }

            $title = $fltrDataArr['title'] ?? '';
            if ($title) {
                $query->where('title', 'LIKE', "%{$title}%");
            }
            $alt = $fltrDataArr['alt'] ?? '';
            if ($alt) {
                $query->where('alt', 'LIKE', "%{$alt}%");
            }

            $dbDtFrmt = Config('commonconstants.y_m_d_frmt');

            $updatedAt = $fltrDataArr['updated_at'] ?? '';
            if ($updatedAt) {
                $updatedAtArr = explode(" - ", $updatedAt);
                if (!empty($updatedAtArr)) {
                    $uaStartDate = date($dbDtFrmt, strtotime($updatedAtArr[0])) . ' 00:00:00';
                    $uaEndDate = date($dbDtFrmt, strtotime($updatedAtArr[1])) . ' 23:59:59';
                }
                $query->whereBetween('updated_at', [$uaStartDate, $uaEndDate]);
            }

            $updatedByName = $fltrDataArr['updated_by_name'] ?? '';
            if ($updatedByName) {
                $query->whereHas('updatedby', function ($q) use ($updatedByName) {
                    $q->where('display_name', 'LIKE', '%' . $updatedByName . '%');
                });
            }

            return $query;
        }
    }

    public function updatedby()
    {
        return $this->belongsTo(AdminModel::class, 'updated_id');
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
