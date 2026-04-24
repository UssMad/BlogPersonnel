<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="DevCraft – Deep-dive technical prose, architectural musings, and pragmatic code snippets for the modern developer.">

    <title>@yield('title', 'DevCraft – Technical Freelancer Blog')</title>

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

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- PUBLIC TOP NAVBAR --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <header class="bg-nav-bg/80 backdrop-blur-md fixed top-0 w-full z-50 border-b border-nav-border shadow-sm">
        <div class="flex justify-between items-center h-16 px-8 max-w-[1120px] mx-auto">
            {{-- Brand --}}
            <a class="flex items-center gap-3 group" href="{{ route('articles.index') }}">
                <img src="{{ asset('images/logo.png') }}" alt="DevCraft Logo" class="h-8 w-8 object-contain transition-transform duration-500 group-hover:rotate-12">
                <span class="text-xl font-black text-nav-brand tracking-tighter group-hover:text-emerald-500 transition-colors">DevCraft</span>
            </a>

            {{-- Navigation --}}
            <nav class="hidden md:flex items-center space-x-6">
                <a class="font-ui-label text-ui-label transition-all duration-200 active:scale-95
                    {{ request()->routeIs('articles.index') ? 'text-emerald-500 border-b-2 border-emerald-500 pb-1' : 'text-nav-link hover:text-nav-link-hover hover:bg-surface-container-high px-2 py-1 rounded' }}"
                   href="{{ route('articles.index') }}">
                    Articles
                </a>
            </nav>

            {{-- Auth Actions --}}
            <div class="flex items-center space-x-4">
                {{-- Theme Toggle --}}
                <button id="theme-toggle" type="button" class="text-nav-link hover:text-nav-link-hover hover:bg-surface-container-high rounded-lg text-sm p-2 transition-colors">
                    <span id="theme-toggle-dark-icon" class="hidden material-symbols-outlined text-[20px]">dark_mode</span>
                    <span id="theme-toggle-light-icon" class="hidden material-symbols-outlined text-[20px]">light_mode</span>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}"
                       class="font-ui-label text-ui-label text-nav-link hover:text-nav-link-hover hover:bg-surface-container-high px-4 py-2 rounded transition-all duration-200">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="font-ui-label text-ui-label text-nav-link hover:text-red-500 hover:bg-surface-container-high px-4 py-2 rounded transition-all duration-200">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="font-ui-label text-ui-label text-emerald-500 hover:bg-surface-container-high px-4 py-2 rounded-md transition-all duration-200 active:scale-95">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- MAIN CONTENT --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <main class="flex-grow pt-16">
        @yield('content')
    </main>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- FOOTER --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <footer class="bg-footer-bg w-full py-12 border-t mt-20 border-nav-border">
        <div class="max-w-[1120px] mx-auto flex flex-col md:flex-row justify-between items-center px-8">
            <p class="font-sans text-xs uppercase tracking-widest text-footer-text mb-4 md:mb-0">
                © {{ date('Y') }} DevCraft Editorial. Engineered for clarity.
            </p>
            <nav class="flex space-x-6">
                <a class="font-sans text-xs uppercase tracking-widest text-footer-text hover:text-nav-brand transition-colors" href="#">Documentation</a>
                <a class="font-sans text-xs uppercase tracking-widest text-footer-text hover:text-nav-brand transition-colors" href="#">Privacy Policy</a>
                <a class="font-sans text-xs uppercase tracking-widest text-footer-text hover:text-nav-brand transition-colors" href="#">Source Code</a>
                <a class="font-sans text-xs uppercase tracking-widest text-footer-text hover:text-nav-brand transition-colors" href="#">Status</a>
            </nav>
        </div>
    </footer>

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