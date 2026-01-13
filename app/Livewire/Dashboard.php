<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleLike;
use App\Models\ArticleReport;
use App\Models\Newsletter;
use App\Models\Comment;
use App\Models\Report; // Ensure Report model is imported
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // 1. KPI Cards Data
        $stats = [
            'users' => User::count(),
            'articles' => Article::count(),
            'subscribers' => Newsletter::count(),
            'comments' => Comment::count(),
            'likes' => ArticleLike::count(),
        ];


        $topArticles = Article::with('category')
            ->withCount(['likes', 'comments','reports'])
            ->orderBy('likes_count', 'desc')
            ->orderBy('comments_count', 'desc')
            ->take(10)
            ->get();


        // 3. Graph Data (Last 6 Months)
        $graphData = $this->getMonthlyTrends();

        return view('livewire.dashboard', [
            'stats' => $stats,
            'topArticles' => $topArticles,
            'chartLabels' => $graphData['labels'],
            'chartUsers' => $graphData['users'],
            'chartArticles' => $graphData['articles'],
            'chartSubs' => $graphData['subscribers'],
            'chartReports' => $graphData['reports'],
        ])->layout('layout.app');
    }

    private function getMonthlyTrends()
    {
        $labels = [];
        $users = [];
        $articles = [];
        $subs = [];
        $reports = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $year = $date->format('Y');
            $month = $date->format('m');

            $labels[] = strtoupper($date->format('M'));

            $users[] = User::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
            $articles[] = Article::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
            $subs[] = Newsletter::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
            $reports[] = ArticleReport::whereYear('created_at', $year)->whereMonth('created_at', $month)->count(); 
        }

        return [
            'labels' => $labels,
            'users' => $users,
            'articles' => $articles,
            'subscribers' => $subs,
            'reports' => $reports
        ];
    }
}