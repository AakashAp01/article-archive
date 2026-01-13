<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchApi(Request $request)
    {
        $query = $request->get('q');

        $articles = Article::query()
            ->where('status', 'published')
            ->where(function ($q) use ($query) {

                // Search in title + content
                $q->when($query, function ($sub) use ($query) {
                    $sub->where('title', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%");
                });

                // Search in category name
                $q->when($query, function ($sub) use ($query) {
                    $sub->orWhereHas('category', function ($cat) use ($query) {
                        $cat->where('name', 'like', "%{$query}%");
                    });
                });
            })
            ->with('category')
            ->get();

        return response()->json([
            'data' => $articles
        ]);
    }

    public function fetchViewport(Request $request)
    {
        // Validate the bounding box sent from React
        $validated = $request->validate([
            'min_x' => 'required|integer',
            'max_x' => 'required|integer',
            'min_y' => 'required|integer',
            'max_y' => 'required|integer',
        ]);

        $articles = Article::query()
            // OPTIMIZATION: Only select what the Card needs. No 'content' (too heavy).
            ->select('id', 'title', 'slug', 'excerpt', 'category_id', 'tags', 'date', 'x', 'y','thumbnail')
            ->with('category:id,name,color_code')
            ->withCount('likes')
            ->whereBetween('x', [$validated['min_x'], $validated['max_x']])
            ->whereBetween('y', [$validated['min_y'], $validated['max_y']])
            ->where('status', 'published')
            ->get();
        return response()->json($articles);
    }

    public function fetchMap()
    {

        $points = Article::query()
            ->select('id', 'title', 'slug', 'x', 'y', 'category_id')
             ->where('status', 'published')
            ->with('category:id,name,color_code')
            ->get();

        return response()->json($points);
    }

    public function fetchBounds()
    {
        $maxX = Article::selectRaw('MAX(ABS(x)) as max_x')->value('max_x');
        $maxY = Article::selectRaw('MAX(ABS(y)) as max_y')->value('max_y');
        $limit = max($maxX, $maxY);

        return response()->json([
            'limit' => $limit
        ]);
    }
}
