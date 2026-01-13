<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsManager extends Component
{
    public $activeGroup = 'site';
    public $settings = [];
    
    public $isAddGroupModalOpen = false;
    public $isEditGroupModalOpen = false;
    public $isDeleteGroupModalOpen = false;
    public $isAddKeyModalOpen = false;
    public $isDeleteModalOpen = false;
    
    public $newGroupName = '';
    public $editingGroupName = ''; 
    public $newKey = '';
    public $newValue = '';
    
    public $deleteId = null;

    public function mount()
    {
        // If no groups exist at all, ensure 'site' works
        if (Setting::count() === 0) {
            $this->activeGroup = 'site';
        } else {
            // Ensure we start on a valid group
            $firstGroup = Setting::value('group');
            if (!Setting::where('group', $this->activeGroup)->exists()) {
                $this->activeGroup = $firstGroup;
            }
        }
        
        $this->loadSettings();
    }

    public function loadSettings()
    {
        // FIX: Removed the aggressive check that forced redirection.
        // We now trust $activeGroup is set correctly by the methods.
        $this->settings = Setting::where('group', $this->activeGroup)->get();
    }

    public function switchTab($group)
    {
        $this->activeGroup = $group;
        $this->loadSettings();
    }

    public function updateSetting($id, $value)
    {
        $setting = Setting::find($id);
        if ($setting) {
            $setting->update(['value' => $value]);
            $this->clearCache($setting->group, $setting->key);
            $this->dispatch('show-toast', ['type' => 'success', 'title' => 'Saved', 'message' => 'Configuration synced.']);
        }
    }

    // --- MODULE MANAGEMENT ---
    public function openAddGroupModal() { $this->isAddGroupModalOpen = true; $this->resetValidation(); $this->newGroupName = ''; }
    public function closeAddGroupModal() { $this->isAddGroupModalOpen = false; }

    public function createGroup()
    {
        $this->validate(['newGroupName' => 'required|alpha_dash']);

        if (Setting::where('group', $this->newGroupName)->exists()) {
            $this->addError('newGroupName', 'This module already exists.');
            return;
        }
        
        Setting::create([
            'group' => $this->newGroupName,
            'key' => 'module_name', 
            'value' => ucfirst(str_replace('_', ' ', $this->newGroupName)),
            'is_locked' => 0
        ]);

        $this->activeGroup = $this->newGroupName;
        $this->loadSettings(); 
        $this->closeAddGroupModal();
        
        $this->dispatch('show-toast', ['type' => 'success', 'title' => 'Saved!', 'message' => 'Configuration module created.']);
    }

    public function openEditGroupModal() 
    { 
        $this->editingGroupName = $this->activeGroup;
        $this->isEditGroupModalOpen = true; 
    }
    
    public function closeEditGroupModal() { $this->isEditGroupModalOpen = false; }

    public function updateGroup()
    {
        $this->validate(['editingGroupName' => 'required|alpha_dash']);

        if ($this->editingGroupName !== $this->activeGroup) {
            Setting::where('group', $this->activeGroup)->update(['group' => $this->editingGroupName]);
            $this->activeGroup = $this->editingGroupName;
            $this->dispatch('show-toast', ['type' => 'success', 'title' => 'Saved!', 'message' => 'Module updated.']);
        }

        $this->loadSettings();
        $this->closeEditGroupModal();
    }

    public function openDeleteGroupModal() { $this->isDeleteGroupModalOpen = true; }
    public function closeDeleteGroupModal() { $this->isDeleteGroupModalOpen = false; }

    public function deleteGroup()
    {
        Setting::where('group', $this->activeGroup)->delete();
        
        $this->dispatch('show-toast', ['type' => 'error', 'title' => 'Deleted!', 'message' => 'Module deleted.']);
        

        $this->activeGroup = Setting::value('group') ?? 'site';
        $this->loadSettings();
        $this->closeDeleteGroupModal();
    }

    // --- KEY MANAGEMENT ---
    public function openAddKeyModal() { $this->isAddKeyModalOpen = true; $this->resetValidation(); $this->reset(['newKey', 'newValue']); }
    public function closeAddKeyModal() { $this->isAddKeyModalOpen = false; }

    public function addSetting()
    {
        $this->validate([
            'newKey' => 'required|string|alpha_dash',
            'newValue' => 'nullable|string',
        ]);

        $exists = Setting::where('group', $this->activeGroup)->where('key', $this->newKey)->exists();

        if($exists) {
            $this->addError('newKey', 'Variable already exists.');
            return;
        }

        Setting::create([
            'group' => $this->activeGroup,
            'key' => $this->newKey,
            'value' => $this->newValue,
        ]);

        $this->loadSettings();
        $this->closeAddKeyModal();
        $this->dispatch('show-toast', ['type' => 'success', 'title' => 'Saved!', 'message' => 'Variable stored.']);
    }

    // --- DELETION ---
    public function confirmDelete($id) { $this->deleteId = $id; $this->isDeleteModalOpen = true; }
    public function closeDeleteModal() { $this->isDeleteModalOpen = false; $this->deleteId = null; }

    public function deleteSetting()
    {
        $setting = Setting::find($this->deleteId);
        if ($setting && !$setting->is_locked) {
            $setting->delete();
            $this->clearCache($setting->group, $setting->key);
            
            $this->loadSettings();
            
            $this->dispatch('show-toast', ['type' => 'info', 'title' => 'Removed', 'message' => 'Variable deleted.']);
        }
        $this->closeDeleteModal();
    }

    protected function clearCache($group, $key)
    {
        Cache::forget("setting_{$group}_{$key}");
    }

    public function render()
    {
        $groups = Setting::select('group')->distinct()->pluck('group')->toArray();
        if(empty($groups)) $groups = ['site'];
        
        if (!in_array($this->activeGroup, $groups)) {
            $groups[] = $this->activeGroup;
        }
        sort($groups);

        return view('livewire.settings-manager', ['groups' => $groups])->layout('layout.app');
    }
}