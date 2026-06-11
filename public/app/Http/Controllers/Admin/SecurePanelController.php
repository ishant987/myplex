<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use App\Models\User;
use App\Models\UserSensitiveDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SecurePanelController extends BaseController
{
    public function login()
    {
        return view('admin.secure-panel.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if ($request->password !== env('SECURE_PANEL_PASSWORD')) {
            return back()->withErrors(['password' => 'The secure panel password is incorrect.']);
        }

        $request->session()->put('secure_panel_authenticated_at', now()->timestamp);

        return redirect()->route('admin.secure-panel.users.index');
    }

    public function users()
    {
        $users = User::query()
            ->with('sensitiveDetails')
            ->orderByDesc('u_id')
            ->paginate(20);

        return view('admin.secure-panel.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load([
            'sensitiveDetails',
            'razorpaySubscriptions' => fn ($query) => $query->with(['plan', 'transactions'])->latest('id'),
            'paymentTransactions' => fn ($query) => $query->latest('id'),
        ]);

        return view('admin.secure-panel.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->load('sensitiveDetails');

        return view('admin.secure-panel.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'pan' => ['nullable', 'string', 'max:50'],
            'arn' => ['nullable', 'string', 'max:50'],
            'gst' => ['nullable', 'string', 'max:50'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'account_holder_name' => ['nullable', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255'],
            'ifsc_code' => ['nullable', 'string', 'max:50'],
        ]);

        UserSensitiveDetail::updateOrCreate(
            ['user_id' => $user->u_id],
            $validated
        );

        return redirect()->route('admin.secure-panel.users.show', $user->u_id)
            ->with('alert', Config('adminconstants.alert_css.1'))
            ->with('message', 'Sensitive details updated successfully.')
            ->with('title', __('admin.success_ttl'));
    }
}
