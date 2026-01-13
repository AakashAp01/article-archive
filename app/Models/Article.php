<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'category_id', 'title', 'slug', 'excerpt', 
        'content', 'x', 'y', 'date', 'tags', 'status',
        'thumbnail',
        'meta_title',
        'meta_description',
    ];

    //JSON <-> Array
    protected $casts = [
        'date' => 'date',
        'tags' => 'array', 
    ];

    public function category() {return $this->belongsTo(Category::class);}
    public function likes() { return $this->hasMany(ArticleLike::class); }
    public function comments() { return $this->hasMany(Comment::class); }
    public function reports() { return $this->hasMany(ArticleReport::class); }

    public function getThumbnailAttribute($value)
    {
        if (!$value) return "";
        return asset('storage/' . $value);
    }
}