<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculatorRegister extends Model
{
    use HasFactory;
    protected $table = 'calculator_registers';
    protected $fillable = [
        'username',
        'email',
        'created_at',
        'updated_at'
    ];
}
