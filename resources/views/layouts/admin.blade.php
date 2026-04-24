<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel – DevCraft')</title>

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

<body class="bg-background text-on-background min-h-screen antialiased scrollbar-dark transition-colors duration-300">

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- ADMIN SIDEBAR --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <nav class="fixed left-0 top-0 h-screen w-64 border-r border-nav-border shadow-xl bg-sidebar-bg flex flex-col p-4 space-y-2 z-50">

        {{-- Profile Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-6 px-3">
                <a href="{{ route('articles.index') }}" class="group block flex-shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="DevCraft Logo" class="w-10 h-10 object-contain transition-transform duration-500 group-hover:rotate-12 group-hover:scale-110">
                </a>
                <div class="overflow-hidden">
                    <span class="text-lg font-bold text-nav-brand truncate block">Admin Panel</span>
                    <span class="text-emerald-500 font-ui-label text-ui-label truncate block">{{ Auth::user()->name }}</span>
                </div>
            </div>

            {{-- Create Post CTA --}}
            <a href="{{ route('articles.create') }}"
               class="w-full bg-emerald-500/10 text-emerald-500 py-3 rounded-lg flex items-center justify-center gap-2 font-ui-label text-ui-label hover:bg-emerald-500/20 transition-colors duration-200 border border-emerald-500/20">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Create Post
            </a>
        </div>

        {{-- Navigation Links --}}
        <div class="flex-1 space-y-1 flex flex-col">
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'bg-surface-container-high text-emerald-500 border-r-4 border-emerald-500 rounded-l' : 'text-nav-link hover:text-nav-link-hover hover:bg-surface-container-high rounded' }} transition-colors cursor-pointer font-sans text-sm font-semibold flex items-center gap-3 px-3 py-3">
                <span class="material-symbols-outlined">grid_view</span>
                Dashboard
            </a>

            <a href="{{ route('articles.index') }}"
               class="text-nav-link hover:text-nav-link-hover hover:bg-surface-container-high transition-colors cursor-pointer font-sans text-sm font-semibold flex items-center gap-3 px-3 py-3 rounded">
                <span class="material-symbols-outlined">public</span>
                View Blog
            </a>
        </div>

        {{-- Bottom Actions --}}
        <div class="mt-auto pt-6 border-t border-nav-border space-y-1">
            <div class="flex justify-between items-center px-3 py-3 rounded text-nav-link">
                <span class="font-sans text-sm font-semibold">Theme</span>
                <button id="theme-toggle" type="button" class="hover:text-nav-link-hover hover:bg-surface-container-high rounded-lg p-1 transition-colors">
                    <span id="theme-toggle-dark-icon" class="hidden material-symbols-outlined text-[20px]">dark_mode</span>
                    <span id="theme-toggle-light-icon" class="hidden material-symbols-outlined text-[20px]">light_mode</span>
                </button>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-nav-link hover:text-red-500 hover:bg-surface-container-high transition-colors cursor-pointer font-sans text-sm font-semibold flex items-center gap-3 px-3 py-3 rounded">
                    <span class="material-symbols-outlined">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </nav>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- MAIN CONTENT CANVAS --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <main class="ml-64 p-12 min-h-screen bg-background text-on-background">
        <div class="max-w-[1120px] mx-auto">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-8 bg-emerald-500/10 border border-emerald-500/30 text-emerald-500 px-6 py-4 rounded-lg font-ui-label text-ui-label flex items-center gap-3">
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
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
