<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class CategoryManager extends Component
{
    use WithPagination;

    // --- State Variables ---
    public $name;
    public $color_code = '#00ff00';
    public $status = true;
    public $search = '';
    public $categoryId = null;
    
    // --- UI Controls ---
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    public $categoryToDelete = null;

    // --- Validation Rules ---
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $this->categoryId,
            'color_code' => 'required|string|max:7',
            'status' => 'boolean'
        ];
    }

    // --- Lifecycle Hooks ---
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.category-manager', [
            'categories' => $categories
        ])->layout('layout.app');
    }

    // --- Modal Logic ---
    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'color_code', 'categoryId']);
        $this->color_code = '#00ff00';
        $this->status = true;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->isDeleteModalOpen = false;
    }

    // --- CRUD Actions ---
    public function store()
    {
        $this->validate();

        Category::updateOrCreate(
            ['id' => $this->categoryId],
            [
                'name' => $this->name,
                'color_code' => $this->color_code,
                'status' => $this->status
            ]
        );

        $actionType = $this->categoryId ? 'Updated' : 'Created';

        $this->dispatch('show-toast', [
            'type' => 'success', 
            'title' => 'Saved!', 
            'message' => "Category {$actionType} Successfully"
        ]);

        $this->closeModal();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->color_code = $category->color_code;
        $this->status = (bool) $category->status;
        
        $this->isModalOpen = true;
    }

    // --- Status Toggling ---
    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);
        $category->status = !$category->status;
        $category->save();

        $this->dispatch('show-toast', [
            'type' => 'success', 
            'title' => 'Saved!', 
            'message' => 'Category visibility changed.'
        ]);
    }

    // --- Deletion ---
    public function confirmDelete($id)
    {
        $this->categoryToDelete = $id;
        $this->isDeleteModalOpen = true;
    }

    public function delete()
    {
        Category::findOrFail($this->categoryToDelete)->delete();
        
        $this->dispatch('show-toast', [
            'type' => 'success', 
            'title' => 'Deleted', 
            'message' => 'Category removed from taxonomy.'
        ]);
        
        $this->closeModal();
    }
}