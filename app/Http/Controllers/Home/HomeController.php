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
        $user = Auth::user();

        // ログインユーザーのイベントデータを取得
        $events = $user->events()
            ->with('category')
            ->orderBy('event_date', 'asc')
            ->limit(6)
            ->get();

        // カテゴリ一覧を取得
        $categories = Category::orderBy('sort_order', 'asc')->get();

        // ログインユーザーの各ステータス件数を取得（新旧両方の値に対応）
        $completedCount = $user->events()->whereIn('status', [EventStatus::Completed->value, '参加済み'])->count();
        $scheduledCount = $user->events()->whereIn('status', [EventStatus::Scheduled->value, '参加予定'])->count();

        // ログインユーザーの今月のイベント件数を取得
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $monthlyCount = $user->events()
            ->whereYear('event_date', $currentYear)
            ->whereMonth('event_date', $currentMonth)
            ->count();

        return view('home', compact('events', 'categories', 'completedCount', 'scheduledCount', 'monthlyCount'));
    }
}
