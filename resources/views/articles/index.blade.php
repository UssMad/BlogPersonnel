@extends('layouts.app')

@section('title', 'DevCraft – Engineering Clarity')

@section('content')
<div class="w-full max-w-[1120px] mx-auto px-6 pt-16 pb-20 grid grid-cols-1 lg:grid-cols-12 gap-12">

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- LEFT COLUMN: MAIN FEED --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <div class="lg:col-span-8 flex flex-col gap-12">

        {{-- Page Header --}}
        <header class="flex flex-col gap-3 mb-6">
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
                    <article class="col-span-1 md:col-span-2 group relative flex flex-col bg-surface-container-low border border-outline-variant rounded-xl overflow-hidden hover:shadow-[0_8px_32px_rgba(0,0,0,0.3)] transition-all duration-300">
                        <div class="p-12 flex flex-col gap-6">
                            <div class="flex items-center gap-3">
                                <span class="font-ui-label text-ui-label bg-emerald-500/15 text-emerald-400 px-3 py-1 rounded-full">
                                    #{{ $article->category->name }}
                                </span>
                                <span class="font-ui-label text-ui-label text-on-surface-variant">
                                    {{ $article->published_at->format('M d, Y') }}
                                </span>
                            </div>
                            <div class="flex flex-col gap-3">
                                <h2 class="font-h2 text-h2 text-on-surface group-hover:text-emerald-400 transition-colors">
                                    {{ $article->title }}
                                </h2>
                                <p class="font-body-md text-body-md text-on-surface-variant">
                                    {{ $article->excerpt }}
                                </p>
                            </div>
                            <a href="{{ route('articles.show', $article) }}" class="mt-3 flex items-center gap-1 text-emerald-400 font-ui-label text-ui-label hover:gap-2 transition-all duration-200">
                                Read Article <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @else
                    {{-- Standard Article Card --}}
                    <article class="group relative flex flex-col bg-surface-container border border-outline-variant rounded-xl overflow-hidden hover:shadow-[0_4px_24px_rgba(0,0,0,0.2)] transition-all duration-300 p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="font-ui-label text-ui-label bg-emerald-500/15 text-emerald-400 px-3 py-1 rounded-full">
                                #{{ $article->category->name }}
                            </span>
                            <span class="font-ui-label text-ui-label text-on-surface-variant">
                                {{ $article->published_at->format('M d, Y') }}
                            </span>
                        </div>
                        <a href="{{ route('articles.show', $article) }}" class="flex flex-col gap-3 flex-grow">
                            <h3 class="font-h3 text-h3 text-on-surface group-hover:text-emerald-400 transition-colors">
                                {{ $article->title }}
                            </h3>
                            <p class="font-body-md text-body-md text-on-surface-variant line-clamp-3">
                                {{ $article->excerpt }}
                            </p>
                        </a>
                    </article>
                @endif
            @empty
                <div class="col-span-1 md:col-span-2 text-center py-20">
                    <span class="material-symbols-outlined text-[48px] text-outline mb-4 block">article</span>
                    <p class="font-body-lg text-body-lg text-on-surface-variant">No articles published yet.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($articles->hasPages())
            <div class="flex justify-center mt-6">
                {{ $articles->appends(request()->query())->links('pagination.custom') }}
            </div>
        @endif
    </div>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- RIGHT COLUMN: SIDEBAR --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <aside class="lg:col-span-4 flex flex-col gap-12 lg:pl-6 lg:border-l border-outline-variant/30">

        {{-- Author Bio Widget --}}
        <div class="flex flex-col gap-6 bg-surface-container-low p-6 rounded-xl border border-outline-variant">
            <div class="w-16 h-16 rounded-full bg-surface-bright overflow-hidden border border-outline-variant flex items-center justify-center text-emerald-400">
                <span class="material-symbols-outlined text-[32px]">code</span>
            </div>
            <div class="flex flex-col gap-1">
                <h3 class="font-h3 text-h3 text-on-surface">Alex Mercer</h3>
                <p class="font-ui-label text-ui-label text-emerald-400">Senior Staff Engineer</p>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant">
                Writing about scalable systems, elegant code, and the realities of modern software engineering.
            </p>
        </div>

        {{-- Categories Filter --}}
        <div class="flex flex-col gap-6">
            <h3 class="font-ui-label text-ui-label text-on-surface-variant uppercase tracking-widest">Filter by Category</h3>
            <div class="flex flex-wrap gap-3">
                {{-- All Posts --}}
                <a href="{{ route('articles.index') }}"
                   class="font-ui-label text-ui-label px-3 py-1 rounded-full shadow-sm transition-colors
                   {{ !request('category_id') ? 'bg-emerald-500 text-white' : 'bg-surface-container-high text-on-surface hover:bg-surface-bright hover:text-emerald-400 border border-outline-variant' }}">
                    All Posts
                </a>

                @foreach($categories as $category)
                    <a href="{{ route('articles.index', ['category_id' => $category->id]) }}"
                       class="font-ui-label text-ui-label px-3 py-1 rounded-full transition-colors
                       {{ request('category_id') == $category->id ? 'bg-emerald-500 text-white' : 'bg-surface-container-high text-on-surface hover:bg-surface-bright hover:text-emerald-400 border border-outline-variant' }}">
                        #{{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Newsletter Widget --}}
        <div class="flex flex-col gap-6 bg-primary-container/20 p-6 rounded-xl border border-emerald-500/20 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
            <h3 class="font-h3 text-h3 text-on-surface">The Monthly Dispatch</h3>
            <p class="font-body-md text-body-md text-on-surface-variant">
                One high-signal email per month. No spam, just deep technical insights.
            </p>
            <form class="flex flex-col gap-3 mt-3">
                <input class="bg-surface-container-lowest border border-outline text-on-surface font-ui-label text-ui-label rounded-md px-3 py-3 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all placeholder:text-on-surface-variant/50"
                       placeholder="email@example.com" type="email">
                <button class="bg-emerald-500 text-white font-ui-label text-ui-label rounded-md px-3 py-3 hover:bg-emerald-600 transition-colors shadow-sm" type="button">
                    Subscribe
                </button>
            </form>
        </div>
    </aside>
</div>
@endsection
