@extends('layouts.app')

@section('title', 'Eventify - ダッシュボード')

@push('styles')
<style>
  /* KPI Cards */
  .kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
  }

  .kpi-card {
    background: #FFFFFF;
    border: 1px solid var(--neutral-200);
    border-radius: 8px;
    padding: 16px;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
  }

  .kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.04);
  }

  .kpi-title {
    font-size: 12px;
    font-weight: 500;
    color: var(--neutral-600);
  }

  .kpi-value {
    font-size: 26px;
    font-weight: 700;
    margin-top: 4px;
    letter-spacing: -0.5px;
    color: var(--neutral-900);
  }

  /* Toolbar & Filters */
  .toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    gap: 12px;
    flex-wrap: wrap;
  }

  .filter-group {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
  }

  .chip {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    background: #FFFFFF;
    border: 1px solid var(--neutral-200);
    color: var(--neutral-600);
    cursor: pointer;
    transition: all 0.15s;
    user-select: none;
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

  /* Main Grid */
  .dashboard-grid {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 24px;
    align-items: start;
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
    transition: border-color 0.15s, box-shadow 0.15s, transform 0.15s;
  }

  .card:hover {
    border-color: var(--neutral-300);
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    transform: translateY(-2px);
  }

  .card-banner {
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }

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
    line-height: 1.35;
    margin-bottom: 10px;
    color: var(--neutral-900);
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

  /* Timeline Widget */
  .widget {
    background: #FFFFFF;
    border: 1px solid var(--neutral-200);
    border-radius: 8px;
    padding: 16px;
    position: sticky;
    top: 84px;
  }

  .widget-title {
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
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
    padding-bottom: 12px;
    border-bottom: 1px solid var(--neutral-100);
    text-decoration: none;
    color: inherit;
    transition: opacity 0.15s;
  }
  .timeline-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }
  .timeline-item:hover {
    opacity: 0.8;
  }

  .date-badge {
    background: var(--neutral-50);
    border: 1px solid var(--neutral-200);
    border-radius: 6px;
    padding: 4px 8px;
    text-align: center;
    min-width: 44px;
    flex-shrink: 0;
  }

  .date-badge .m { font-size: 9px; font-weight: 700; color: var(--neutral-600); text-transform: uppercase; }
  .date-badge .d { font-size: 15px; font-weight: 700; color: var(--neutral-900); line-height: 1; }

  .timeline-content { font-size: 12px; min-width: 0; }
  .timeline-content .t { font-weight: 600; color: var(--neutral-900); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .timeline-content .sub { color: var(--neutral-600); font-size: 11px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

  /* 空状態（Empty State） */
  .empty-state {
    background: #FFFFFF;
    border: 1px dashed var(--neutral-300);
    border-radius: 8px;
    padding: 48px 24px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
  }
  .empty-state-icon { font-size: 40px; }
  .empty-state-title { font-size: 16px; font-weight: 700; color: var(--neutral-800); }
  .empty-state-desc { font-size: 13px; color: var(--neutral-600); max-width: 400px; }

  @media (max-width: 900px) {
    .dashboard-grid {
      grid-template-columns: 1fr;
    }
    .widget {
      position: static;
    }
  }
</style>
@endpush

@section('topbar')
<header class="top-bar">
  <div class="search-box">
    <input type="text" id="event-search-input" placeholder="イベント名・会場で検索 (Cmd+K)">
  </div>
  <div class="top-actions">
    <a href="{{ route('event.create') }}" class="btn btn-primary">＋ イベント追加</a>
  </div>
</header>
@endsection

@section('content')
<div class="page-header">
  <h1>イベント管理</h1>
  <p>参加予定および過去ログを一括管理・分析できます</p>
</div>

<!-- KPI Metrics -->
<div class="kpi-grid">
  <div class="kpi-card">
    <div class="kpi-title">参加済み（累計）</div>
    <div class="kpi-value">{{ $completedCount }}</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-title">参加予定</div>
    <div class="kpi-value">{{ $scheduledCount }}</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-title">今月のイベント</div>
    <div class="kpi-value">{{ $monthlyCount }}</div>
  </div>
</div>

<!-- Controls & Filter -->
<div class="toolbar">
  <div class="filter-group" id="category-filter-group">
    <div class="chip active" data-category-id="all">すべて ({{ $events->count() }})</div>
    @foreach ($categories as $category)
      <div class="chip" data-category-id="{{ $category->id }}">{{ $category->name }}</div>
    @endforeach
  </div>
</div>

<!-- Main Section Split -->
<div class="dashboard-grid">

  <!-- Primary Cards Grid -->
  <div class="main-cards-section">
    <div class="cards-grid" id="events-grid">
      @forelse ($events as $event)
        <x-event-card :event="$event" />
      @empty
        <div class="empty-state" style="grid-column: 1 / -1;">
          <div class="empty-state-icon">📅</div>
          <div class="empty-state-title">登録されているイベントがありません</div>
          <div class="empty-state-desc">「＋ イベント追加」ボタンから最初のイベントを登録してみましょう！</div>
          <a href="{{ route('event.create') }}" class="btn btn-primary" style="margin-top: 8px;">＋ イベントを登録する</a>
        </div>
      @endforelse
    </div>

    <!-- 検索/フィルターでヒット0件用メッセージ -->
    <div id="no-search-results" class="empty-state" style="display: none; margin-top: 16px;">
      <div class="empty-state-icon">🔍</div>
      <div class="empty-state-title">一致するイベントが見つかりませんでした</div>
      <div class="empty-state-desc">検索キーワードやカテゴリフィルターを変更してお試しください。</div>
      <button type="button" id="btn-reset-filters" class="btn btn-default" style="margin-top: 8px;">フィルターをリセット</button>
    </div>
  </div>

  <!-- Sidebar Widget -->
  <div class="widget-area">
    <div class="widget">
      <div class="widget-title">
        <span>今後の予定</span>
      </div>
      <div class="timeline-list">
        @forelse ($events->where('event_date', '>=', now()->startOfDay())->take(5) as $event)
          <a href="{{ route('event.show', $event->id) }}" class="timeline-item">
            <div class="date-badge">
              <div class="m">{{ $event->event_date->format('M') }}</div>
              <div class="d">{{ $event->event_date->format('d') }}</div>
            </div>
            <div class="timeline-content">
              <div class="t">{{ $event->title }}</div>
              <div class="sub">📍 {{ $event->location ?? '場所未定' }}</div>
            </div>
          </a>
        @empty
          <div style="font-size: 12px; color: var(--neutral-500); text-align: center; padding: 16px 0;">
            今後の直近予定はありません
          </div>
        @endforelse
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('event-search-input');
    const filterChips = document.querySelectorAll('#category-filter-group .chip');
    const eventCards = document.querySelectorAll('.event-card-item');
    const noResultsState = document.getElementById('no-search-results');
    const resetFiltersBtn = document.getElementById('btn-reset-filters');
    const eventsGrid = document.getElementById('events-grid');

    let currentCategoryId = 'all';
    let currentSearchQuery = '';

    // Cmd+K / Ctrl+K ショートカット
    document.addEventListener('keydown', (e) => {
      if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
        e.preventDefault();
        searchInput?.focus();
      }
    });

    // 検索入力イベント
    searchInput?.addEventListener('input', (e) => {
      currentSearchQuery = e.target.value.trim().toLowerCase();
      applyFilters();
    });

    // カテゴリフィルタークリックイベント
    filterChips.forEach(chip => {
      chip.addEventListener('click', () => {
        filterChips.forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
        currentCategoryId = chip.dataset.categoryId;
        applyFilters();
      });
    });

    // リセットボタン
    resetFiltersBtn?.addEventListener('click', () => {
      if (searchInput) searchInput.value = '';
      currentSearchQuery = '';
      currentCategoryId = 'all';
      filterChips.forEach(c => c.classList.remove('active'));
      document.querySelector('#category-filter-group .chip[data-category-id="all"]')?.classList.add('active');
      applyFilters();
    });

    // フィルタリング適用関数
    function applyFilters() {
      let visibleCount = 0;

      eventCards.forEach(card => {
        const cardCategoryId = card.dataset.categoryId;
        const cardTitle = card.dataset.title || '';
        const cardLocation = card.dataset.location || '';

        const matchesCategory = (currentCategoryId === 'all') || (cardCategoryId === currentCategoryId);
        const matchesSearch = !currentSearchQuery || cardTitle.includes(currentSearchQuery) || cardLocation.includes(currentSearchQuery);

        if (matchesCategory && matchesSearch) {
          card.style.display = 'flex';
          visibleCount++;
        } else {
          card.style.display = 'none';
        }
      });

      // イベントカードが存在する場合のヒット0件表示
      if (eventCards.length > 0) {
        if (visibleCount === 0) {
          noResultsState.style.display = 'flex';
          eventsGrid.style.display = 'none';
        } else {
          noResultsState.style.display = 'none';
          eventsGrid.style.display = 'grid';
        }
      }
    }
  });
</script>
@endpush
