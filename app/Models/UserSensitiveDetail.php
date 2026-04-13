<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSensitiveDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'contact_person',
        'city',
        'state',
        'pan',
        'arn',
        'gst',
        'bank_name',
        'account_holder_name',
        'account_number',
        'ifsc_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'u_id');
    }
}
