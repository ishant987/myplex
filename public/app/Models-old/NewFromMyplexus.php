<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Lib\Core\Core;

use App\Models\AdminModel;

class NewFromMyplexus extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'new_from_myplexus';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type_id',
		'title',
        'link'       
    ];
	
	public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = NewFromMyplexus::select($fields);

        /*$status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
        if ($status > 0) {
            $query->where('status', '=', $status);
        }*/

        /*if ($orderBy == false && $order == false) {
            $orderBy = 'fw_id';
            $order = 'DESC';
        }

        $query->orderBy($orderBy, $order);*/
        return $perPage ? $query->paginate($perPage) : $query->get();
    }
	
	
}
	
	
?>