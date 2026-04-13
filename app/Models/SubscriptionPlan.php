<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price_monthly',
        'price_yearly',
        'features',
        'is_active',
        'razorpay_plan_id_monthly',
        'razorpay_plan_id_yearly',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }

    public function getPriceForCycle(string $cycle): float
    {
        return (float) ($cycle === 'yearly' ? $this->price_yearly : $this->price_monthly);
    }
}
