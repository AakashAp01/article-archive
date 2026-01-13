<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // Required for images
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // or Imagick
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ArticleManager extends Component
{
    use WithFileUploads;

    // --- Form Properties ---
    public $title;
    public $slug;
    public $excerpt;
    public $content;
    public $thumbnail;
    public $existingThumbnail; 
    
    // Grid Logic
    public $x = 0;
    public $y = 0;
    
    // Taxonomy
    public $category_name;
    public $tags;
    public $date;

    // SEO
    public $meta_title;
    public $meta_description;

    public $articleId = null;

    // --- Lifecycle Hooks ---
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
            $this->tags = $article->tags; // Assuming string storage
            $this->meta_title = $article->meta_title;
            $this->meta_description = $article->meta_description;
            $this->existingThumbnail = $article->thumbnail;
            $this->date = $article->date->format('Y-m-d');
        }
    }

    // Auto-generate slug when title updates
    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
        
        // Auto-fill Meta Title if empty
        if(empty($this->meta_title)) {
            $this->meta_title = substr($value, 0, 60);
        }
    }

    public function updatedExcerpt($value)
    {
        // Auto-fill Meta Description if empty
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

        // 1. Handle Image Optimization
        $thumbnailPath = $this->existingThumbnail;

        if ($this->thumbnail) {
            // Create Manager instance with driver
            $manager = new ImageManager(new Driver());
            
            // Read image
            $image = $manager->read($this->thumbnail->getRealPath());
            
            // Resize (Max width 800px, constrain aspect ratio)
            $image->scale(width: 800);

            // Encode to WebP (Lightweight)
            $encoded = $image->toWebp(quality: 80);

            // Generate Filename
            $filename = 'thumbnails/' . Str::random(40) . '.webp';

            // Save to Storage
            Storage::disk('public')->put($filename, (string) $encoded);
            $thumbnailPath = $filename;
        }

        // 2. Handle Category (Find or Create)
        $category = Category::firstOrCreate(
            ['name' => $this->category_name],
            ['slug' => Str::slug($this->category_name), 'color_code' => '#00ff88'] // Default color
        );

        // 3. Create/Update Article
        Article::updateOrCreate(
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

        $this->dispatch('show-toast', [
            'type' => 'success', 
            'title' => 'Saved!', 
            'message' => 'Article Saved Successfully.'
        ]);

        // Optional: Redirect
        // return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.article-manager', [
            'categories' => Category::all()
        ])->layout('layout.app');
    }
}