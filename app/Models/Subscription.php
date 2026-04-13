<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $table = 'subscriptions';

    //protected $primaryKey = 'us_id';
    protected $fillable = [
        'u_id',
        'u_code',
        'subscription_type',
        'created_date',
        'subscription_expiry_date',
        'status',
        'created_by',
        'created_id',
        'updated_by',
        'updated_id',
    ];

    // protected $guarded = [
    //     'us_id',
    // ];

}
