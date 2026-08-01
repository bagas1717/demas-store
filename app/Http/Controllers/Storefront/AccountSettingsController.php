<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountSettingsController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();

        return view('pages.account.settings', [
            'user' => $user,
            'sessions' => $this->sessionsFor($request),
            'currentSessionId' => $request->session()->getId(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();
        $oldEmail = strtolower((string) $user->email);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'username' => [
                'nullable',
                'string',
                'min:3',
                'max:30',
                'alpha_dash:ascii',
                Rule::unique('users', 'username')->ignore($user->id),
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
                'regex:/^[0-9+\-\s()]+$/',
            ],
        ]);

        $newEmail = strtolower(trim($validated['email']));
        $emailChanged = $oldEmail !== $newEmail;

        $user->update([
            'name' => trim($validated['name']),
            'username' => filled($validated['username'] ?? null)
                ? strtolower(trim($validated['username']))
                : null,
            'email' => $newEmail,
            'phone' => filled($validated['phone'] ?? null)
                ? trim($validated['phone'])
                : null,
            'email_verified_at' => $emailChanged
                ? null
                : $user->email_verified_at,
        ]);

        if ($emailChanged) {
            $user->sendEmailVerificationNotification();

            return redirect()
                ->route('verification.notice')
                ->with(
                    'status',
                    'Email berhasil diubah. Silakan verifikasi email baru.'
                );
        }

        return back()->with(
            'profile_success',
            'Profil berhasil diperbarui.'
        );
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->provider === 'google' && blank($user->password)) {
            return back()->withErrors([
                'password' => 'Password akun ini dikelola melalui Google.',
            ]);
        }

        $validated = $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with(
            'password_success',
            'Password berhasil diperbarui.'
        );
    }

    public function destroySession(
        Request $request,
        string $sessionId
    ): RedirectResponse {
        abort_unless(
            config('session.driver') === 'database',
            409,
            'Kelola perangkat memerlukan SESSION_DRIVER=database.'
        );

        abort_if(
            hash_equals($request->session()->getId(), $sessionId),
            422,
            'Sesi perangkat saat ini tidak dapat dikeluarkan dari tombol ini.'
        );

        DB::table(config('session.table', 'sessions'))
            ->where('id', $sessionId)
            ->where('user_id', $request->user()->id)
            ->delete();

        return back()->with(
            'session_success',
            'Perangkat berhasil dikeluarkan.'
        );
    }

    public function destroyOtherSessions(Request $request): RedirectResponse
    {
        abort_unless(
            config('session.driver') === 'database',
            409,
            'Kelola perangkat memerlukan SESSION_DRIVER=database.'
        );

        DB::table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->id)
            ->where('id', '!=', $request->session()->getId())
            ->delete();

        return back()->with(
            'session_success',
            'Semua perangkat lain berhasil dikeluarkan.'
        );
    }

    private function sessionsFor(Request $request): Collection
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return DB::table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->id)
            ->orderByDesc('last_activity')
            ->get()
            ->map(function (object $session): object {
                $agent = (string) ($session->user_agent ?? '');

                $session->browser = $this->browserName($agent);
                $session->platform = $this->platformName($agent);

                return $session;
            });
    }

    private function browserName(string $agent): string
    {
        return match (true) {
            str_contains($agent, 'Edg/') => 'Microsoft Edge',
            str_contains($agent, 'OPR/') => 'Opera',
            str_contains($agent, 'Chrome/') => 'Google Chrome',
            str_contains($agent, 'Firefox/') => 'Mozilla Firefox',
            str_contains($agent, 'Safari/') => 'Safari',
            default => 'Browser tidak dikenal',
        };
    }

    private function platformName(string $agent): string
    {
        return match (true) {
            str_contains($agent, 'Windows') => 'Windows',
            str_contains($agent, 'Android') => 'Android',
            str_contains($agent, 'iPhone'),
            str_contains($agent, 'iPad') => 'iOS',
            str_contains($agent, 'Mac OS') => 'macOS',
            str_contains($agent, 'Linux') => 'Linux',
            default => 'Perangkat tidak dikenal',
        };
    }
}
