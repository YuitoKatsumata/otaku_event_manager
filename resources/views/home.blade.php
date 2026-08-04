<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eventify - ワークスペース</title>
  <!-- Google Fonts: 欧文(Inter) × 和文(Noto Sans JP) のプロ仕様ペアリング -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">

  <style>
    :root {
      /* カラーシステム：空色（Sky）ベースをSaaS用にトーンダウン＆調整 */
      --sky-50: #F0F9FF;
      --sky-100: #E0F2FE;
      --sky-500: #0284C7;
      --sky-600: #0369A1;
      --sky-700: #075985;

      --neutral-50: #F8FAFC;
      --neutral-100: #F1F5F9;
      --neutral-200: #E2E8F0;
      --neutral-300: #CBD5E1;
      --neutral-600: #475569;
      --neutral-700: #334155;
      --neutral-900: #0F172A;

      --sidebar-width: 240px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      /* 💡 欧文フォント(Inter)を優先指定！数字や英語が劇的にキレイになるよ */
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
      gap: 10px;
    }

    .avatar {
      width: 32px; height: 32px;
      border-radius: 50%;
      background: var(--sky-100);
      display: flex; align-items: center; justify-content: center;
      font-size: 12px; font-weight: 700; color: var(--sky-500);
    }

    .user-info {
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .user-name { font-size: 13px; font-weight: 600; }
    .user-plan { font-size: 11px; color: var(--neutral-600); }

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

    .search-box {
      position: relative;
      width: 320px;
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

    /* --------------------------------------------------
       3. DASHBOARD CONTENT AREA
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

    /* KPI Cards */
    .kpi-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }

    .kpi-card {
      background: #FFFFFF;
      border: 1px solid var(--neutral-200);
      border-radius: 8px;
      padding: 16px;
    }

    .kpi-title {
      font-size: 12px;
      font-weight: 500;
      color: var(--neutral-600);
    }

    .kpi-value {
      font-size: 24px;
      font-weight: 700;
      margin-top: 4px;
      letter-spacing: -0.5px;
    }

    /* Toolbar & Filters */
    .toolbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 16px;
      gap: 12px;
    }

    .filter-group {
      display: flex;
      gap: 6px;
    }

    .chip {
      padding: 5px 12px;
      border-radius: 6px;
      font-size: 12px;
      font-weight: 500;
      background: #FFFFFF;
      border: 1px solid var(--neutral-200);
      color: var(--neutral-600);
      cursor: pointer;
      transition: all 0.15s;
    }

    .chip.active {
      background: var(--sky-50);
      border-color: var(--sky-500);
      color: var(--sky-500);
      font-weight: 600;
    }

    .chip:hover:not(.active) {
      border-color: var(--neutral-300);
      color: var(--neutral-900);
    }

    /* --------------------------------------------------
       4. MAIN GRID & CONTENT
    -------------------------------------------------- */
    .dashboard-grid {
      display: grid;
      grid-template-columns: 1fr 300px;
      gap: 24px;
    }

    /* Event Cards Grid */
    .cards-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
      gap: 16px;
    }

    .card {
      background: #FFFFFF;
      border: 1px solid var(--neutral-200);
      border-radius: 8px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: border-color 0.15s, box-shadow 0.15s;
    }

    .card:hover {
      border-color: var(--neutral-300);
      box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }

    .card-banner {
      height: 90px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 32px;
      position: relative;
    }

    .card-banner.anime { background: linear-gradient(135deg, #E0F2FE 0%, #BAE6FD 100%); }
    .card-banner.live  { background: linear-gradient(135deg, #FEF3C7 0%, #FCD34D 100%); }
    .card-banner.music { background: linear-gradient(135deg, #EDE9FE 0%, #C4B5FD 100%); }
    .card-banner.game  { background: linear-gradient(135deg, #DCFCE7 0%, #86EFAC 100%); }

    .card-action-menu {
      position: absolute;
      top: 8px; right: 8px;
      background: rgba(255,255,255,0.85);
      border: none;
      width: 26px; height: 26px;
      border-radius: 4px;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      font-size: 12px;
      color: var(--neutral-700);
      transition: background 0.15s;
    }

    .card-action-menu:hover { background: #FFFFFF; }

    .card-body {
      padding: 14px;
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .card-category {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      color: var(--sky-500);
      margin-bottom: 4px;
    }

    .card-title {
      font-size: 14px;
      font-weight: 700;
      line-height: 1.3;
      margin-bottom: 10px;
    }

    .card-details {
      font-size: 12px;
      color: var(--neutral-600);
      display: flex;
      flex-direction: column;
      gap: 4px;
      margin-bottom: 14px;
    }

    .card-footer {
      margin-top: auto;
      padding-top: 10px;
      border-top: 1px solid var(--neutral-200);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    /* Badges */
    .badge {
      padding: 3px 8px;
      border-radius: 4px;
      font-size: 11px;
      font-weight: 600;
    }
    .badge-plan { background: #FEF3C7; color: #B45309; }
    .badge-done { background: #DCFCE7; color: #15803D; }

    /* Timeline Widget */
    .widget {
      background: #FFFFFF;
      border: 1px solid var(--neutral-200);
      border-radius: 8px;
      padding: 16px;
    }

    .widget-title {
      font-size: 14px;
      font-weight: 700;
      margin-bottom: 14px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .widget-title a {
      font-size: 11px;
      color: var(--sky-500);
      text-decoration: none;
      font-weight: 600;
    }

    .timeline-list {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .timeline-item {
      display: flex;
      gap: 12px;
      align-items: flex-start;
    }

    .date-badge {
      background: var(--neutral-50);
      border: 1px solid var(--neutral-200);
      border-radius: 6px;
      padding: 4px 8px;
      text-align: center;
      min-width: 44px;
    }

    .date-badge .m { font-size: 9px; font-weight: 700; color: var(--neutral-600); text-transform: uppercase; }
    .date-badge .d { font-size: 15px; font-weight: 700; color: var(--neutral-900); line-height: 1; }

    .timeline-content {
      font-size: 12px;
    }

    .timeline-content .t { font-weight: 600; color: var(--neutral-900); margin-bottom: 2px; }
    .timeline-content .sub { color: var(--neutral-600); font-size: 11px; }

  </style>
</head>
<body>

<!-- SIDEBAR NAVIGATION -->
<aside class="sidebar">
  <div class="sidebar-header">
    <div class="logo">Event<span>ify</span></div>
  </div>

  <div class="nav-group">
    <div class="nav-label">メイン</div>
    <a href="#" class="nav-item active">📊 ダッシュボード</a>
    <a href="#" class="nav-item">📅 イベント一覧</a>
    <a href="#" class="nav-item">🗓 カレンダー</a>
    <a href="#" class="nav-item">⭐ ウィッシュリスト</a>
  </div>

  <div class="nav-group">
    <div class="nav-label">管理・分析</div>
    <a href="#" class="nav-item">📈 参加レポート</a>
    <a href="#" class="nav-item">🏷 カテゴリ設定</a>
    <a href="#" class="nav-item">⚙️ アカウント設定</a>
  </div>

  <div class="sidebar-footer">
    <div class="avatar">デ</div>
    <div class="user-info">
      <div class="user-name">{{ auth()->user()->name }}</div>
    </div>
  </div>
</aside>

<!-- MAIN CONTENT -->
<main class="main-content">

  <!-- Top Bar -->
  <header class="top-bar">
    <div class="search-box">
      <input type="text" placeholder="イベント・会場・アーティストで検索 (Cmd+K)">
    </div>
    <div class="top-actions">
      <button class="btn btn-default">📥 CSV出力</button>
      <a href="{{ route('event.create') }}" class="btn btn-primary">＋ イベント追加</a>
    </div>
  </header>

  <!-- Dashboard Content -->
  <div class="content-container">

    <div class="page-header">
      <h1>イベント管理</h1>
      <p>参加予定および過去ログを一括管理・分析できます</p>
    </div>

    <!-- KPI Metrics -->
    <div class="kpi-grid">
      <div class="kpi-card">
        <div class="kpi-title">参加済み（累計）</div>
        <div class="kpi-value">24</div>
      </div>
      <div class="kpi-card">
        <div class="kpi-title">参加予定</div>
        <div class="kpi-value">8</div>
      </div>
      <div class="kpi-card">
        <div class="kpi-title">今月のイベント</div>
        <div class="kpi-value">3</div>
      </div>
      <div class="kpi-card">
        <div class="kpi-title">ウィッシュリスト</div>
        <div class="kpi-value">12</div>
      </div>
    </div>

    <!-- Controls & Filter -->
    <div class="toolbar">
      <div class="filter-group">
        <div class="chip active">すべて</div>
        <div class="chip">アニメ</div>
        <div class="chip">ライブ・音楽</div>
        <div class="chip">ゲーム</div>
        <div class="chip">声優</div>
      </div>
    </div>

    <!-- Main Section Split -->
    <div class="dashboard-grid">

      <!-- Primary Grid -->
      <div class="cards-grid">

        <div class="card">
          <div class="card-banner anime">
            🌸
            <button class="card-action-menu">•••</button>
          </div>
          <div class="card-body">
            <div class="card-category">アニメ</div>
            <div class="card-title">Re:ゼロ 10周年記念展</div>
            <div class="card-details">
              <span>📅 2026/07/12 (土)</span>
              <span>📍 池袋サンシャインシティ</span>
            </div>
            <div class="card-footer">
              <span class="badge badge-plan">参加予定</span>
              <button class="btn btn-default" style="padding: 4px 8px; font-size: 11px;">詳細</button>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-banner live">
            🎤
            <button class="card-action-menu">•••</button>
          </div>
          <div class="card-body">
            <div class="card-category">ライブ</div>
            <div class="card-title">アニサマ2026 DAY1</div>
            <div class="card-details">
              <span>📅 2026/08/23 (土)</span>
              <span>📍 さいたまスーパーアリーナ</span>
            </div>
            <div class="card-footer">
              <span class="badge badge-plan">参加予定</span>
              <button class="btn btn-default" style="padding: 4px 8px; font-size: 11px;">詳細</button>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-banner music">
            🎵
            <button class="card-action-menu">•••</button>
          </div>
          <div class="card-body">
            <div class="card-category">声優</div>
            <div class="card-title">花澤香菜 LIVE TOUR 2026</div>
            <div class="card-details">
              <span>📅 2026/05/18 (日)</span>
              <span>📍 Zepp Shinjuku</span>
            </div>
            <div class="card-footer">
              <span class="badge badge-done">参加済み</span>
              <button class="btn btn-default" style="padding: 4px 8px; font-size: 11px;">詳細</button>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-banner game">
            🎮
            <button class="card-action-menu">•••</button>
          </div>
          <div class="card-body">
            <div class="card-category">ゲーム</div>
            <div class="card-title">アークナイツ 周年リアルイベント</div>
            <div class="card-details">
              <span>📅 2026/06/15 (月)</span>
              <span>📍 東京ビッグサイト</span>
            </div>
            <div class="card-footer">
              <span class="badge badge-done">参加済み</span>
              <button class="btn btn-default" style="padding: 4px 8px; font-size: 11px;">詳細</button>
            </div>
          </div>
        </div>

      </div>

      <!-- Sidebar Widget -->
      <div class="widget-area">
        <div class="widget">
          <div class="widget-title">
            今後の予定
            <a href="#">すべて見る →</a>
          </div>
          <div class="timeline-list">

            <div class="timeline-item">
              <div class="date-badge">
                <div class="m">Jul</div>
                <div class="d">12</div>
              </div>
              <div class="timeline-content">
                <div class="t">Re:ゼロ 10周年記念展</div>
                <div class="sub">📍 池袋サンシャインシティ</div>
              </div>
            </div>

            <div class="timeline-item">
              <div class="date-badge">
                <div class="m">Aug</div>
                <div class="d">23</div>
              </div>
              <div class="timeline-content">
                <div class="t">アニサマ2026 DAY1</div>
                <div class="sub">📍 さいたまスーパーアリーナ</div>
              </div>
            </div>

            <div class="timeline-item">
              <div class="date-badge">
                <div class="m">Aug</div>
                <div class="d">24</div>
              </div>
              <div class="timeline-content">
                <div class="t">アニサマ2026 DAY2</div>
                <div class="sub">📍 さいたまスーパーアリーナ</div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>

  </div>
</main>

</body>
</html>
