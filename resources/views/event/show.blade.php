@extends('layouts.app')

@section('title', 'Eventify - ' . $event->title)

@push('styles')
<style>
  .detail-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 28px;
    align-items: start;
  }

  .hero-banner {
    width: 100%;
    height: 260px;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    margin-bottom: 24px;
    border: 1px solid var(--neutral-200);
    background-size: cover;
    background-position: center;
  }

  .hero-category-tag {
    position: absolute;
    top: 16px;
    left: 16px;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(4px);
    color: #FFFFFF;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .detail-card {
    background: #FFFFFF;
    border: 1px solid var(--neutral-200);
    border-radius: 8px;
    padding: 24px;
    margin-bottom: 20px;
  }

  .detail-header {
    border-bottom: 1px solid var(--neutral-100);
    padding-bottom: 18px;
    margin-bottom: 20px;
  }

  .detail-title {
    font-size: 22px;
    font-weight: 700;
    line-height: 1.35;
    margin-bottom: 14px;
    color: var(--neutral-900);
    word-break: break-word;
  }

  .info-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .info-item {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 13px;
    color: var(--neutral-700);
  }

  .info-icon-box {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    background: var(--neutral-100);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
  }

  .section-block {
    margin-top: 20px;
  }

  .section-label {
    font-size: 12px;
    font-weight: 700;
    color: var(--neutral-900);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .memo-box {
    background: var(--neutral-50);
    border: 1px solid var(--neutral-200);
    border-radius: 6px;
    padding: 14px 16px;
    font-size: 13px;
    line-height: 1.6;
    color: var(--neutral-700);
    white-space: pre-wrap;
    word-break: break-word;
  }

  .link-anchor {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    color: var(--sky-500);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    word-break: break-all;
  }
  .link-anchor:hover {
    text-decoration: underline;
  }

  /* Countdown Widget */
  .countdown-card {
    background: linear-gradient(135deg, var(--sky-500) 0%, var(--sky-700) 100%);
    color: #FFFFFF;
    border-radius: 8px;
    padding: 24px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(2, 132, 199, 0.2);
  }

  .countdown-label {
    font-size: 12px;
    font-weight: 600;
    opacity: 0.9;
    margin-bottom: 6px;
  }

  .countdown-number {
    font-size: 42px;
    font-weight: 800;
    line-height: 1;
    letter-spacing: -1px;
    margin-bottom: 4px;
  }

  .countdown-unit {
    font-size: 16px;
    font-weight: 600;
    margin-left: 2px;
  }

  .countdown-sub {
    font-size: 11px;
    opacity: 0.8;
    margin-top: 6px;
  }

  .side-panel {
    position: sticky;
    top: 84px;
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  @media (max-width: 900px) {
    .detail-grid {
      grid-template-columns: 1fr;
    }
    .side-panel {
      position: static;
    }
  }
</style>
@endpush

@section('topbar')
<header class="top-bar">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">ダッシュボード</a>
    <span>/</span>
    <span>{{ Str::limit($event->title, 20) }}</span>
  </div>
  <div class="top-actions">
    <a href="{{ route('event.edit', $event->id) }}" class="btn btn-default">✏️ 編集</a>
    <form action="{{ route('event.destroy', $event->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('本当にこのイベントを削除しますか？\n削除すると復元できません。');">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger">🗑️ 削除</button>
    </form>
  </div>
</header>
@endsection

@section('content')
<div class="detail-grid">

  <!-- LEFT: MAIN CONTENT -->
  <div class="detail-main">

    <!-- HERO BANNER -->
    @if ($event->image_path)
      <div class="hero-banner" style="background-image: url('{{ asset('storage/' . $event->image_path) }}');">
        <span class="hero-category-tag">{{ $event->category->name ?? 'カテゴリ未設定' }}</span>
      </div>
    @else
      <div class="hero-banner" style="background-color: {{ $event->category->color ?? '#E2E8F0' }}; display: flex; align-items: center; justify-content: center;">
        <span style="font-size: 48px; opacity: 0.8;">✨</span>
        <span class="hero-category-tag">{{ $event->category->name ?? 'カテゴリ未設定' }}</span>
      </div>
    @endif

    <!-- DETAIL CARD -->
    <div class="detail-card">
      <div class="detail-header">
        <div style="margin-bottom: 8px;">
          <span class="badge {{ $event->status->badgeClass() }}">{{ $event->status->label() }}</span>
        </div>
        <h1 class="detail-title">{{ $event->title }}</h1>

        <div class="info-list">
          <div class="info-item">
            <div class="info-icon-box">📅</div>
            <div>
              <strong>開催日:</strong> {{ $event->event_date ? $event->event_date->format('Y年m月d日') . ' (' . $event->event_date->format('D') . ')' : '未定' }}
            </div>
          </div>
          @if ($event->location)
            <div class="info-item">
              <div class="info-icon-box">📍</div>
              <div>
                <strong>会場:</strong> {{ $event->location }}
              </div>
            </div>
          @endif
        </div>
      </div>

      <!-- 関連リンク -->
      @if ($event->event_url)
        <div class="section-block">
          <div class="section-label">🔗 公式サイト / 関連リンク</div>
          <a href="{{ $event->event_url }}" target="_blank" rel="noopener noreferrer" class="link-anchor">
            {{ $event->event_url }} ↗
          </a>
        </div>
      @endif

      <!-- メモ -->
      @if ($event->description)
        <div class="section-block">
          <div class="section-label">📝 メモ・持ち物・座席情報</div>
          <div class="memo-box">{{ $event->description }}</div>
        </div>
      @endif
    </div>

  </div>

  <!-- RIGHT: SIDE PANEL (COUNTDOWN WIDGET) -->
  <div class="side-panel">
    <div class="countdown-card">
      <div class="countdown-label">開催まであと</div>
      <div class="countdown-number">
        {{ $event->days_remaining }}<span class="countdown-unit">日</span>
      </div>
      <div class="countdown-sub">
        {{ $event->event_date ? $event->event_date->format('Y/m/d') : '' }}
      </div>
    </div>

    <div class="detail-card" style="padding: 16px;">
      <div style="font-size: 12px; font-weight: 700; color: var(--neutral-600); margin-bottom: 10px;">クイックアクション</div>
      <div style="display: flex; flex-direction: column; gap: 8px;">
        <a href="{{ route('event.edit', $event->id) }}" class="btn btn-default" style="width: 100%;">イベント情報を編集</a>
        <a href="{{ route('home') }}" class="btn btn-default" style="width: 100%;">← ダッシュボードに戻る</a>
      </div>
    </div>
  </div>

</div>
@endsection
