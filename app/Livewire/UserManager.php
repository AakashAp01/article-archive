<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserManager extends Component
{
    use WithPagination;

    public $name, $email, $password;
    public $type = 'user';
    public $status = 1;
    public $search = '';
    public $userId = null;
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    public $idToDelete = null;

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'type' => 'required|in:admin,user',
            'status' => 'boolean',
        ];

        if (!$this->userId) {
            $rules['password'] = 'required|min:8';
        } else {
            $rules['password'] = 'nullable|min:8';
        }

        return $rules;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::withTrashed()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('deleted_at', 'asc') 
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.user-manager', [
            'users' => $users
        ])->layout('layout.app');
    }

    // Login As User 
    public function loginAsUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->trashed()) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'This account has been deleted.'
            ]);
            return;
        }

        if ($id === Auth::id()) {
            return;
        }

        Auth::login($user);
        return redirect('/'); 
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'email', 'password', 'userId']);
        $this->type = 'user';
        $this->status = 1;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->isDeleteModalOpen = false;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'status' => $this->status,
        ];

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        User::updateOrCreate(['id' => $this->userId], $data);

        $this->dispatch('show-toast', [
            'type' => 'success',
            'title' => 'Saved!',
            'message' => $this->userId ? 'User profile saved.' : 'User added successfully.'
        ]);

        $this->closeModal();
    }

    public function edit($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->trashed()) {
            $this->dispatch('show-toast', ['type' => 'error', 'title' => 'Error', 'message' => 'This record has been deleted and cannot be edited.']);
            return;
        }

        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->type = $user->type;
        $this->status = $user->status;
        $this->password = '';

        $this->isModalOpen = true;
    }

    public function confirmDelete($id)
    {
        $this->idToDelete = $id;
        $this->isDeleteModalOpen = true;
    }

    public function delete()
    {
        $user = User::withTrashed()->findOrFail($this->idToDelete);

        if ($user->trashed()) {
            // If already soft deleted, force delete
            $user->forceDelete();
            $msg = 'Record Permanently Removed';
        } else {
            // Soft delete
            $user->delete();
            $msg = 'User Deleted Successfully';
        }

        $this->dispatch('show-toast', [
            'type' => 'success',
            'title' => 'Removed',
            'message' => $msg === 'Record Permanently Removed' ? 'User deleted forever.' : 'User removed successfully.'
        ]);
        $this->closeModal();
    }

    // --- TOGGLES ---

    public function toggleStatus($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->trashed()) return;

        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        $msg = $user->status == 1 ? 'User access enabled.' : 'User access disabled.';
        $this->dispatch('show-toast', [
            'type' => $user->status == 1 ? 'success' : 'warning',
            'title' => 'Access',
            'message' => $msg
        ]);
    }

    public function toggleType($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->trashed()) return;

        $user->type = $user->type === 'admin' ? 'user' : 'admin';
        $user->save();

        $this->dispatch('show-toast', ['type' => 'success', 'title' => 'Saved!', 'message' => "Role changed to " . strtoupper($user->type)]);
    }

    public function toggleVerification($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->trashed()) return;

        $msg = $user->email_verified_at ? 'Email verified successfully.' : 'Email verification removed.';
        $this->dispatch('show-toast', ['type' => 'success', 'title' => 'Updated!', 'message' => $msg]);
    }


    // --- NEW: Restore User ---
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        $this->dispatch('show-toast', [
            'type' => 'success',
            'title' => 'Restored!',
            'message' => 'The user account has been restored.'
        ]);
    }
}
