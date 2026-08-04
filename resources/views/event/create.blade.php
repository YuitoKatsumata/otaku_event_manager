<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eventify - イベント新規作成</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">

  <style>
    :root {
      /* home_sample.html と完全に共通のカラーシステム */
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
      font-family: 'Inter', 'Noto Sans JP', -apple-system, sans-serif;
      background-color: var(--neutral-50);
      color: var(--neutral-900);
      min-height: 100vh;
      display: flex;
      -webkit-font-smoothing: antialiased;
    }

    /* SIDEBAR */
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

    .nav-item:hover { background: var(--neutral-100); color: var(--neutral-900); }
    .nav-item.active { background: var(--sky-50); color: var(--sky-500); font-weight: 600; }

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

    .user-info { display: flex; flex-direction: column; overflow: hidden; }
    .user-name { font-size: 13px; font-weight: 600; }

    /* MAIN CONTENT */
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

    .btn-default { background: #FFFFFF; border-color: var(--neutral-200); color: var(--neutral-900); }
    .btn-default:hover { background: var(--neutral-100); }
    .btn-primary { background: var(--sky-500); color: white; }
    .btn-primary:hover { background: var(--sky-600); }

    /* FORM & PREVIEW */
    .content-container {
      padding: 24px 28px;
      max-width: 1200px;
      margin: 0 auto;
      width: 100%;
    }

    .page-header { margin-bottom: 24px; }
    .page-header h1 { font-size: 20px; font-weight: 700; letter-spacing: -0.3px; }
    .page-header p { font-size: 12px; color: var(--neutral-600); margin-top: 2px; }

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

    /* 画像未選択時のデフォルト / カテゴリ別グラデーション背景 */
    .card-banner.no-image { background: linear-gradient(135deg, var(--neutral-100) 0%, var(--neutral-200) 100%); }
    .card-banner.no-image.anime { background: linear-gradient(135deg, #E0F2FE 0%, #BAE6FD 100%); }
    .card-banner.no-image.live  { background: linear-gradient(135deg, #FEF3C7 0%, #FCD34D 100%); }
    .card-banner.no-image.music { background: linear-gradient(135deg, #EDE9FE 0%, #C4B5FD 100%); }
    .card-banner.no-image.game  { background: linear-gradient(135deg, #DCFCE7 0%, #86EFAC 100%); }

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

    .badge { padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
    .badge-plan { background: #FEF3C7; color: #B45309; }
    .badge-done { background: #DCFCE7; color: #15803D; }
    .badge-wish { background: var(--neutral-100); color: var(--neutral-600); }

    .action-box {
      background: #FFFFFF;
      border: 1px solid var(--neutral-200);
      border-radius: 8px;
      padding: 16px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
  </style>
</head>
<body>

<aside class="sidebar">
  <div class="sidebar-header"><div class="logo">Event<span>ify</span></div></div>
  <div class="nav-group">
    <div class="nav-label">メイン</div>
    <a href="{{ route('home') }}" class="nav-item">📊 ダッシュボード</a>
    <a href="{{ route('event.create') }}" class="nav-item active">📅 イベント一覧</a>
    <a href="#" class="nav-item">🗓 カレンダー</a>
    <a href="#" class="nav-item">⭐ ウィッシュリスト</a>
  </div>
  <div class="sidebar-footer">
    <div class="avatar">{{ Str::substr(auth()->user()->name, 0, 1) }}</div>
    <div class="user-info">
      <div class="user-name">{{ auth()->user()->name }}</div>
    </div>
  </div>
</aside>

<main class="main-content">
  <header class="top-bar">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">ダッシュボード</a><span>/</span><span>新規作成</span>
    </div>
    <div class="top-actions"><a href="{{ route('home') }}" class="btn btn-default">キャンセル</a></div>
  </header>

  <div class="content-container">
    <div class="page-header">
      <h1>イベント新規登録</h1>
      <p>新しいイベント情報を入力してリストに追加します</p>
    </div>

    <form id="event-form" action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-grid">

        <div class="form-left">
          @if ($errors->any())
            <div style="background-color: #fee2e2; color: #ef4444; border: 1px solid #fca5a5; border-radius: 6px; padding: 12px; margin-bottom: 20px; font-size: 13px;">
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
              <input type="text" id="input-title" name="title" class="form-control" value="{{ old('title') }}" required>
              @error('title')
                <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
              @enderror
            </div>

            <div class="form-group">
              <label class="form-label">カテゴリ<span class="required-tag">必須</span></label>
              <div class="chip-selector">
                @foreach ($categories as $category)
                  <input type="radio" name="category_id" id="cat-{{ $category->id }}" value="{{ $category->id }}" class="chip-radio" data-category-name="{{ $category->name }}" data-category-color="{{ $category->color }}" {{ old('category_id') == $category->id ? 'checked' : '' }}>
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

              <div class="file-preview-info" id="file-info">
                <span id="file-name">filename.jpg</span>
                <button type="button" class="remove-file-btn" id="btn-remove-file">画像を削除</button>
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
                <input type="date" id="input-date" name="event_date" class="form-control" value="{{ old('event_date') }}" required>
                @error('event_date')
                  <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                @enderror
              </div>

              <div class="form-group">
                <label class="form-label" for="input-status">ステータス</label>
                <select id="input-status" name="status" class="form-control">
                  @foreach ($statuses as $status)
                    <option name="status" value="{{ $status->value }}" {{ old('status') == $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                  @endforeach
                </select>
                @error('status')
                  <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="input-location">開催場所・会場</label>
              <input type="text" id="input-location" name="location" class="form-control" value="{{ old('location') }}" placeholder="例: 池袋サンシャインシティ">
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
              <input type="url" id="input-url" name="event_url" class="form-control" value="{{ old('event_url') }}" placeholder="https://example.com">
              @error('event_url')
                <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
              @enderror
            </div>

            <div class="form-group">
              <label class="form-label" for="input-memo">メモ（座席番号・持ち物など）</label>
              <textarea id="input-memo" name="description" class="form-control" placeholder="整列時間: 10:30〜 / Aブロック 15番">{{ old('description') }}</textarea>
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
            <div class="card-banner no-image" id="pv-banner"></div>
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
            <button type="submit" class="btn btn-primary" style="width: 100%;">イベントを作成する</button>
            <button type="button" class="btn btn-default" style="width: 100%;">下書きとして保存</button>
          </div>
        </div>

      </div>
    </form>
  </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    // フォーム入力要素
    const inputTitle = document.getElementById('input-title');
    const inputDate = document.getElementById('input-date');
    const inputLocation = document.getElementById('input-location');
    const inputStatus = document.getElementById('input-status');

    // プレビュー要素
    const pvTitle = document.getElementById('pv-title');
    const pvDate = document.getElementById('pv-date');
    const pvLocation = document.getElementById('pv-location');
    const pvStatus = document.getElementById('pv-status');
    const pvCategory = document.getElementById('pv-category');
    const pvBanner = document.getElementById('pv-banner');

    // アップロード要素
    const uploadContainer = document.getElementById('upload-container');
    const fileInput = document.getElementById('file-input');
    const fileInfo = document.getElementById('file-info');
    const fileName = document.getElementById('file-name');
    const btnRemoveFile = document.getElementById('btn-remove-file');

    let uploadedImageBase64 = null;

    // タイトル連動
    inputTitle.addEventListener('input', (e) => {
        pvTitle.textContent = e.target.value.trim() || 'イベントタイトルを入力...';
    });

    // 日付連動（タイムゾーンズレ対策: getUTC系を使用）
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
        if (val === '参加予定') {
        pvStatus.classList.add('badge-plan');
        pvStatus.textContent = '参加予定';
        } else if (val === '参加済み') {
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
        const categoryColor = selectedRadio.dataset.categoryColor || 'white';
        const categoryName = selectedRadio.dataset.categoryName || 'カテゴリ未設定';
        pvCategory.textContent = categoryName;
        pvBanner.style.backgroundColor = categoryColor;
        updateBannerDisplay();
    }

    // ファイルアップロード処理 (クリック / ドラッグ＆ドロップ)
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
        updateBannerDisplay();
    });

    function updateBannerDisplay() {
        pvBanner.className = 'card-banner';
        if (uploadedImageBase64) {
        pvBanner.style.backgroundImage = `url(${uploadedImageBase64})`;
        } else {
        pvBanner.style.backgroundImage = 'none';
        pvBanner.classList.add('no-image');
        const selectedCategory = document.querySelector('input[name="category_id"]:checked');
        if (selectedCategory && selectedCategory.dataset.categorySlug) {
            pvBanner.classList.add(selectedCategory.dataset.categorySlug);
        }
        }
    }

    // --- 初期化処理: old()による再入力値をプレビューに反映 ---
    if (inputTitle.value) pvTitle.textContent = inputTitle.value;
    if (inputLocation.value) pvLocation.textContent = `📍 ${inputLocation.value}`;
    if (inputDate.value) inputDate.dispatchEvent(new Event('change'));
    inputStatus.dispatchEvent(new Event('change'));

    const checkedCategory = document.querySelector('input[name="category_id"]:checked');
    if (checkedCategory) {
        updateCategoryPreview(checkedCategory);
    } else {
        updateBannerDisplay(); // 画像・カテゴリどちらも未選択でもバナー初期表示は必要
    }
    });
</script>

</body>
</html>
