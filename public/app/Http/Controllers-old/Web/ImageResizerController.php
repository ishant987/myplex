<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;

class ImageResizerController extends BaseController
{
  public function show($img, $folder, $h, $w, $q)
  {
    $img =  \Image::make(public_path("/storage/$folder/$img"));
    if((int) $h>0 && (int) $w>0){
      return $img->resize($h, $w)->response(false, $q);
    }
    elseif((int) $h>0){
      return $img->resize(null, $h, function ($constraint) {
            $constraint->aspectRatio();
        })->response(false, $q);
    }
    elseif((int) $w>0){
      return $img->resize($w, null, function ($constraint) {
            $constraint->aspectRatio();
        })->response(false, $q);
    }
  }
}
