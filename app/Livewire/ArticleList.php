<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Article;
use App\Models\Category;

class ArticleList extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = ''; 
    public $statusFilter = '';  

    public $deleteId = null;
    public $isDeleteModalOpen = false;

    public function updatingSearch() { $this->resetPage(); }
    public function updatingCategoryFilter() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }

    public function render()
    {
        $query = Article::query()
            ->with('category')
            ->withCount('comments', 'likes')
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.article-list', [
            'articles' => $query->paginate(10),
            'categories' => Category::orderBy('name')->get()
        ])->layout('layout.app');
    }

    public function toggleStatus($id)
    {
        $article = Article::findOrFail($id);

        if ($article->status === 'published') {
            $article->status = 'draft';
            $msgType = 'success';
            $msgText = 'Article status switched to DRAFT';
        } else {
            $article->status = 'published';
            $msgType = 'success';
            $msgText = 'Article status switched to PUBLISHED';
        }
        
        $article->save();

        $this->dispatch('show-toast', 
            type: $msgType, 
            title: 'Saved!', 
            message: $msgText
        );
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->isDeleteModalOpen = true;
    }

    public function delete()
    {
        Article::findOrFail($this->deleteId)->delete();
        $this->isDeleteModalOpen = false;

        $this->dispatch('show-toast', 
            type: 'success', 
            title: 'Saved!', 
            message: 'Article permanently removed from grid.'
        );

    }
    
    public function goToCreate()
    {
        return redirect()->route('article.create');
    }

}