<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Newsletter;

class NewsletterManager extends Component
{
    use WithPagination;

    public $email;
    public $is_active = true;
    public $search = '';
    public $newsletterId = null;
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    public $idToDelete = null;
    protected function rules()
    {
        return [
            'email' => 'required|email|max:255|unique:newsletters,email,' . $this->newsletterId,
            'is_active' => 'boolean'
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $subscribers = Newsletter::query()
            ->where('email', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.newsletter-manager', [
            'subscribers' => $subscribers
        ])->layout('layout.app');
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['email', 'newsletterId']);
        $this->is_active = true;
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

        Newsletter::updateOrCreate(
            ['id' => $this->newsletterId],
            [
                'email' => $this->email,
                'is_active' => $this->is_active
            ]
        );

        $msg = $this->newsletterId ? 'Subscriber Updated' : 'Subscriber Added';

        $this->dispatch('show-toast', [
            'type' => 'success', 
            'title' => 'Saved!', 
            'message' => $msg
        ]);

        $this->closeModal();
    }

    public function edit($id)
    {
        $sub = Newsletter::findOrFail($id);
        $this->newsletterId = $id;
        $this->email = $sub->email;
        $this->is_active = (bool) $sub->is_active;
        
        $this->isModalOpen = true;
    }

    public function toggleStatus($id)
    {
        $sub = Newsletter::findOrFail($id);
        $sub->is_active = !$sub->is_active;
        $sub->save();

        $statusMsg = $sub->is_active ? 'Subscription Activated' : 'Subscription Paused';

        $this->dispatch('show-toast', [
            'type' => 'success', 
            'title' => 'Status Sync', 
            'message' => $statusMsg
        ]);
    }

    public function confirmDelete($id)
    {
        $this->idToDelete = $id;
        $this->isDeleteModalOpen = true;
    }

    public function delete()
    {
        Newsletter::findOrFail($this->idToDelete)->delete();
        
        $this->dispatch('show-toast', [
            'type' => 'success', 
            'title' => 'Terminated', 
            'message' => 'Subscriber removed from database.'
        ]);
        
        $this->closeModal();
    }
}