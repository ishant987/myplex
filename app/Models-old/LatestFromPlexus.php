<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LatestFromPlexus extends Model
{
    use HasFactory;
    protected $table= 'lates_from_plexus';
    protected $fillable=['heading','sub_heading','status','link','created_by','uodated_by'];
    public function creator(){
        return $this->hasOne('App\Models\AdminModel','admin_id','created_by');
    }
}
