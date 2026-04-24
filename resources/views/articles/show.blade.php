@extends('layouts.app')

@section('title', $article->title . ' – DevCraft')

@section('content')
<style>
    /* Moving background effects */
    .bg-orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(100px);
        z-index: -1;
        opacity: 0.3;
        animation: float 20s infinite ease-in-out;
        pointer-events: none;
    }
    
    .bg-orb-1 {
        top: -10%;
        left: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.6) 0%, rgba(16, 185, 129, 0) 70%);
    }
    
    .bg-orb-2 {
        bottom: -20%;
        right: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.4) 0%, rgba(59, 130, 246, 0) 70%);
        animation-delay: -5s;
        animation-duration: 25s;
    }

    .bg-orb-3 {
        top: 30%;
        left: 50%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.4) 0%, rgba(139, 92, 246, 0) 70%);
        animation-delay: -10s;
        animation-duration: 22s;
    }

    @keyframes float {
        0%, 100% {
            transform: translate(0, 0) scale(1);
        }
        33% {
            transform: translate(80px, -80px) scale(1.2);
        }
        66% {
            transform: translate(-40px, 60px) scale(0.8);
        }
    }
</style>

{{-- Background Effects --}}
<div class="fixed inset-0 overflow-hidden pointer-events-none z-[-1]">
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="bg-orb bg-orb-3"></div>
</div>

<div class="flex-grow flex flex-col items-center w-full max-w-[1120px] mx-auto px-4 md:px-6 py-12 relative z-10">

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- ARTICLE HEADER --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <header class="w-full max-w-3xl flex flex-col gap-3 mb-12">
        {{-- Category Badges --}}
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-400 font-ui-label text-ui-label">
                #{{ $article->category->name }}
            </span>
        </div>

        {{-- Title --}}
        <h1 class="font-h1 text-h1 text-on-surface">{{ $article->title }}</h1>

        {{-- Subtitle / Excerpt --}}
        <p class="font-body-lg text-body-lg text-on-surface-variant">{{ $article->excerpt }}</p>

        {{-- Author & Meta --}}
        <div class="flex items-center gap-6 mt-3 border-t border-surface-variant pt-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-surface-container-high overflow-hidden flex items-center justify-center text-emerald-400">
                    <span class="material-symbols-outlined">person</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-ui-label text-ui-label text-on-surface">{{ $article->user->name }}</span>
                    <span class="font-ui-label text-ui-label text-on-surface-variant opacity-70">Senior Staff Engineer</span>
                </div>
            </div>
            <div class="flex flex-col ml-auto text-right">
                <span class="font-ui-label text-ui-label text-on-surface-variant">
                    {{ $article->published_at ? $article->published_at->format('F d, Y') : 'Draft' }}
                </span>
                <span class="font-ui-label text-ui-label text-on-surface-variant opacity-70">
                    {{ $article->reading_time }}
                </span>
            </div>
        </div>
    </header>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- ARTICLE BODY --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <article class="w-full max-w-3xl prose-devcraft">
        {!! nl2br(e($article->content)) !!}
    </article>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- BACK NAVIGATION --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <div class="w-full max-w-3xl mt-16 pt-8 border-t border-surface-variant">
        <a href="{{ route('articles.index') }}"
           class="inline-flex items-center gap-2 text-emerald-400 font-ui-label text-ui-label hover:gap-3 transition-all duration-200">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Back to all articles
        </a>
    </div>
</div>
@endsection
