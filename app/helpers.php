<?php

use App\Mail\DynamicTemplateMail;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('send_welcome_email')) {

    function send_welcome_email(User $user): bool
    {
        try {
            $template = EmailTemplate::where('key', 'welcome_simple')->first();

            if (!$template) {
                Log::warning('Welcome email template not found', [
                    'key'  => 'welcome_simple',
                    'user' => $user->id,
                ]);
                return false;
            }

            $data = [
                'name'     => $user->name,
                'email'    => $user->email,
                'url'      => route('dashboard'),
                'app_name' => config('app.name'),
            ];

            Mail::to($user->email)->send(new DynamicTemplateMail($template, $data));

            return true;
        } catch (\Throwable $e) {

            Log::error('Welcome email failed', [
                'user_id' => $user->id ?? null,
                'email'   => $user->email ?? null,
                'error'   => $e->getMessage(),
                'trace'   => config('app.debug') ? $e->getTraceAsString() : null,
            ]);

            return false;
        }
    }
}

if (!function_exists('send_otp_email')) {
    function send_otp_email(string $name, string $email, string $otp): bool
    {
        try {
            // 1. Fetch the template from Database
            // Make sure you have a row in email_templates table with key 'registration_otp'
            $template = EmailTemplate::where('key', 'registration_otp')->first();

            if (!$template) {
                Log::warning('OTP email template not found', [
                    'key'   => 'registration_otp',
                    'email' => $email,
                ]);
                return false;
            }

            // 2. Prepare Data for the {{ placeholders }}
            $data = [
                'name'     => $name,
                'otp'      => $otp,
                'email'    => $email,
                'app_name' => config('app.name'),
            ];

            // 3. Send Email
            Mail::to($email)->send(new DynamicTemplateMail($template, $data));

            return true;
        } catch (\Throwable $e) {

            // 4. Log Failure
            Log::error('OTP email failed', [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null,
            ]);

            return false;
        }
    }

}

if (!function_exists('settings')) {
    function settings($string, $default = null)
    {
        $parts = explode('.', $string);

        if (count($parts) !== 2) {
            return $default;
        }

        $group = $parts[0];
        $key = $parts[1];

        // Cache settings for performance (cleared on save in Livewire)
        return Cache::rememberForever("setting_{$group}_{$key}", function () use ($group, $key, $default) {
            return Setting::getValue($group, $key, $default);
        });
    }
}