<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleReport extends Model
{
    protected $fillable = [
        'user_id', 'article_id','reason'
    ];
}
