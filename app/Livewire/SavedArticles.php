<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use App\Models\Category;

class SavedArticles extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    
    // Modal State
    public $isDeleteModalOpen = false;
    public $deleteId = null;

    public function updatedSearch() { $this->resetPage(); }
    public function updatedCategoryFilter() { $this->resetPage(); }

    // 1. Open Confirmation Modal
    public function confirmRemove($articleId)
    {
        $this->deleteId = $articleId;
        $this->isDeleteModalOpen = true;
    }

    // 2. Close Modal
    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
        $this->deleteId = null;
    }

    // 3. Perform Removal
    public function remove()
    {
        if ($this->deleteId) {
            Auth::user()->savedArticles()->detach($this->deleteId);
            
            $this->dispatch('show-toast', [
                'type' => 'info',
                'title' => 'Removed',
                'message' => 'Article removed from your saved list.'
            ]);
        }
        
        $this->closeDeleteModal();
    }

    public function render()
    {
        $categories = Category::has('articles')->get();
        $query = Auth::user()->savedArticles();

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        return view('livewire.saved-articles', [
            'articles' => $query->latest()->paginate(9),
            'categories' => $categories
        ])->layout('layout.app');
    }
}