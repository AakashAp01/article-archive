<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        $recommendedArticles = Article::where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        $nextRead = $recommendedArticles->first();

        return view('reader', compact('article', 'recommendedArticles', 'nextRead'));
    }

}
