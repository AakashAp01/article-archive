<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class LoginManager extends Component
{
    public $isLoginMode = true;
    public $isForgotPassword = false;
    public $isOtpMode = false; 
    public $name = '';
    public $email = '';
    public $password = '';
    public $otp = '';

    public function toggleMode()
    {
        $this->isLoginMode = !$this->isLoginMode;
        $this->isForgotPassword = false;
        $this->isOtpMode = false;
        $this->resetValidation();
        $this->reset(['name', 'password', 'otp']);
    }

    public function enableForgotPassword()
    {
        $this->isForgotPassword = true;
        $this->resetValidation();
        $this->reset(['password']);
    }

    public function cancelForgotPassword()
    {
        $this->isForgotPassword = false;
        $this->isLoginMode = true;
        $this->resetValidation();
    }

    public function submit()
    {
        if ($this->isForgotPassword) {
            $this->sendResetLink();
        } elseif ($this->isOtpMode) {
            $this->verifyOtpAndRegister();
        } elseif ($this->isLoginMode) {
            $this->login();
        } else {
            $this->initiateRegister();
        }
    }

    private function sendResetLink()
    {
        $this->validate(['email' => 'required|email|exists:users,email']);
        $status = Password::sendResetLink(['email' => $this->email]);
        
        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('status', __($status));
            $this->reset(['email']);
        } else {
            $this->addError('email', __($status));
        }
    }

    private function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            if (Auth::user()->status == 0) {
                Auth::logout();
                $this->addError('email', 'Your account has been blocked. Please contact support.');
                return;
            }
            session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        $this->addError('email', 'Invalid Credentials.');
    }

    // 1. STEP ONE: Validate Input, Generate OTP, Send Email
    private function initiateRegister()
    {
        $this->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $otp = rand(100000, 999999);

        Session::put('register_data', [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10)
        ]);

        try {
            send_otp_email($this->name, $this->email, $otp);
            $this->isOtpMode = true;
            $this->password = ''; 

        } catch (\Exception $e) {
            Log::error('OTP Email Failed: ' . $e->getMessage());
            $this->addError('email', 'Failed to send verification code. Please try again.');
        }
    }

    // 2. STEP TWO: Verify OTP and Create User
    private function verifyOtpAndRegister()
    {
        $this->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $data = Session::get('register_data');

        if (!$data || now()->greaterThan($data['expires_at'])) {
            $this->addError('otp', 'Session expired. Please register again.');
            $this->isOtpMode = false;
            return;
        }

        if ($data['otp'] != $this->otp) {
            $this->addError('otp', 'Invalid verification code.');
            return;
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
                'type'     => 'user',
                'status'   => 1,
                'email_verified_at' => now(),
            ]);

            Auth::login($user);
            
            // Clear session
            Session::forget('register_data');
            
            DB::commit();
            return redirect()->route('dashboard');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Registration Error: ' . $e->getMessage());
            $this->addError('otp', 'System Error. Registration failed.');
        }
    }

    public function render()
    {
        return view('livewire.login-manager')->layout('layout.app');
    }
}