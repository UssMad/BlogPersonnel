<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Login – DevCraft</title>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Dark Mode Script to prevent FOUC -->
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-background text-on-background min-h-screen flex flex-col antialiased transition-colors duration-300">

    <div class="absolute top-4 right-8 z-50">
        <button id="theme-toggle" type="button" class="text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high rounded-lg p-2 transition-colors">
            <span id="theme-toggle-dark-icon" class="hidden material-symbols-outlined text-[20px]">dark_mode</span>
            <span id="theme-toggle-light-icon" class="hidden material-symbols-outlined text-[20px]">light_mode</span>
        </button>
    </div>

    <main class="flex-grow flex items-center justify-center p-6 relative overflow-hidden">

        {{-- Decorative Background Elements --}}
        <div class="absolute inset-0 z-0 opacity-20 pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-secondary rounded-full blur-[120px]"></div>
        </div>

        {{-- Login Card --}}
        <div class="z-10 w-full max-w-md bg-surface-container-low rounded-xl border border-outline-variant p-12 ambient-shadow-sm">

            {{-- Header --}}
            <div class="text-center mb-12">
                <h1 class="font-h2 text-h2 text-primary mb-3">DevCraft</h1>
                <p class="font-body-md text-body-md text-on-surface-variant">Admin Authentication</p>
            </div>

            {{-- Session Status --}}
            @if(session('status'))
                <div class="mb-6 bg-emerald-500/10 border border-emerald-500/30 text-emerald-500 px-4 py-3 rounded-lg font-ui-label text-ui-label text-center">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                {{-- Email Field --}}
                <div class="space-y-2">
                    <label class="block font-ui-label text-ui-label text-on-surface" for="email">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-on-surface-variant">
                            <span class="material-symbols-outlined text-[20px]">mail</span>
                        </div>
                        <input class="block w-full pl-[40px] pr-3 py-3 bg-surface-container border border-outline-variant rounded-lg font-ui-label text-ui-label text-on-surface focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-colors placeholder:text-on-surface-variant/50"
                               id="email"
                               name="email"
                               type="email"
                               value="{{ old('email') }}"
                               placeholder="admin@devcraft.io"
                               required
                               autofocus
                               autocomplete="username">
                    </div>
                    @error('email')
                        <p class="text-red-500 font-ui-label text-ui-label mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div class="space-y-2">
                    <label class="block font-ui-label text-ui-label text-on-surface" for="password">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-on-surface-variant">
                            <span class="material-symbols-outlined text-[20px]">lock</span>
                        </div>
                        <input class="block w-full pl-[40px] pr-3 py-3 bg-surface-container border border-outline-variant rounded-lg font-ui-label text-ui-label text-on-surface focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-colors placeholder:text-on-surface-variant/50"
                               id="password"
                               name="password"
                               type="password"
                               placeholder="••••••••"
                               required
                               autocomplete="current-password">
                    </div>
                    @error('password')
                        <p class="text-red-500 font-ui-label text-ui-label mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button type="submit"
                            class="w-full flex justify-center items-center py-3 px-6 bg-primary text-on-primary rounded-lg font-ui-label text-ui-label hover:bg-primary-fixed transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-background shadow-sm">
                        Sign In
                    </button>
                </div>
            </form>

            {{-- Footer Link --}}
            <div class="mt-12 text-center">
                <a class="font-ui-label text-ui-label text-on-surface-variant hover:text-emerald-500 transition-colors" href="{{ route('articles.index') }}">
                    ← Back to Blog
                </a>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');
            const lightIcon = document.getElementById('theme-toggle-light-icon');

            if (document.documentElement.classList.contains('dark')) {
                lightIcon.classList.remove('hidden');
            } else {
                darkIcon.classList.remove('hidden');
            }

            themeToggleBtn.addEventListener('click', function() {
                darkIcon.classList.toggle('hidden');
                lightIcon.classList.toggle('hidden');

                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            });
        });
    </script>
</body>
</html>
