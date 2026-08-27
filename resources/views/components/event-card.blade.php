@props(['event'])

<div class="card event-card-item"
     data-category-id="{{ $event->category_id }}"
     data-title="{{ mb_strtolower($event->title) }}"
     data-location="{{ mb_strtolower($event->location ?? '') }}">
  <div class="card-banner {{ $event->category->slug ?? 'other' }}">
    @if ($event->image_path)
      <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" style="width: 100%; height: 100%; object-fit: cover;">
    @else
      <div style="width: 100%; height: 100%; background-color: {{ $event->category->color ?? '#E2E8F0' }}; display: flex; align-items: center; justify-content: center;">
        <span style="font-size: 24px; opacity: 0.7;">✨</span>
      </div>
    @endif
  </div>

  <div class="card-body">
    <div class="card-category">{{ $event->category->name ?? 'カテゴリ未設定' }}</div>
    <div class="card-title">{{ $event->title }}</div>
    <div class="card-details">
      <span>📅 {{ $event->event_date ? $event->event_date->format('Y/m/d') . ' (' . $event->event_date->format('D') . ')' : '日付未定' }}</span>
      @if ($event->location)
        <span>📍 {{ $event->location }}</span>
      @endif
    </div>
    <div class="card-footer">
      <span class="badge {{ $event->status->badgeClass() }}">{{ $event->status->label() }}</span>
      <a href="{{ route('event.show', $event->id) }}" class="btn btn-default" style="padding: 4px 8px; font-size: 11px;">詳細</a>
    </div>
  </div>
</div>

