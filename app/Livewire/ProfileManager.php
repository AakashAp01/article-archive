<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileManager extends Component
{
    use WithFileUploads;

    // Profile Data
    public $name;
    public $email;
    public $bio;
    public $website;

    // Avatar Management
    public $avatar;
    public $current_avatar_url;

    // Password Management
    public $current_password;
    public $password;
    public $password_confirmation;
    public $isDeleteModalOpen = false;
    // Account Deletion
    public $delete_password = '';

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->bio = $user->bio;
        $this->website = $user->website;
        $this->current_avatar_url = $user->avatar ?? null;
    }

    // --- 1. Avatar Logic
    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => ['image', 'max:2048'],
        ]);

        $user = Auth::user();

        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->avatar->getRealPath());

        $image->scale(width: 300);
        $encoded = $image->toWebp(quality: 80);

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $filename = 'avatars/' . Str::random(40) . '.webp';
        Storage::disk('public')->put($filename, (string) $encoded);

        $user->update(['avatar' => $filename]);

        // Refresh State
        $this->current_avatar_url = $user->avtar;
        $this->avatar = null;

        $this->dispatch('show-toast', [
            'type' => 'success',
            'title' => 'Saved!',
            'message' => 'Profile image uploaded.'
        ]);
    }

    // --- 2. Profile Details Update ---
    public function updateProfile()
    {
        $user = Auth::user();

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'bio' => ['nullable', 'string', 'max:500'],
            'website' => ['nullable', 'url', 'max:255'],
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'bio' => $this->bio,
            'website' => $this->website,
        ]);

        $this->dispatch('show-toast', [
            'type' => 'success',
            'title' => 'Saved!',
            'message' => 'Profile details updated.'
        ]);
    }

    // --- 3. Password Update ---
    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);

        $this->dispatch('show-toast', [
            'type' => 'success',
            'title' => 'Saved!',
            'message' => 'Password updated successfully.'
        ]);
    }

    public function confirmDelete()
    {
        $this->validate([
            'delete_password' => 'required|current_password',
        ]);
        $this->isDeleteModalOpen = true;
    }

    // --- 4. Account Termination
    public function deleteAccount()
    {
        $this->validate([
            'delete_password' => 'required|current_password',
        ]);

        $user = auth()->user();
        $user->delete();

        auth()->guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.profile-manager')->layout('layout.app');
    }
}
