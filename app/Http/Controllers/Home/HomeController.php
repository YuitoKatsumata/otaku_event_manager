<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use App\Enums\EventStatus;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // イベントデータを取得
        $events = Event::with('category', 'user')
            ->orderBy('event_date', 'asc')
            ->limit(6)
            ->get();

        // カテゴリと各ステータスの件数を取得
        $categories = Category::all();
        $completedCount = Event::where('status', EventStatus::Completed->value)->count();
        $scheduledCount = Event::where('status', EventStatus::Scheduled->value)->count();
        // 今月のイベントの件数を取得
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $monthlyCount = Event::whereYear('event_date', $currentYear)
            ->whereMonth('event_date', $currentMonth)
            ->count();

        return view('home', compact('events', 'categories', 'completedCount', 'scheduledCount', 'monthlyCount'));
    }
}
