@props(['event' => null, 'categories', 'statuses'])

@php
  $isEdit = isset($event) && $event->exists;
  $titleVal = old('title', $isEdit ? $event->title : '');
  $categoryIdVal = old('category_id', $isEdit ? $event->category_id : null);
  $eventDateVal = old('event_date', $isEdit && $event->event_date ? $event->event_date->format('Y-m-d') : '');
  $statusVal = old('status', $isEdit ? $event->status->value : App\Enums\EventStatus::Scheduled->value);
  $locationVal = old('location', $isEdit ? $event->location : '');
  $eventUrlVal = old('event_url', $isEdit ? $event->event_url : '');
  $descriptionVal = old('description', $isEdit ? $event->description : '');
  $existingImagePath = $isEdit && $event->image_path ? $event->image_path : null;
@endphp

@push('styles')
<style>
  .form-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 28px;
    align-items: start;
  }

  .form-section {
    background: #FFFFFF;
    border: 1px solid var(--neutral-200);
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
  }

  .section-title {
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--neutral-100);
    color: var(--neutral-900);
  }

  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }

  .chip-selector { display: flex; gap: 8px; flex-wrap: wrap; }
  .chip-radio { display: none; }
  .chip-label {
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    background: #FFFFFF;
    border: 1px solid var(--neutral-200);
    color: var(--neutral-600);
    cursor: pointer;
    transition: all 0.15s;
    user-select: none;
  }
  .chip-radio:checked + .chip-label {
    background: var(--sky-50);
    border-color: var(--sky-500);
    color: var(--sky-500);
    font-weight: 600;
  }

  /* 画像アップロード UI */
  .upload-area {
    border: 2px dashed var(--neutral-200);
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    background: var(--neutral-50);
    cursor: pointer;
    transition: all 0.15s;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
  }

  .upload-area:hover, .upload-area.dragover {
    border-color: var(--sky-500);
    background: var(--sky-50);
  }

  .upload-icon { font-size: 24px; }
  .upload-text { font-size: 12px; font-weight: 600; color: var(--neutral-700); }
  .upload-hint { font-size: 11px; color: var(--neutral-600); }

  .file-preview-info {
    display: none;
    align-items: center;
    justify-content: space-between;
    padding: 8px 12px;
    background: var(--sky-50);
    border: 1px solid var(--sky-100);
    border-radius: 6px;
    font-size: 12px;
    margin-top: 8px;
  }

  .remove-file-btn {
    background: none; border: none; color: #EF4444;
    cursor: pointer; font-size: 11px; font-weight: 600;
  }

  /* STICKY PANEL & PREVIEW */
  .sticky-panel {
    position: sticky;
    top: 84px;
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .preview-header {
    font-size: 12px;
    font-weight: 700;
    color: var(--neutral-600);
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .card {
    background: #FFFFFF;
    border: 1px solid var(--neutral-200);
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
  }

  .card-banner {
    height: 90px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    background-size: cover;
    background-position: center;
  }

  .card-banner.no-image { background: linear-gradient(135deg, var(--neutral-100) 0%, var(--neutral-200) 100%); }

  .card-body { padding: 14px; flex: 1; display: flex; flex-direction: column; }
  .card-category { font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--sky-500); margin-bottom: 4px; }
  .card-title { font-size: 14px; font-weight: 700; line-height: 1.3; margin-bottom: 10px; word-break: break-all; }
  .card-details { font-size: 12px; color: var(--neutral-600); display: flex; flex-direction: column; gap: 4px; margin-bottom: 14px; }

  .card-footer {
    margin-top: auto;
    padding-top: 10px;
    border-top: 1px solid var(--neutral-200);
    display: flex; align-items: center; justify-content: space-between;
  }

  .action-box {
    background: #FFFFFF;
    border: 1px solid var(--neutral-200);
    border-radius: 8px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  @media (max-width: 900px) {
    .form-grid {
      grid-template-columns: 1fr;
    }
    .sticky-panel {
      position: static;
    }
  }
</style>
@endpush

<form id="event-form" action="{{ $isEdit ? route('event.update', $event->id) : route('event.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  @if ($isEdit)
    @method('PUT')
  @endif

  <div class="form-grid">
    <div class="form-left">
      @if ($errors->any())
        <div style="background-color: #FEE2E2; color: #DC2626; border: 1px solid #FCA5A5; border-radius: 6px; padding: 12px; margin-bottom: 20px; font-size: 13px;">
          <p style="font-weight: 600; margin-bottom: 8px;">入力内容にエラーがあります。</p>
          <ul style="list-style-type: disc; margin-left: 20px;">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- 基本情報 -->
      <div class="form-section">
        <div class="section-title">1. 基本情報</div>

        <div class="form-group">
          <label class="form-label" for="input-title">
            イベント名 <span class="required-tag">必須</span>
          </label>
          <input type="text" id="input-title" name="title" class="form-control" value="{{ $titleVal }}" placeholder="例: AnimeJapan 2026" required>
          @error('title')
            <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label">カテゴリ <span class="required-tag">必須</span></label>
          <div class="chip-selector">
            @foreach ($categories as $category)
              <input type="radio" name="category_id" id="cat-{{ $category->id }}" value="{{ $category->id }}" class="chip-radio" data-category-name="{{ $category->name }}" data-category-color="{{ $category->color }}" {{ $categoryIdVal == $category->id ? 'checked' : '' }}>
              <label for="cat-{{ $category->id }}" class="chip-label">{{ $category->name }}</label>
            @endforeach
          </div>
          @error('category_id')
            <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
          @enderror
        </div>

        <!-- 画像アップロードエリア -->
        <div class="form-group">
          <label class="form-label">アイキャッチ画像</label>

          <div class="upload-area" id="upload-container">
            <span class="upload-icon">🖼️</span>
            <span class="upload-text">クリックまたは画像をドラッグ＆ドロップ</span>
            <span class="upload-hint">PNG, JPG, WEBP (最大 5MB)</span>
            <input type="file" name="image_path" id="file-input" accept="image/*" style="display: none;">
          </div>

          <div class="file-preview-info" id="file-info" style="{{ $existingImagePath ? 'display: flex;' : '' }}">
            <span id="file-name">{{ $existingImagePath ? basename($existingImagePath) : 'filename.jpg' }}</span>
            <button type="button" class="remove-file-btn" id="btn-remove-file">画像をクリア</button>
          </div>

          @error('image_path')
            <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- 日時・ステータス -->
      <div class="form-section">
        <div class="section-title">2. 日時・ステータス</div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="input-date">
              開催日 <span class="required-tag">必須</span>
            </label>
            <input type="date" id="input-date" name="event_date" class="form-control" value="{{ $eventDateVal }}" required>
            @error('event_date')
              <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label" for="input-status">ステータス</label>
            <select id="input-status" name="status" class="form-control">
              @foreach ($statuses as $status)
                <option value="{{ $status->value }}" {{ $statusVal === $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
              @endforeach
            </select>
            @error('status')
              <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="input-location">開催場所・会場</label>
          <input type="text" id="input-location" name="location" class="form-control" value="{{ $locationVal }}" placeholder="例: 東京ビッグサイト / 幕張メッセ">
          @error('location')
            <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- 詳細メモ -->
      <div class="form-section">
        <div class="section-title">3. 詳細・メモ</div>

        <div class="form-group">
          <label class="form-label" for="input-url">関連リンク / 公式サイトURL</label>
          <input type="url" id="input-url" name="event_url" class="form-control" value="{{ $eventUrlVal }}" placeholder="https://example.com">
          @error('event_url')
            <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="input-memo">メモ（座席番号・持ち物など）</label>
          <textarea id="input-memo" name="description" class="form-control" placeholder="整列時間: 10:30〜 / Aブロック 15番">{{ $descriptionVal }}</textarea>
          @error('description')
            <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
          @enderror
        </div>
      </div>

    </div>

    <!-- RIGHT SIDE: PREVIEW & SUBMIT -->
    <div class="form-right sticky-panel">
      <div class="preview-header">カードプレビュー</div>

      <div class="card" id="preview-card">
        <div class="card-banner no-image" id="pv-banner" style="{{ $existingImagePath ? 'background-image: url(' . asset('storage/' . $existingImagePath) . '); background-size: cover;' : '' }}"></div>
        <div class="card-body">
          <div class="card-category" id="pv-category">カテゴリ未設定</div>
          <div class="card-title" id="pv-title">イベントタイトルを入力...</div>
          <div class="card-details">
            <span id="pv-date">📅 ----/--/--</span>
            <span id="pv-location">📍 場所未設定</span>
          </div>
          <div class="card-footer">
            <span class="badge badge-plan" id="pv-status">参加予定</span>
            <button type="button" class="btn btn-default" style="padding: 4px 8px; font-size: 11px;">詳細</button>
          </div>
        </div>
      </div>

      <div class="action-box">
        <button type="submit" class="btn btn-primary" style="width: 100%;">
          {{ $isEdit ? 'イベントを更新する' : 'イベントを作成する' }}
        </button>
        <a href="{{ $isEdit ? route('event.show', $event->id) : route('home') }}" class="btn btn-default" style="width: 100%;">
          キャンセル
        </a>
      </div>
    </div>

  </div>
</form>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const inputTitle = document.getElementById('input-title');
    const inputDate = document.getElementById('input-date');
    const inputLocation = document.getElementById('input-location');
    const inputStatus = document.getElementById('input-status');

    const pvTitle = document.getElementById('pv-title');
    const pvDate = document.getElementById('pv-date');
    const pvLocation = document.getElementById('pv-location');
    const pvStatus = document.getElementById('pv-status');
    const pvCategory = document.getElementById('pv-category');
    const pvBanner = document.getElementById('pv-banner');

    const uploadContainer = document.getElementById('upload-container');
    const fileInput = document.getElementById('file-input');
    const fileInfo = document.getElementById('file-info');
    const fileName = document.getElementById('file-name');
    const btnRemoveFile = document.getElementById('btn-remove-file');

    let uploadedImageBase64 = null;
    const existingImageUrl = @json($existingImagePath ? asset('storage/' . $existingImagePath) : null);

    // タイトル連動
    inputTitle.addEventListener('input', (e) => {
      pvTitle.textContent = e.target.value.trim() || 'イベントタイトルを入力...';
    });

    // 日付連動
    inputDate.addEventListener('change', (e) => {
      if (!e.target.value) {
        pvDate.textContent = '📅 ----/--/--';
        return;
      }
      const date = new Date(e.target.value);
      const days = ['日', '月', '火', '水', '木', '金', '土'];
      pvDate.textContent = `📅 ${date.getUTCFullYear()}/${String(date.getUTCMonth() + 1).padStart(2, '0')}/${String(date.getUTCDate()).padStart(2, '0')} (${days[date.getUTCDay()]})`;
    });

    // 場所連動
    inputLocation.addEventListener('input', (e) => {
      pvLocation.textContent = e.target.value.trim() ? `📍 ${e.target.value.trim()}` : '📍 場所未設定';
    });

    // ステータス連動
    inputStatus.addEventListener('change', (e) => {
      const val = e.target.value;
      pvStatus.className = 'badge ';
      if (val === 'scheduled' || val === '参加予定') {
        pvStatus.classList.add('badge-plan');
        pvStatus.textContent = '参加予定';
      } else if (val === 'completed' || val === '参加済み') {
        pvStatus.classList.add('badge-done');
        pvStatus.textContent = '参加済み';
      } else {
        pvStatus.classList.add('badge-wish');
        pvStatus.textContent = 'キャンセル';
      }
    });

    // カテゴリ連動
    document.querySelectorAll('input[name="category_id"]').forEach(radio => {
      radio.addEventListener('change', (e) => {
        updateCategoryPreview(e.target);
      });
    });

    function updateCategoryPreview(selectedRadio) {
      const categoryColor = selectedRadio.dataset.categoryColor || '#E2E8F0';
      const categoryName = selectedRadio.dataset.categoryName || 'カテゴリ未設定';
      pvCategory.textContent = categoryName;
      if (!uploadedImageBase64 && !existingImageUrl) {
        pvBanner.style.backgroundColor = categoryColor;
      }
      updateBannerDisplay();
    }

    // ファイルアップロード処理
    uploadContainer.addEventListener('click', () => fileInput.click());

    uploadContainer.addEventListener('dragover', (e) => {
      e.preventDefault();
      uploadContainer.classList.add('dragover');
    });

    uploadContainer.addEventListener('dragleave', () => {
      uploadContainer.classList.remove('dragover');
    });

    uploadContainer.addEventListener('drop', (e) => {
      e.preventDefault();
      uploadContainer.classList.remove('dragover');
      if (e.dataTransfer.files.length > 0) {
        fileInput.files = e.dataTransfer.files;
        handleFileUpload(e.dataTransfer.files[0]);
      }
    });

    fileInput.addEventListener('change', (e) => {
      if (e.target.files.length > 0) {
        handleFileUpload(e.target.files[0]);
      }
    });

    function handleFileUpload(file) {
      if (!file.type.startsWith('image/')) {
        alert('画像ファイルを選択してください。');
        return;
      }
      if (file.size > 5 * 1024 * 1024) {
        alert('ファイルサイズが大きすぎます（5MBまで）。');
        return;
      }
      const reader = new FileReader();
      reader.onload = (e) => {
        uploadedImageBase64 = e.target.result;
        fileName.textContent = file.name;
        fileInfo.style.display = 'flex';
        updateBannerDisplay();
      };
      reader.readAsDataURL(file);
    }

    btnRemoveFile.addEventListener('click', () => {
      uploadedImageBase64 = null;
      fileInput.value = '';
      fileInfo.style.display = 'none';
      pvBanner.style.backgroundImage = 'none';
      const selectedCategory = document.querySelector('input[name="category_id"]:checked');
      if (selectedCategory) {
        updateCategoryPreview(selectedCategory);
      } else {
        updateBannerDisplay();
      }
    });

    function updateBannerDisplay() {
      pvBanner.className = 'card-banner';
      if (uploadedImageBase64) {
        pvBanner.style.backgroundImage = `url(${uploadedImageBase64})`;
        pvBanner.style.backgroundColor = 'transparent';
      } else if (existingImageUrl && fileInput.value === '') {
        pvBanner.style.backgroundImage = `url(${existingImageUrl})`;
        pvBanner.style.backgroundColor = 'transparent';
      } else {
        pvBanner.style.backgroundImage = 'none';
        pvBanner.classList.add('no-image');
        const selectedCategory = document.querySelector('input[name="category_id"]:checked');
        if (selectedCategory && selectedCategory.dataset.categoryColor) {
          pvBanner.style.backgroundColor = selectedCategory.dataset.categoryColor;
        }
      }
    }

    // 初期化
    if (inputTitle.value) pvTitle.textContent = inputTitle.value;
    if (inputLocation.value) pvLocation.textContent = `📍 ${inputLocation.value}`;
    if (inputDate.value) inputDate.dispatchEvent(new Event('change'));
    inputStatus.dispatchEvent(new Event('change'));

    const checkedCategory = document.querySelector('input[name="category_id"]:checked');
    if (checkedCategory) {
      updateCategoryPreview(checkedCategory);
    } else {
      updateBannerDisplay();
    }
  });
</script>
@endpush

