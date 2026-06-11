<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundReturnReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'fund_code',
        'entry_date',
        'six_month',
        'one_year',
        'two_year',
        'three_year',
        'five_year',
    ];
}
