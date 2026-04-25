<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; 
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; 
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ArticleManager extends Component
{
    use WithFileUploads;

    public $title;
    public $slug;
    public $excerpt;
    public $content;
    public $thumbnail;
    public $existingThumbnail; 
    
    public $x = 0;
    public $y = 0;
    
    public $category_name;
    public $tags;
    public $date;

    public $meta_title;
    public $meta_description;

    public $articleId = null;

    public function mount($id = null)
    {
        $this->date = now()->format('Y-m-d');

        if ($id) {
            $article = Article::findOrFail($id);
            $this->articleId = $id;
            $this->title = $article->title;
            $this->slug = $article->slug;
            $this->excerpt = $article->excerpt;
            $this->content = $article->content;
            $this->x = $article->x;
            $this->y = $article->y;
            $this->category_name = $article->category ? $article->category->name : '';
            $this->tags = $article->tags; 
            $this->meta_title = $article->meta_title;
            $this->meta_description = $article->meta_description;
            $this->existingThumbnail = $article->getRawOriginal('thumbnail');
            $this->date = $article->date->format('Y-m-d');
        }
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
        
        if(empty($this->meta_title)) {
            $this->meta_title = substr($value, 0, 60);
        }
    }

    public function updatedExcerpt($value)
    {
        
        if(empty($this->meta_description)) {
            $this->meta_description = substr($value, 0, 160);
        }
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|min:3',
            'slug' => 'required|unique:articles,slug,' . $this->articleId,
            'content' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
            'category_name' => 'required',
        ]);

        $thumbnailPath = $this->existingThumbnail;

        if ($this->thumbnail) {
            
            $manager = new ImageManager(new Driver());
            
            $image = $manager->read($this->thumbnail->getRealPath());
            
            $image->scale(width: 800);

            $encoded = $image->toWebp(quality: 80);

            $filename = 'thumbnails/' . Str::random(40) . '.webp';

            Storage::disk('public')->put($filename, (string) $encoded);
            $thumbnailPath = $filename;
        }

        $category = Category::firstOrCreate(
            ['name' => $this->category_name],
            ['slug' => Str::slug($this->category_name), 'color_code' => '#00ff88'] 
        );

        $article = Article::updateOrCreate(
            ['id' => $this->articleId],
            [
                'title' => $this->title,
                'slug' => $this->slug,
                'excerpt' => $this->excerpt,
                'content' => $this->content,
                'thumbnail' => $thumbnailPath,
                'x' => $this->x,
                'y' => $this->y,
                'category_id' => $category->id,
                'tags' => $this->tags,
                'date' => $this->date,
                'meta_title' => $this->meta_title,
                'meta_description' => $this->meta_description,
            ]
        );

        if ($this->thumbnail && $this->existingThumbnail && $this->existingThumbnail !== $thumbnailPath) {
            Storage::disk('public')->delete($this->existingThumbnail);
        }

        $this->articleId = $article->id;
        $this->existingThumbnail = $article->getRawOriginal('thumbnail');
        $this->thumbnail = null;

        $this->dispatch('show-toast', [
            'type' => 'success', 
            'title' => 'Saved!', 
            'message' => 'Article saved successfully.'
        ]);

    }

    public function render()
    {
        return view('livewire.article-manager', [
            'categories' => Category::all()
        ])->layout('layout.app');
    }
}