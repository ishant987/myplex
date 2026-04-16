<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
        'user_id',
        'plan_id',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_subscription_id',
        'billing_cycle',
        'status',
        'starts_at',
        'ends_at',
        'trial_ends_at',
        'amount',
        'currency',
        'created_by',
        'created_id',
        'updated_by',
        'updated_id',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    // protected $guarded = [
    //     'us_id',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'u_id');
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    public function transactions()
    {
        return $this->hasMany(PaymentTransaction::class, 'subscription_id');
    }

    public function scopeLatestRazorpay($query)
    {
        return $query->whereNotNull('plan_id')->orderByDesc('id');
    }

    public static function databaseStatusFor(string $status): string
    {
        if (DB::getDriverName() !== 'sqlite') {
            return $status;
        }

        return match ($status) {
            'active' => 'a',
            'failed', 'cancelled', 'expired' => 'e',
            'pending' => '',
            default => $status,
        };
    }

    public function displayStatus(): string
    {
        return match ($this->status) {
            'a' => 'active',
            'e' => $this->user?->subscription_status ?: 'expired',
            '' => 'pending',
            default => $this->status,
        };
    }

    public function isActive(): bool
    {
        if (!in_array($this->status, ['a', 'active'], true)) {
            return false;
        }

        if (!empty($this->ends_at)) {
            return Carbon::parse($this->ends_at)->isFuture();
        }

        if (!empty($this->subscription_expiry_date)) {
            return Carbon::parse($this->subscription_expiry_date)->isFuture();
        }

        return false;
    }
}
