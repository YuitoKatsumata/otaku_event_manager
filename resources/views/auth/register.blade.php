<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規アカウント登録 | Eventify</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
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
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.getElementById('toggle-password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 min-h-screen flex items-center justify-center p-4 selection:bg-brand-500 selection:text-white my-8">

    <!-- 背景のふんわりした光 -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-100 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-sky-100 rounded-full blur-3xl opacity-60"></div>
    </div>

    <!-- 登録カード -->
    <main class="w-full max-w-md bg-white/80 backdrop-blur-xl border border-slate-200/80 rounded-2xl shadow-xl p-8 transition-all">

        <!-- ヘッダー -->
        <header class="text-center mb-6">
            <h2 class="text-lg font-semibold text-slate-700">アカウント作成</h2>
        </header>

        <!-- フォーム -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <!-- ユーザー名（アカウント登録ならではの項目） -->
            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">ユーザー名</label>
                <input type="text" name="name" id="name" class="w-full px-3.5 py-2.5 text-sm bg-slate-50/50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition duration-150 placeholder:text-slate-400" placeholder="イベント太郎" value="{{ old('name') }}" required>
            </div>

            <!-- メールアドレス -->
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">メールアドレス</label>
                <input type="email" name="email" id="email" class="w-full px-3.5 py-2.5 text-sm bg-slate-50/50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition duration-150 placeholder:text-slate-400" placeholder="example@email.com" value="{{ old('email') }}" required>
            </div>

            <!-- パスワード -->
            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">パスワード</label>
                <div class="relative">
                    <input type="password" name="password" id="password" class="w-full pl-3.5 pr-10 py-2.5 text-sm bg-slate-50/50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition duration-150 placeholder:text-slate-400" placeholder="8文字以上の半角英数字" required>
                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" onclick="togglePassword()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
                <p class="text-[10px] text-slate-400 mt-1">※ 8文字以上で英字と数字を組み合わせてね</p>
            </div>

            <!-- パスワード確認 -->
            <div>
                <label for="password-confirm" class="block text-xs font-semibold text-slate-700 mb-1">パスワード（確認）</label>
                <input type="password" name="password_confirmation" id="password-confirm" class="w-full px-3.5 py-2.5 text-sm bg-slate-50/50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition duration-150 placeholder:text-slate-400" placeholder="もう一度入力してね" required>
            </div>

            <button type="submit" class="w-full mt-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 px-4 rounded-xl shadow-lg shadow-brand-500/25 active:scale-[0.98] transition duration-150 text-sm">
                無料でアカウントを作成
            </button>
        </form>

        <!-- フッター -->
        <footer class="mt-6 text-center text-xs text-slate-500">
            <p>すでにアカウントをお持ちですか？ <a href="{{ route('login') }}" class="text-brand-600 hover:text-brand-700 font-semibold hover:underline">ログインはこちら</a></p>
        </footer>

    </main>

</body>
</html>
