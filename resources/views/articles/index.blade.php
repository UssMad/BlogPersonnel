@extends('layouts.app')

@section('title', 'DevCraft – Engineering Clarity')

@section('content')

{{-- Custom Animations for Articles Page --}}
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    
    /* Staggered card animation */
    .stagger-card { opacity: 0; animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .stagger-card:nth-child(1) { animation-delay: 0.1s; }
    .stagger-card:nth-child(2) { animation-delay: 0.2s; }
    .stagger-card:nth-child(3) { animation-delay: 0.3s; }
    .stagger-card:nth-child(4) { animation-delay: 0.4s; }
    .stagger-card:nth-child(5) { animation-delay: 0.5s; }
    .stagger-card:nth-child(6) { animation-delay: 0.6s; }
    .stagger-card:nth-child(7) { animation-delay: 0.7s; }
    .stagger-card:nth-child(8) { animation-delay: 0.8s; }

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

<div class="w-full max-w-[1120px] mx-auto px-6 pt-16 pb-20 grid grid-cols-1 lg:grid-cols-12 gap-12 relative z-10">

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- LEFT COLUMN: MAIN FEED --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <div class="lg:col-span-8 flex flex-col gap-12">

        {{-- Page Header --}}
        <header class="flex flex-col gap-3 mb-6 animate-fade-in-up" style="animation-delay: 0s;">
            <h1 class="font-h1 text-h1 text-on-surface">Engineering Clarity.</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">
                Deep-dive technical prose, architectural musings, and pragmatic code snippets for the modern developer.
            </p>
        </header>

        {{-- Article Feed --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($articles as $index => $article)
                {{-- Featured Article (first one spans full width) --}}
                @if($index === 0 && !request('category_id'))
                    <article class="stagger-card col-span-1 md:col-span-2 group relative flex flex-col bg-surface-container-low border border-outline-variant rounded-xl overflow-hidden hover:shadow-[0_12px_40px_rgba(0,0,0,0.4)] hover:-translate-y-1 transition-all duration-500">
                        <div class="p-12 flex flex-col gap-6">
                            <div class="flex items-center gap-3">
                                <span class="font-ui-label text-ui-label bg-emerald-500/15 text-emerald-500 px-3 py-1 rounded-full group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                                    #{{ $article->category->name }}
                                </span>
                                <span class="font-ui-label text-ui-label text-on-surface-variant">
                                    {{ $article->published_at->format('M d, Y') }}
                                </span>
                            </div>
                            <div class="flex flex-col gap-3">
                                <h2 class="font-h2 text-h2 text-on-surface group-hover:text-emerald-500 transition-colors duration-300">
                                    {{ $article->title }}
                                </h2>
                                <p class="font-body-md text-body-md text-on-surface-variant">
                                    {{ $article->excerpt }}
                                </p>
                            </div>
                            <a href="{{ route('articles.show', $article) }}" class="mt-3 flex items-center gap-1 text-emerald-500 font-ui-label text-ui-label group-hover:gap-3 transition-all duration-300">
                                Read Article <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @else
                    {{-- Standard Article Card --}}
                    <article class="stagger-card group relative flex flex-col bg-surface-container border border-outline-variant rounded-xl overflow-hidden hover:shadow-[0_8px_30px_rgba(0,0,0,0.3)] hover:-translate-y-1 transition-all duration-500 p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="font-ui-label text-ui-label bg-emerald-500/15 text-emerald-500 px-3 py-1 rounded-full group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                                #{{ $article->category->name }}
                            </span>
                            <span class="font-ui-label text-ui-label text-on-surface-variant">
                                {{ $article->published_at->format('M d, Y') }}
                            </span>
                        </div>
                        <a href="{{ route('articles.show', $article) }}" class="flex flex-col gap-3 flex-grow">
                            <h3 class="font-h3 text-h3 text-on-surface group-hover:text-emerald-500 transition-colors duration-300">
                                {{ $article->title }}
                            </h3>
                            <p class="font-body-md text-body-md text-on-surface-variant line-clamp-3">
                                {{ $article->excerpt }}
                            </p>
                        </a>
                    </article>
                @endif
            @empty
                <div class="col-span-1 md:col-span-2 text-center py-20 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <span class="material-symbols-outlined text-[48px] text-outline mb-4 block hover:animate-spin">article</span>
                    <p class="font-body-lg text-body-lg text-on-surface-variant">No articles published yet.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($articles->hasPages())
            <div class="flex justify-center mt-6 animate-fade-in-up" style="animation-delay: 0.8s;">
                {{ $articles->appends(request()->query())->links('pagination.custom') }}
            </div>
        @endif
    </div>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- RIGHT COLUMN: SIDEBAR --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <aside class="lg:col-span-4 flex flex-col gap-12 lg:pl-6 lg:border-l border-outline-variant/30">

        {{-- Author Bio Widget --}}
        <div class="animate-fade-in-up flex flex-col gap-6 bg-surface-container-low p-6 rounded-xl border border-outline-variant hover:border-emerald-500/30 transition-colors duration-300" style="animation-delay: 0.3s;">
            <div class="w-16 h-16 rounded-full bg-surface-bright overflow-hidden border border-outline-variant flex items-center justify-center text-emerald-500 hover:rotate-180 transition-transform duration-700">
                <span class="material-symbols-outlined text-[32px]">code</span>
            </div>
            <div class="flex flex-col gap-1">
                <h3 class="font-h3 text-h3 text-on-surface">Alex Mercer</h3>
                <p class="font-ui-label text-ui-label text-emerald-500">Senior Staff Engineer</p>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant">
                Writing about scalable systems, elegant code, and the realities of modern software engineering.
            </p>
        </div>

        {{-- Categories Filter --}}
        <div class="animate-fade-in-up flex flex-col gap-6" style="animation-delay: 0.4s;">
            <h3 class="font-ui-label text-ui-label text-on-surface-variant uppercase tracking-widest">Filter by Category</h3>
            <div class="flex flex-wrap gap-3">
                {{-- All Posts --}}
                <a href="{{ route('articles.index') }}"
                   class="font-ui-label text-ui-label px-3 py-1 rounded-full shadow-sm transition-all duration-300 hover:-translate-y-1
                   {{ !request('category_id') ? 'bg-emerald-500 text-white' : 'bg-surface-container-high text-on-surface hover:bg-surface-bright hover:text-emerald-500 border border-outline-variant' }}">
                    All Posts
                </a>

                @foreach($categories as $category)
                    <a href="{{ route('articles.index', ['category_id' => $category->id]) }}"
                       class="font-ui-label text-ui-label px-3 py-1 rounded-full transition-all duration-300 hover:-translate-y-1
                       {{ request('category_id') == $category->id ? 'bg-emerald-500 text-white shadow-md' : 'bg-surface-container-high text-on-surface hover:bg-surface-bright hover:text-emerald-500 border border-outline-variant hover:shadow-sm' }}">
                        #{{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Newsletter Widget --}}
        <div class="animate-fade-in-up flex flex-col gap-6 bg-primary-container/20 p-6 rounded-xl border border-emerald-500/20 relative overflow-hidden group" style="animation-delay: 0.5s;">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none group-hover:scale-150 transition-transform duration-700"></div>
            <h3 class="font-h3 text-h3 text-on-surface">The Monthly Dispatch</h3>
            <p class="font-body-md text-body-md text-on-surface-variant">
                One high-signal email per month. No spam, just deep technical insights.
            </p>
            <form class="flex flex-col gap-3 mt-3">
                <input class="bg-surface-container-lowest border border-outline text-on-surface font-ui-label text-ui-label rounded-md px-3 py-3 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all placeholder:text-on-surface-variant/50"
                       placeholder="email@example.com" type="email">
                <button class="bg-emerald-500 text-white font-ui-label text-ui-label rounded-md px-3 py-3 hover:bg-emerald-600 transition-all shadow-sm hover:shadow-emerald-500/25 hover:shadow-lg hover:-translate-y-0.5" type="button">
                    Subscribe
                </button>
            </form>
        </div>
    </aside>
</div>
@endsection
