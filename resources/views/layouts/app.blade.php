<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Eventify - イベント管理')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Google Fonts: 欧文(Inter) × 和文(Noto Sans JP) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">

  <style>
    :root {
      /* カラーシステム：Sky & Neutral */
      --sky-50: #F0F9FF;
      --sky-100: #E0F2FE;
      --sky-200: #BAE6FD;
      --sky-500: #0284C7;
      --sky-600: #0369A1;
      --sky-700: #075985;

      --neutral-50: #F8FAFC;
      --neutral-100: #F1F5F9;
      --neutral-200: #E2E8F0;
      --neutral-300: #CBD5E1;
      --neutral-400: #94A3B8;
      --neutral-500: #64748B;
      --neutral-600: #475569;
      --neutral-700: #334155;
      --neutral-800: #1E293B;
      --neutral-900: #0F172A;

      --sidebar-width: 240px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Inter', 'Noto Sans JP', -apple-system, sans-serif;
      background-color: var(--neutral-50);
      color: var(--neutral-900);
      min-height: 100vh;
      display: flex;
      -webkit-font-smoothing: antialiased;
    }

    /* --------------------------------------------------
       1. SIDEBAR (App Navigation)
    -------------------------------------------------- */
    aside.sidebar {
      width: var(--sidebar-width);
      background: #FFFFFF;
      border-right: 1px solid var(--neutral-200);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; bottom: 0; left: 0;
      z-index: 50;
    }

    .sidebar-header {
      height: 60px;
      padding: 0 20px;
      display: flex;
      align-items: center;
      border-bottom: 1px solid var(--neutral-200);
    }

    .logo {
      font-size: 18px;
      font-weight: 700;
      color: var(--sky-500);
      letter-spacing: -0.5px;
      text-decoration: none;
    }
    .logo span { color: var(--neutral-900); }

    .nav-group {
      padding: 16px 12px;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .nav-label {
      font-size: 11px;
      font-weight: 700;
      color: var(--neutral-600);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 0 8px 6px;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 12px;
      border-radius: 6px;
      color: var(--neutral-600);
      text-decoration: none;
      font-size: 13px;
      font-weight: 500;
      transition: all 0.15s ease;
    }

    .nav-item:hover {
      background: var(--neutral-100);
      color: var(--neutral-900);
    }

    .nav-item.active {
      background: var(--sky-50);
      color: var(--sky-500);
      font-weight: 600;
    }

    .sidebar-footer {
      margin-top: auto;
      padding: 16px;
      border-top: 1px solid var(--neutral-200);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .user-profile {
      display: flex;
      align-items: center;
      gap: 10px;
      overflow: hidden;
    }

    .avatar {
      width: 32px; height: 32px;
      border-radius: 50%;
      background: var(--sky-100);
      display: flex; align-items: center; justify-content: center;
      font-size: 12px; font-weight: 700; color: var(--sky-500);
      flex-shrink: 0;
    }

    .user-info {
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .user-name {
      font-size: 13px;
      font-weight: 600;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .logout-btn {
      background: none;
      border: none;
      color: var(--neutral-400);
      cursor: pointer;
      padding: 6px;
      border-radius: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.15s;
    }
    .logout-btn:hover {
      background: var(--neutral-100);
      color: #EF4444;
    }

    /* --------------------------------------------------
       2. MAIN LAYOUT & HEADER
    -------------------------------------------------- */
    main.main-content {
      margin-left: var(--sidebar-width);
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
    }

    header.top-bar {
      height: 60px;
      background: #FFFFFF;
      border-bottom: 1px solid var(--neutral-200);
      padding: 0 28px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 40;
    }

    .breadcrumb {
      font-size: 13px;
      color: var(--neutral-600);
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .breadcrumb a { color: var(--neutral-600); text-decoration: none; }
    .breadcrumb a:hover { color: var(--neutral-900); }
    .breadcrumb span { color: var(--neutral-900); font-weight: 600; }

    .search-box {
      position: relative;
      width: 340px;
    }

    .search-box input {
      width: 100%;
      padding: 7px 12px 7px 32px;
      border: 1px solid var(--neutral-200);
      border-radius: 6px;
      font-size: 13px;
      background: var(--neutral-50);
      outline: none;
      transition: all 0.15s;
      font-family: inherit;
    }

    .search-box input:focus {
      border-color: var(--sky-500);
      background: #FFFFFF;
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
    }

    .search-box::before {
      content: "🔍";
      position: absolute;
      left: 10px; top: 50%;
      transform: translateY(-50%);
      font-size: 12px;
      opacity: 0.5;
    }

    .top-actions {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    /* ボタン共通パーツ */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 7px 14px;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      border: 1px solid transparent;
      transition: all 0.15s ease;
      font-family: inherit;
      text-decoration: none;
    }

    .btn-default {
      background: #FFFFFF;
      border-color: var(--neutral-200);
      color: var(--neutral-900);
    }
    .btn-default:hover { background: var(--neutral-100); }

    .btn-primary {
      background: var(--sky-500);
      color: white;
    }
    .btn-primary:hover { background: var(--sky-600); }

    .btn-danger {
      background: #FEF2F2;
      border-color: #FCA5A5;
      color: #DC2626;
    }
    .btn-danger:hover {
      background: #FEE2E2;
    }

    /* --------------------------------------------------
       3. CONTENT & GENERAL UI
    -------------------------------------------------- */
    .content-container {
      padding: 24px 28px;
      max-width: 1400px;
      margin: 0 auto;
      width: 100%;
    }

    .page-header {
      margin-bottom: 20px;
    }

    .page-header h1 {
      font-size: 20px;
      font-weight: 700;
      letter-spacing: -0.3px;
    }

    .page-header p {
      font-size: 12px;
      color: var(--neutral-600);
      margin-top: 2px;
    }

    /* フラッシュメッセージ */
    .alert-success {
      background-color: #ECFDF5;
      color: #065F46;
      border: 1px solid #A7F3D0;
      border-radius: 6px;
      padding: 12px 16px;
      margin-bottom: 20px;
      font-size: 13px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
      animation: fadeIn 0.2s ease-in-out;
    }

    .alert-error {
      background-color: #FEF2F2;
      color: #991B1B;
      border: 1px solid #FCA5A5;
      border-radius: 6px;
      padding: 12px 16px;
      margin-bottom: 20px;
      font-size: 13px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
      animation: fadeIn 0.2s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-4px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Badges */
    .badge {
      display: inline-flex;
      align-items: center;
      padding: 3px 8px;
      border-radius: 4px;
      font-size: 11px;
      font-weight: 600;
      border: 1px solid transparent;
    }
    .badge-plan { background: #FEF3C7; color: #B45309; border-color: #FDE68A; }
    .badge-done { background: #DCFCE7; color: #15803D; border-color: #BBF7D0; }
    .badge-wish { background: var(--neutral-100); color: var(--neutral-600); border-color: var(--neutral-200); }

    /* フォーム共通スタイル */
    .form-group {
      margin-bottom: 16px;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }
    .form-group:last-child { margin-bottom: 0; }

    .form-label {
      font-size: 12px;
      font-weight: 600;
      color: var(--neutral-700);
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .required-tag {
      font-size: 10px;
      color: #EF4444;
      background: #FEF2F2;
      padding: 1px 4px;
      border-radius: 3px;
    }

    .form-control {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid var(--neutral-200);
      border-radius: 6px;
      font-size: 13px;
      font-family: inherit;
      background: #FFFFFF;
      outline: none;
      transition: all 0.15s;
    }

    .form-control:focus {
      border-color: var(--sky-500);
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
    }

    textarea.form-control { resize: vertical; min-height: 80px; }
  </style>
  @stack('styles')
</head>
<body>

<!-- SIDEBAR NAVIGATION -->
<aside class="sidebar">
  <div class="sidebar-header">
    <a href="{{ route('home') }}" class="logo">Event<span>ify</span></a>
  </div>

  <div class="nav-group">
    <div class="nav-label">メイン</div>
    <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
      <span>📊</span> ダッシュボード
    </a>
    <a href="{{ route('event.create') }}" class="nav-item {{ request()->routeIs('event.create') ? 'active' : '' }}">
      <span>＋</span> イベント新規作成
    </a>
  </div>

  <div class="sidebar-footer">
    <div class="user-profile">
      <div class="avatar">{{ Str::substr(auth()->user()->name ?? 'U', 0, 1) }}</div>
      <div class="user-info">
        <div class="user-name">{{ auth()->user()->name }}</div>
      </div>
    </div>

    <!-- ログアウト -->
    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
      @csrf
      <button type="submit" class="logout-btn" title="ログアウト">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
          <polyline points="16 17 21 12 16 7"></polyline>
          <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
      </button>
    </form>
  </div>
</aside>

<!-- MAIN CONTENT -->
<main class="main-content">
  @yield('topbar')

  <div class="content-container">
    {{-- グローバルフラッシュメッセージ --}}
    @if (session('success'))
      <div class="alert-success">
        <span>✓</span>
        <span>{{ session('success') }}</span>
      </div>
    @endif

    @if (session('error'))
      <div class="alert-error">
        <span>⚠️</span>
        <span>{{ session('error') }}</span>
      </div>
    @endif

    @yield('content')
  </div>
</main>

@stack('scripts')
</body>
</html>

