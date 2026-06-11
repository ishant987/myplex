<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class WhiteLabelController extends Controller
{
    public function edit()
    {
        $user = $this->whiteLabelUser();
        $data = $this->viewData($user);

        $data['browser_title'] = 'White Label Branding';
        $data['active_menu'] = 'white_label_branding';
        $data['branding'] = $user->whiteLabelBranding();

        return view('web.auth.white_label.branding', $data);
    }

    public function update(Request $request)
    {
        $user = $this->whiteLabelUser();

        $validated = $request->validate([
            'wl_company_name' => 'required|string|max:255',
            'wl_logo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $logoPath = $user->whiteLabelLogoPath();

        if ($request->hasFile('wl_logo')) {
            $uploadDirectory = public_path('uploads/whitelabel');
            if (!File::isDirectory($uploadDirectory)) {
                File::makeDirectory($uploadDirectory, 0755, true);
            }

            $extension = strtolower((string) $request->file('wl_logo')->getClientOriginalExtension());
            $fileName = 'user-' . $user->u_id . '-' . Str::uuid() . '.' . $extension;
            $request->file('wl_logo')->move($uploadDirectory, $fileName);

            if ($logoPath && !filter_var($logoPath, FILTER_VALIDATE_URL)) {
                $oldLogoAbsolutePath = public_path($logoPath);
                if (File::exists($oldLogoAbsolutePath) && str_contains($oldLogoAbsolutePath, public_path('uploads/whitelabel'))) {
                    File::delete($oldLogoAbsolutePath);
                }
            }

            $logoPath = 'uploads/whitelabel/' . $fileName;
        }

        $user->wl_company_name = $validated['wl_company_name'];
        $user->wl_logo = $logoPath;
        $user->save();

        $this->persistWhiteLabelSettings($user);

        return redirect()
            ->route('user.white_label.branding')
            ->with('success', 'White label branding updated successfully.');
    }

    protected function whiteLabelUser(): User
    {
        /** @var User $user */
        $user = Auth::user();

        abort_unless($user && $user->hasWhiteLabel(), 403, 'White label branding is available only for active white label subscribers.');

        return $user;
    }

    protected function viewData(User $user): array
    {
        $expiryDateTime = Carbon::parse($user->subscription_expiry_date);

        return [
            'userdetails' => $user,
            'expiry_date' => $expiryDateTime->toDateString(),
            'current_date' => Carbon::now()->toDateString(),
            'fiveDaysBeforeExpiry' => $expiryDateTime->copy()->subDays(5)->toDateString(),
        ];
    }

    protected function persistWhiteLabelSettings(User $user): void
    {
        $settingsPath = $user->whiteLabelSettingsPath();
        if (!File::isDirectory(dirname($settingsPath))) {
            File::makeDirectory(dirname($settingsPath), 0755, true);
        }

        File::put($settingsPath, json_encode([
            'company_name' => $user->wl_company_name,
            'logo' => $user->wl_logo,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
