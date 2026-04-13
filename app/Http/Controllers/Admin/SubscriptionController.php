<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use App\Models\Subscription;

class SubscriptionController extends BaseController
{
    public function index()
    {
        $subscriptions = Subscription::query()
            ->with(['user', 'plan'])
            ->whereNotNull('plan_id')
            ->latest('id')
            ->paginate(20);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function show(Subscription $subscription)
    {
        $subscription->load([
            'user.sensitiveDetails',
            'plan',
            'transactions' => fn ($query) => $query->latest('id'),
        ]);

        return view('admin.subscriptions.show', compact('subscription'));
    }
}
