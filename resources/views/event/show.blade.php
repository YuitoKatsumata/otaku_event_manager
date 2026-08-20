<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eventify - イベント詳細</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'Noto Sans JP', '-apple-system', 'sans-serif'],
          },
          colors: {
            sky: {
              50: '#F0F9FF',
              100: '#E0F2FE',
              500: '#0284C7',
              600: '#0369A1',
              700: '#075985',
            },
            neutral: {
              50: '#F8FAFC',
              100: '#F1F5F9',
              200: '#E2E8F0',
              300: '#CBD5E1',
              600: '#475569',
              700: '#334155',
              900: '#0F172A',
            }
          }
        }
      }
    }
  </script>
</head>
<body class="bg-neutral-50 text-neutral-900 font-sans min-h-screen flex antialiased">

  <!-- SIDEBAR -->
  <aside class="w-[240px] bg-white border-r border-neutral-200 flex flex-col fixed top-0 bottom-0 left-0 z-50">
    <div class="h-[60px] px-5 flex items-center border-b border-neutral-200">
      <div class="text-lg font-bold text-sky-500 tracking-tight">Event<span class="text-neutral-900">ify</span></div>
    </div>

    <div class="p-3 flex flex-col gap-1">
      <div class="text-[11px] font-bold text-neutral-600 uppercase tracking-wider px-2 pb-1.5">メイン</div>
      <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-md text-neutral-600 text-xs font-medium hover:bg-neutral-100 hover:text-neutral-900 transition-all">ダッシュボード</a>
      <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-md text-neutral-600 text-xs font-medium hover:bg-neutral-100 hover:text-neutral-900 transition-all">イベント一覧</a>
      <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-md text-neutral-600 text-xs font-medium hover:bg-neutral-100 hover:text-neutral-900 transition-all">カレンダー</a>
      <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-md text-neutral-600 text-xs font-medium hover:bg-neutral-100 hover:text-neutral-900 transition-all">ウィッシュリスト</a>
    </div>

    <div class="mt-auto p-4 border-t border-neutral-200 flex items-center gap-2.5">
      <div class="w-8 h-8 rounded-full bg-sky-100 flex items-center justify-center text-xs font-bold text-sky-500">N</div>
      <div class="flex flex-col overflow-hidden">
        <div class="text-xs font-semibold">ノゾミ</div>
        <div class="text-[11px] text-neutral-600">Pro プラン</div>
      </div>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="ml-[240px] flex-1 flex flex-col min-w-0">

    <!-- TOP BAR -->
    <header class="h-[60px] bg-white border-b border-neutral-200 px-7 flex items-center justify-between sticky top-0 z-40">
      <div class="text-xs text-neutral-600 flex items-center gap-1.5">
        <a href="#" class="hover:text-neutral-900">イベント一覧</a>
        <span>/</span>
        <span class="text-neutral-900 font-semibold">詳細</span>
      </div>
      <div class="flex gap-2">
        <a href="#" class="inline-flex items-center justify-center px-3.5 py-1.5 rounded-md text-xs font-semibold border border-neutral-200 bg-white text-neutral-900 hover:bg-neutral-100 transition-all">編集</a>
        <button type="button" class="inline-flex items-center justify-center px-3.5 py-1.5 rounded-md text-xs font-semibold border border-red-300 bg-red-50 text-red-600 hover:bg-red-100 transition-all">削除</button>
      </div>
    </header>

    <!-- CONTENT CONTAINER -->
    <div class="p-6 md:p-7 max-w-[1200px] mx-auto w-full">
      <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-7 items-start">

        <!-- MAIN LEFT CONTENT -->
        <div class="min-w-0">

          <!-- HERO BANNER -->
          @if ($event->image_path)
            <div class="w-full h-60 rounded-xl overflow-hidden relative mb-6 border border-neutral-200">
              <img src="{{ asset('storage/' . $event->image_path) }}" alt="Event Banner" class="w-full h-full object-cover">
              <span class="absolute top-4 left-4 bg-slate-900/75 backdrop-blur-sm text-white text-xs font-bold px-2.5 py-1 rounded-full uppercase">
                  {{ $event->category->name }}
              </span>
            </div>
          @else
            <div class="w-full h-60 rounded-xl overflow-hidden relative mb-6 border border-neutral-200" style="background-color: {{ $event->category->color }};">
                <span class="absolute top-4 left-4 bg-slate-900/75 backdrop-blur-sm text-white text-xs font-bold px-2.5 py-1 rounded-full uppercase">
                    {{ $event->category->name }}
                </span>
            </div>
          @endif

          <!-- EVENT DETAIL CARD -->
          <div class="bg-white border border-neutral-200 rounded-lg p-6 mb-5">
            <div class="mb-5 pb-4 border-b border-neutral-100">
              <h1 class="text-2xl font-bold text-neutral-900 leading-snug mb-3">
                {{ $event->title }}
              </h1>

              <div class="flex flex-col gap-3">
                <div class="flex items-center gap-3 text-sm text-neutral-700">
                  <div class="w-8 h-8 rounded-md bg-neutral-100 flex items-center justify-center text-base shrink-0">📅</div>
                  <div>{{ $event->event_date->format('Y/m/d') }} ({{ $event->event_date->format('D') }})</div>
                </div>
                <div class="flex items-center gap-3 text-sm text-neutral-700">
                  <div class="w-8 h-8 rounded-md bg-neutral-100 flex items-center justify-center text-base shrink-0">📍</div>
                  <div>{{ $event->location }}</div>
                </div>
              </div>
            </div>

            <!-- LINK -->
            <div class="mb-5">
              <div class="text-xs font-bold text-neutral-900 mb-2 flex items-center gap-1.5">🔗 関連リンク</div>
              <a href="{{ $event->event_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-sky-500 text-xs font-semibold hover:underline break-all">
                {{ $event->event_url }} ↗
              </a>
            </div>

            <!-- MEMO -->
            <div>
              <div class="text-xs font-bold text-neutral-900 mb-2 flex items-center gap-1.5">📝 メモ</div>
              <div class="bg-neutral-50 border border-neutral-200 rounded-md p-3.5 text-xs leading-relaxed text-neutral-700 whitespace-pre-wrap">
                {{ $event->description }}
              </div>
            </div>
          </div>

        </div>

        <!-- RIGHT SIDE PANEL -->
        <div class="lg:sticky lg:top-[84px] flex flex-col gap-5">

          <!-- COUNTDOWN WIDGET -->
          <div class="bg-gradient-to-br from-sky-500 to-sky-600 text-white rounded-lg p-5 text-center">
            <div class="text-xs font-semibold opacity-90 mb-1">開催まであと</div>
            <div class="text-4xl font-extrabold tracking-tight leading-none mb-1">
              {{ $limitTime ? $limitTime->days : 0 }}
              <span class="text-base font-semibold ml-0.5">日</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

</body>
</html>
