<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン | Eventify</title>
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
<body class="bg-slate-50 font-sans text-slate-800 min-h-screen flex items-center justify-center p-4 selection:bg-brand-500 selection:text-white">

    <!-- 背景のふんわりした光（これがあると一気にクオリティ上がる！） -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-100 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-sky-100 rounded-full blur-3xl opacity-60"></div>
    </div>

    <!-- ログインカード -->
    <main class="w-full max-w-md bg-white/80 backdrop-blur-xl border border-slate-200/80 rounded-2xl shadow-xl p-8 transition-all">

        <div class="space-y-3 mb-6">
            <button type="button" class="w-full flex items-center justify-center gap-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium py-2.5 px-4 rounded-xl transition duration-150 active:scale-[0.99] text-sm shadow-sm">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                Googleでログイン
            </button>
        </div>

        <!-- 区切り線 -->
        <div class="relative flex py-2 items-center mb-6">
            <div class="flex-grow border-t border-slate-200"></div>
            <span class="flex-shrink mx-4 text-xs font-medium text-slate-400">または</span>
            <div class="flex-grow border-t border-slate-200"></div>
        </div>

        <!-- フォーム -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">メールアドレス</label>
                <input type="email" name="email" id="email" class="w-full px-3.5 py-2.5 text-sm bg-slate-50/50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition duration-150 placeholder:text-slate-400" placeholder="example@email.com" value="{{ old('email') }}" required>
                @if ($errors->any())
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-xs font-semibold text-slate-700">パスワード</label>
                    <a href="#" class="text-xs text-brand-600 hover:text-brand-700 font-medium hover:underline">忘れた場合</a>
                </div>
                <div class="relative">
                    <input type="password" name="password" id="password" class="w-full pl-3.5 pr-10 py-2.5 text-sm bg-slate-50/50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition duration-150 placeholder:text-slate-400" placeholder="••••••••" required>
                    <!-- パスワード切替アイコン -->
                    <button type="button" id="toggle-password" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
                @if ($errors->any())
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" id="save-info" class="w-4 h-4 rounded border-slate-300 text-brand-500 focus:ring-brand-500/20 accent-brand-500 cursor-pointer">
                <label for="save-info" class="text-xs text-slate-600 cursor-pointer select-none">ログイン状態を保持する</label>
            </div>

            <button type="submit" class="w-full mt-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 px-4 rounded-xl shadow-lg shadow-brand-500/25 active:scale-[0.98] transition duration-150 text-sm">
                ログイン
            </button>
        </form>

        <!-- フッター -->
        <footer class="mt-8 text-center text-xs text-slate-500">
            <p>アカウントをお持ちでないですか？ <a href="{{ route('register') }}" class="text-brand-600 hover:text-brand-700 font-semibold hover:underline">新規登録（無料）</a></p>
        </footer>

    </main>

</body>
</html>
