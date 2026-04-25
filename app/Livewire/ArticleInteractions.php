<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleInteractions extends Component
{
    public Article $article;
    
    public $body = '';
    public $replyBody = '';
    public $replyingTo = null;
    public $reportReason = ''; 

    protected $rules = [
        'body' => 'required|min:3|max:1000',
        'reportReason' => 'required|string|in:spam,harassment,misinformation,other',
        'replyBody' => 'required|min:3|max:1000',
    ];

    public function mount(Article $article)
    {
        $this->article = $article;
    }

    public function toggleSave()
    {
        if (!Auth::check()) return redirect()->route('login');

        $user = Auth::user();

        if ($user->savedArticles()->where('article_id', $this->article->id)->exists()) {
            $user->savedArticles()->detach($this->article->id);
            $msg = 'Article removed from saved list.';
        } else {
            $user->savedArticles()->attach($this->article->id);
            $msg = 'Article saved successfully.';
        }

        $this->dispatch('trigger-toast', type: 'success', title: 'Saved!', message: $msg);
    }

    public function toggleLike()
    {
        if (!Auth::check()) return redirect()->route('login');

        $userId = Auth::id();
        $existingLike = $this->article->likes()->where('user_id', $userId)->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            $this->article->likes()->create(['user_id' => $userId]);
        }
    }

    public function report()
    {
        if (!Auth::check()) return redirect()->route('login');

        $this->validate(['reportReason' => 'required|string|max:255']);

        if (!$this->article->reports()->where('user_id', Auth::id())->exists()) {
            $this->article->reports()->create([
                'user_id' => Auth::id(),
                'reason' => $this->reportReason,
            ]);
            $this->dispatch('trigger-toast', type: 'success', title: 'Sent', message: "Thank you. We'll look into this soon.");
        } else {
            $this->dispatch('trigger-toast', type: 'warning', title: 'Wait', message: "You've already reported this.");
        }

        $this->reset('reportReason');
        $this->dispatch('close-report-modal');
    }

    public function postComment()
    {
        $this->validate(['body' => 'required|min:3|max:1000']);
        if (!Auth::check()) return redirect()->route('login');

        $this->article->comments()->create([
            'user_id' => Auth::id(),
            'body' => $this->body,
            'parent_id' => null
        ]);

        $this->body = '';
        $this->dispatch('trigger-toast', type: 'success', title: 'Posted!', message: 'Your comment is now live.');
    }

    public function setReplyingTo($commentId)
    {
        $this->replyingTo = $commentId;
        $this->replyBody = '';
    }

    public function cancelReply()
    {
        $this->replyingTo = null;
        $this->replyBody = '';
    }

    public function postReply($parentId)
    {
        $this->validate(['replyBody' => 'required|min:3|max:1000']);
        if (!Auth::check()) return redirect()->route('login');

        $this->article->comments()->create([
            'user_id' => Auth::id(),
            'body' => $this->replyBody,
            'parent_id' => $parentId
        ]);

        $this->replyingTo = null;
        $this->replyBody = '';
        $this->dispatch('trigger-toast', type: 'success', title: 'Posted!', message: 'Your reply is now live.');
    }

    public function render()
    {
        $user = Auth::user();
        
        return view('livewire.article-interactions', [
            'isLiked' => $user ? $this->article->likes()->where('user_id', $user->id)->exists() : false,
            'isSaved' => $user ? $user->savedArticles()->where('article_id', $this->article->id)->exists() : false, 
            'comments' => $this->article->comments()->whereNull('parent_id')->with('user', 'replies.user')->latest()->get(),
            'commentsCount' => $this->article->comments()->count(),
        ]);
    }
}