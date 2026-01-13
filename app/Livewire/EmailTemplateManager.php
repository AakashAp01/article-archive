<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmailTemplate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\DynamicTemplateMail;

class EmailTemplateManager extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    // Form Fields
    public $template_id;
    public $name, $key, $subject, $content, $theme_color = '#00ff88';

    // UI States
    public $showTestModal = false;
    public $testEmail = '';
    public $testTemplateId = null;
    public $isDeleteModalOpen = false;
    public $deleteId = null;
    public $isEditMode = false;
    public $showForm = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:255|unique:email_templates,key,' . $this->template_id,
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'theme_color' => 'required|string|max:7',
        ];
    }

    public function create()
    {
        $this->resetFields();
        $this->showForm = true;
        $this->isEditMode = false;
        $this->dispatch('update-editor-content', content: '');
    }

    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $this->template_id = $id;
        $this->name = $template->name;
        $this->key = $template->key;
        $this->subject = $template->subject;
        $this->content = $template->content;
        $this->theme_color = $template->theme_color ?? '#00ff88';
        $this->showForm = true;
        $this->isEditMode = true;
        $this->dispatch('update-editor-content', content: $this->content);
    }

    public function store()
    {
        $this->validate();
        $this->key = Str::slug($this->key, '_');

        EmailTemplate::updateOrCreate(
            ['id' => $this->template_id],
            [
                'name' => $this->name,
                'key' => $this->key,
                'subject' => $this->subject,
                'content' => $this->content,
                'theme_color' => $this->theme_color
            ]
        );

        $this->dispatch('show-toast', [
            'type' => 'success',
            'title' => 'Saved!',
            'message' => 'Email Template saved successfully.'
        ]);

        $this->dispatch('reload-page');
    }

      public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->isDeleteModalOpen = true;
    }

    public function delete()
    {
        if ($this->deleteId) {
            $template = EmailTemplate::find($this->deleteId);
            if ($template) $template->delete();
            $this->dispatch('show-toast', ['type' => 'error', 'title' => 'Deleted!', 'message' => 'Template deleted permanently.']);
        }
        $this->isDeleteModalOpen = false;
    }

    public function openTestModal($id)
    {
        $this->testTemplateId = $id;
        $this->testEmail = auth()->user()->email ?? '';
        $this->showTestModal = true;
    }

    public function closeTestModal()
    {
        $this->showTestModal = false;
    }

    public function sendTestMail()
    {
        $this->validate(['testEmail' => 'required|email']);

        $template = EmailTemplate::find($this->testTemplateId);

        if (!$template) {
            $this->dispatch('show-toast', ['type' => 'error', 'title' => 'Error', 'message' => 'Template not found.']);
            return;
        }

        try {
            // Dummy Data for Placeholders
            $dummyData = [
                'name' => 'Test Subject',
                'role' => 'Tester',
                'url'  => url('/'),
                'app_name' => config('app.name'),
                'email' => $this->testEmail
            ];

            Mail::to($this->testEmail)->send(new DynamicTemplateMail($template, $dummyData));

            $this->dispatch('show-toast', [
                'type' => 'success',
                'title' => 'Test Successful',
                'message' => 'Test email successfully send to ' . $this->testEmail
            ]);

            $this->closeTestModal();
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'title' => 'Transmission Failed',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->resetFields();
    }

    private function resetFields()
    {
        $this->reset(['name', 'key', 'subject', 'content', 'template_id']);
        $this->theme_color = '#00ff88';
    }

    public function render()
    {
        return view('livewire.email-template-manager', [
            'templates' => EmailTemplate::latest()->paginate($this->perPage)
        ])->layout('layout.app');
    }
}
