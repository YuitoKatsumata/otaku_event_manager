<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventify - ダッシュボード</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Noto Sans JP"', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0284c7',
                            600: '#0369a1',
                            700: '#075985',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased min-h-screen">

    <!-- HEADER -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">

            <!-- ロゴ & 検索バー -->
            <div class="flex items-center gap-6 flex-1">
                <a href="#" class="text-2xl font-bold tracking-tight text-slate-900 flex-shrink-0">
                    Event<span class="text-brand-500">ify</span>
                </a>

                <!-- ヘッダー埋め込み型の検索バー（実用的！） -->
                <div class="relative max-w-md w-full hidden sm:block">
                    <input type="text" placeholder="イベント名・アーティスト・会場で検索..." class="w-full pl-9 pr-4 py-2 text-sm bg-slate-100 border border-transparent rounded-xl focus:bg-white focus:border-brand-500 focus:outline-none transition">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <!-- 右側ナビゲーション＆ユーザーエリア -->
            <div class="flex items-center gap-3">
                <button type="button" class="bg-brand-500 hover:bg-brand-600 text-white font-medium text-sm py-2 px-4 rounded-xl shadow-sm transition active:scale-[0.98] flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span class="hidden sm:inline">イベント追加</span>
                </button>

                <!-- 通知アイコン -->
                <button type="button" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 01-6 0v-1m6 0H9"/></svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full"></span>
                </button>

                <!-- ユーザーアバター -->
                <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 font-bold text-xs flex items-center justify-center border border-brand-200 cursor-pointer">
                    TK
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white font-medium text-sm py-2 px-4 rounded-xl shadow-sm transition active:scale-[0.98] flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span class="hidden sm:inline">ログアウト</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- DASHBOARD HEADER（挨拶 ＋ 概要スタッツ） -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">ようこそ、{{ Auth::user()->name }}さん</h1>
                <p class="text-xs text-slate-500 mt-1">次のイベント「Re:ゼロ 10周年記念展」まであと <span class="text-brand-600 font-bold">12日</span> です！</p>
            </div>

            <!-- コンパクトになったスタッツエリア -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-6">
                <div>
                    <div class="text-xs text-slate-400 font-medium">参加済み</div>
                    <div class="text-xl font-bold text-slate-800">24 <span class="text-xs text-slate-400 font-normal">件</span></div>
                </div>
                <div>
                    <div class="text-xs text-slate-400 font-medium">参加予定</div>
                    <div class="text-xl font-bold text-brand-600">8 <span class="text-xs text-slate-400 font-normal">件</span></div>
                </div>
                <div>
                    <div class="text-xs text-slate-400 font-medium">今月</div>
                    <div class="text-xl font-bold text-slate-800">3 <span class="text-xs text-slate-400 font-normal">件</span></div>
                </div>
                <div>
                    <div class="text-xs text-slate-400 font-medium">行きたい</div>
                    <div class="text-xl font-bold text-slate-800">12 <span class="text-xs text-slate-400 font-normal">件</span></div>
                </div>
            </div>
        </div>

        <!-- LAYOUT GRID (メインコンテンツ ＋ サイドバー) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- LEFT 2 COLUMNS: イベント一覧 -->
            <div class="lg:col-span-2 space-y-6">

                <!-- フィルターチップ ＆ 並び替え -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0 scrollbar-none">
                        <button class="px-3.5 py-1.5 text-xs font-semibold bg-brand-500 text-white rounded-xl whitespace-nowrap shadow-sm shadow-brand-500/20">すべて</button>
                        <button class="px-3.5 py-1.5 text-xs font-medium bg-white text-slate-600 hover:bg-slate-100 border border-slate-200 rounded-xl whitespace-nowrap transition">アニメ</button>
                        <button class="px-3.5 py-1.5 text-xs font-medium bg-white text-slate-600 hover:bg-slate-100 border border-slate-200 rounded-xl whitespace-nowrap transition">ライブ</button>
                        <button class="px-3.5 py-1.5 text-xs font-medium bg-white text-slate-600 hover:bg-slate-100 border border-slate-200 rounded-xl whitespace-nowrap transition">ゲーム</button>
                        <button class="px-3.5 py-1.5 text-xs font-medium bg-white text-slate-600 hover:bg-slate-100 border border-slate-200 rounded-xl whitespace-nowrap transition">声優</button>
                    </div>

                    <select class="text-xs text-slate-600 bg-white border border-slate-200 rounded-xl px-3 py-1.5 focus:outline-none self-end sm:self-auto">
                        <option>開催日が近い順</option>
                        <option>最近追加した順</option>
                    </select>
                </div>

                <!-- CARDS GRID -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <!-- Card 1 -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden hover:shadow-md transition group cursor-pointer flex flex-col justify-between">
                        <div>
                            <!-- カバー領域（単一の絵文字ではなくビジュアルヘッダー風に） -->
                            <div class="h-28 bg-gradient-to-br from-sky-400 to-brand-600 p-4 relative flex items-end">
                                <span class="bg-white/90 backdrop-blur-md text-brand-700 text-[10px] font-bold px-2.5 py-1 rounded-lg">アニメ</span>
                            </div>
                            <div class="p-4 space-y-2">
                                <h3 class="font-bold text-slate-800 text-sm group-hover:text-brand-600 transition">Re:ゼロ 10周年記念展</h3>
                                <div class="text-xs text-slate-500 space-y-1">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>2026年7月12日（土）</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>池袋サンシャインシティ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 pb-4 pt-2 border-t border-slate-50 flex items-center justify-between">
                            <span class="bg-amber-50 text-amber-700 text-[10px] font-semibold px-2 py-0.5 rounded-md border border-amber-200/60">参加予定</span>
                            <span class="text-xs font-semibold text-brand-600 group-hover:translate-x-0.5 transition-transform flex items-center gap-0.5">詳細 →</span>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden hover:shadow-md transition group cursor-pointer flex flex-col justify-between">
                        <div>
                            <div class="h-28 bg-gradient-to-br from-purple-500 to-indigo-600 p-4 relative flex items-end">
                                <span class="bg-white/90 backdrop-blur-md text-purple-700 text-[10px] font-bold px-2.5 py-1 rounded-lg">ライブ</span>
                            </div>
                            <div class="p-4 space-y-2">
                                <h3 class="font-bold text-slate-800 text-sm group-hover:text-brand-600 transition">アニサマ2026 DAY1</h3>
                                <div class="text-xs text-slate-500 space-y-1">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>2026年8月23日（土）</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>さいたまスーパーアリーナ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 pb-4 pt-2 border-t border-slate-50 flex items-center justify-between">
                            <span class="bg-brand-50 text-brand-700 text-[10px] font-semibold px-2 py-0.5 rounded-md border border-brand-200/60">発券済み</span>
                            <span class="text-xs font-semibold text-brand-600 group-hover:translate-x-0.5 transition-transform flex items-center gap-0.5">詳細 →</span>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden hover:shadow-md transition group cursor-pointer flex flex-col justify-between">
                        <div>
                            <div class="h-28 bg-gradient-to-br from-emerald-400 to-teal-600 p-4 relative flex items-end">
                                <span class="bg-white/90 backdrop-blur-md text-teal-700 text-[10px] font-bold px-2.5 py-1 rounded-lg">ゲーム</span>
                            </div>
                            <div class="p-4 space-y-2">
                                <h3 class="font-bold text-slate-800 text-sm group-hover:text-brand-600 transition">アークナイツ 周年イベント</h3>
                                <div class="text-xs text-slate-500 space-y-1">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>2026年6月15日（月）</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>東京ビッグサイト</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 pb-4 pt-2 border-t border-slate-50 flex items-center justify-between">
                            <span class="bg-slate-100 text-slate-500 text-[10px] font-semibold px-2 py-0.5 rounded-md">参加済み</span>
                            <span class="text-xs font-semibold text-brand-600 group-hover:translate-x-0.5 transition-transform flex items-center gap-0.5">詳細 →</span>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden hover:shadow-md transition group cursor-pointer flex flex-col justify-between">
                        <div>
                            <div class="h-28 bg-gradient-to-br from-rose-400 to-orange-500 p-4 relative flex items-end">
                                <span class="bg-white/90 backdrop-blur-md text-rose-700 text-[10px] font-bold px-2.5 py-1 rounded-lg">声優</span>
                            </div>
                            <div class="p-4 space-y-2">
                                <h3 class="font-bold text-slate-800 text-sm group-hover:text-brand-600 transition">花澤香菜 LIVE TOUR 2026</h3>
                                <div class="text-xs text-slate-500 space-y-1">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>2026年5月18日（日）</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>Zepp Shinjuku</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 pb-4 pt-2 border-t border-slate-50 flex items-center justify-between">
                            <span class="bg-slate-100 text-slate-500 text-[10px] font-semibold px-2 py-0.5 rounded-md">参加済み</span>
                            <span class="text-xs font-semibold text-brand-600 group-hover:translate-x-0.5 transition-transform flex items-center gap-0.5">詳細 →</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- RIGHT 1 COLUMN: サイドバー（実用的な機能情報） -->
            <div class="space-y-6">

                <!-- 今後のタイムライン -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold text-slate-800 text-sm">直近のスケジュール</h2>
                        <a href="#" class="text-xs text-brand-600 font-semibold hover:underline">カレンダーで見る</a>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition">
                            <div class="bg-brand-50 text-brand-700 rounded-xl p-2 text-center min-w-[48px] border border-brand-100">
                                <div class="text-[10px] font-bold uppercase tracking-wider">7月</div>
                                <div class="text-base font-bold leading-none">12</div>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-800 truncate">Re:ゼロ 10周年記念展</p>
                                <p class="text-[11px] text-slate-400 truncate">池袋サンシャインシティ</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition">
                            <div class="bg-purple-50 text-purple-700 rounded-xl p-2 text-center min-w-[48px] border border-purple-100">
                                <div class="text-[10px] font-bold uppercase tracking-wider">8月</div>
                                <div class="text-base font-bold leading-none">23</div>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-800 truncate">アニサマ2026 DAY1</p>
                                <p class="text-[11px] text-slate-400 truncate">さいたまスーパーアリーナ</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition">
                            <div class="bg-purple-50 text-purple-700 rounded-xl p-2 text-center min-w-[48px] border border-purple-100">
                                <div class="text-[10px] font-bold uppercase tracking-wider">8月</div>
                                <div class="text-base font-bold leading-none">24</div>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-800 truncate">アニサマ2026 DAY2</p>
                                <p class="text-[11px] text-slate-400 truncate">さいたまスーパーアリーナ</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- リアルなアプリっぽさを出す「リマインダー /ToDo」ウィジェット -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white p-5 rounded-2xl shadow-sm space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-brand-400 tracking-wider uppercase">Ticket Reminder</span>
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                    </div>
                    <div>
                        <p class="text-sm font-bold">アニサマ2026 発券開始</p>
                        <p class="text-xs text-slate-300 mt-1">8月10日(金) 10:00〜 コンビニ発券可能</p>
                    </div>
                    <button class="w-full bg-white/10 hover:bg-white/20 text-xs font-medium py-2 rounded-xl backdrop-blur-sm transition">
                        詳細を確認する
                    </button>
                </div>

            </div>

        </div>

    </main>

</body>
</html>
