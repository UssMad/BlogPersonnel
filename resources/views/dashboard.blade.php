@extends('layouts.admin')

@section('title', 'Articles Directory – DevCraft Admin')

@section('content')

{{-- Page Header --}}
<header class="flex justify-between items-end mb-16">
    <div>
        <h1 class="font-h1 text-h1 text-on-surface">Articles Directory</h1>
        <p class="font-body-md text-body-md text-on-surface-variant mt-3 max-w-2xl">
            Manage your editorial pipeline. Review drafts, update published content, and monitor technical documentation integrity across the platform.
        </p>
    </div>
    <a href="{{ route('articles.create') }}"
       class="bg-emerald-500 text-white px-6 py-3 rounded-lg font-ui-label text-ui-label flex items-center gap-2 shadow-sm hover:bg-emerald-600 transition-colors h-fit whitespace-nowrap">
        <span class="material-symbols-outlined text-[18px]">edit_document</span>
        Create New Article
    </a>
</header>

{{-- Data Table Container --}}
<div class="bg-surface-container-low rounded-xl border border-outline-variant/30 overflow-hidden ambient-shadow">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container border-b border-outline-variant/50">
                    <th class="py-6 px-6 font-ui-label text-ui-label text-on-surface-variant uppercase tracking-wider">Title</th>
                    <th class="py-6 px-6 font-ui-label text-ui-label text-on-surface-variant uppercase tracking-wider w-48">Category</th>
                    <th class="py-6 px-6 font-ui-label text-ui-label text-on-surface-variant uppercase tracking-wider w-32">Status</th>
                    <th class="py-6 px-6 font-ui-label text-ui-label text-on-surface-variant uppercase tracking-wider w-40">Date</th>
                    <th class="py-6 px-6 font-ui-label text-ui-label text-on-surface-variant uppercase tracking-wider w-24 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/20">
                @forelse($articles as $article)
                    <tr class="hover:bg-surface-container-highest/30 transition-colors group">
                        {{-- Title & Excerpt --}}
                        <td class="py-3 px-6">
                            <a href="{{ route('articles.show', $article) }}" class="block">
                                <div class="font-h3 text-on-surface text-[20px] mb-1 group-hover:text-emerald-400 transition-colors">
                                    {{ $article->title }}
                                </div>
                                <div class="font-body-md text-on-surface-variant text-[15px]">
                                    {{ Str::limit(strip_tags($article->content), 100) }}
                                </div>
                            </a>
                        </td>

                        {{-- Category --}}
                        <td class="py-3 px-6 align-top pt-6">
                            <span class="inline-flex bg-emerald-500/10 text-emerald-400 rounded-full px-3 py-1 font-ui-label text-ui-label items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                #{{ $article->category->name }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td class="py-3 px-6 align-top pt-6">
                            @if($article->status === 'published')
                                <span class="inline-flex bg-tertiary/10 text-tertiary border border-tertiary/20 rounded-full px-3 py-1 font-ui-label text-ui-label">
                                    Published
                                </span>
                            @else
                                <span class="inline-flex bg-inverse-primary/20 text-on-surface-variant border border-outline-variant/30 rounded-full px-3 py-1 font-ui-label text-ui-label">
                                    Draft
                                </span>
                            @endif
                        </td>

                        {{-- Date --}}
                        <td class="py-3 px-6 align-top pt-6 font-code-block text-code-block text-on-surface-variant">
                            {{ $article->created_at->format('M d, Y') }}
                        </td>

                        {{-- Actions --}}
                        <td class="py-3 px-6 align-top pt-6 text-right">
                            <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                {{-- Edit --}}
                                <a href="{{ route('articles.edit', $article) }}"
                                   class="text-on-surface-variant hover:text-emerald-400 transition-colors p-1 rounded hover:bg-surface-container-highest"
                                   title="Edit">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>

                                {{-- Delete with confirmation --}}
                                <form method="POST" action="{{ route('articles.destroy', $article) }}"
                                      onsubmit="return confirm('Are you sure you want to delete &quot;{{ addslashes($article->title) }}&quot;? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-on-surface-variant hover:text-red-400 transition-colors p-1 rounded hover:bg-red-500/10"
                                            title="Delete">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <span class="material-symbols-outlined text-[48px] text-outline mb-4 block">article</span>
                            <p class="font-body-lg text-body-lg text-on-surface-variant">No articles yet. Create your first one!</p>
                            <a href="{{ route('articles.create') }}"
                               class="inline-flex items-center gap-2 mt-4 bg-emerald-500 text-white px-6 py-3 rounded-lg font-ui-label text-ui-label hover:bg-emerald-600 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">add</span>
                                Create Article
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Footer --}}
    @if($articles->hasPages())
        <div class="bg-surface-container border-t border-outline-variant/30 px-6 py-3 flex items-center justify-between">
            <span class="font-ui-label text-ui-label text-on-surface-variant">
                Showing {{ $articles->firstItem() }} to {{ $articles->lastItem() }} of {{ $articles->total() }} entries
            </span>
            <div class="flex gap-1">
                @if($articles->onFirstPage())
                    <span class="p-1 rounded text-on-surface-variant opacity-50">
                        <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                    </span>
                @else
                    <a href="{{ $articles->previousPageUrl() }}" class="p-1 rounded text-on-surface-variant hover:bg-surface-container-highest hover:text-on-surface transition-colors">
                        <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                    </a>
                @endif

                @if($articles->hasMorePages())
                    <a href="{{ $articles->nextPageUrl() }}" class="p-1 rounded text-on-surface-variant hover:bg-surface-container-highest hover:text-on-surface transition-colors">
                        <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                    </a>
                @else
                    <span class="p-1 rounded text-on-surface-variant opacity-50">
                        <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                    </span>
                @endif
            </div>
        </div>
    @endif
</div>

@endsection
