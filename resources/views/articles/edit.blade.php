@extends('layouts.admin')

@section('title', 'Edit: ' . $article->title . ' – DevCraft Admin')

@section('content')

<form method="POST" action="{{ route('articles.update', $article) }}" class="flex flex-col h-full">
    @csrf
    @method('PUT')

    {{-- Editor Header / Action Bar --}}
    <header class="sticky top-0 z-40 bg-surface-container-lowest/90 backdrop-blur-md border border-outline-variant rounded-xl px-8 py-5 flex justify-between items-center shadow-[0_4px_30px_rgba(0,0,0,0.1)] mb-10">
        <div class="flex items-center gap-3 font-ui-label text-ui-label text-on-surface-variant">
            <a href="{{ route('dashboard') }}" class="hover:text-emerald-400 transition-colors">Articles</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-on-surface font-semibold">Editing Article</span>
        </div>
        <div class="flex items-center gap-6">
            {{-- Status Toggle --}}
            <div class="flex items-center gap-3">
                <span class="font-ui-label text-ui-label text-on-surface-variant">Status:</span>
                <select name="status"
                        class="bg-surface-container border border-outline-variant text-on-surface font-ui-label text-ui-label rounded-lg focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 block p-2 outline-none cursor-pointer">
                    <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <div class="w-px h-6 bg-outline-variant"></div>

            {{-- Actions --}}
            <a href="{{ route('articles.show', $article) }}"
               class="px-6 py-[10px] rounded-lg text-on-surface border border-outline-variant bg-surface hover:bg-surface-container-high transition-colors font-ui-label text-ui-label flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-[18px]">visibility</span>
                Preview
            </a>
            <button type="submit"
                    class="px-6 py-[10px] rounded-lg bg-emerald-500 text-white hover:bg-emerald-600 transition-colors font-ui-label text-ui-label shadow-sm font-semibold">
                Update Article
            </button>
        </div>
    </header>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="mb-8 bg-red-500/10 border border-red-500/30 text-red-400 px-6 py-4 rounded-lg font-ui-label text-ui-label">
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Editor Workspace --}}
    <div class="max-w-[880px] mx-auto w-full flex flex-col gap-10 pb-32">

        {{-- Title Input --}}
        <div class="flex flex-col gap-3">
            <input type="text"
                   name="title"
                   value="{{ old('title', $article->title) }}"
                   class="w-full bg-transparent border-none font-h1 text-[36px] font-extrabold leading-tight tracking-tight text-on-surface placeholder:text-on-surface-variant/50 focus:ring-0 p-0 focus:outline-none"
                   placeholder="Enter article title..."
                   required>
        </div>

        {{-- Metadata Row --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Category Panel --}}
            <div class="bg-surface-container-low border border-outline-variant rounded-xl p-6 flex flex-col gap-3 shadow-[0_4px_24px_rgba(0,0,0,0.2)] hover:shadow-[0_8px_32px_rgba(0,0,0,0.3)] transition-shadow">
                <label class="font-ui-label text-ui-label text-on-surface-variant flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">folder_open</span>
                    Primary Category
                </label>
                <select name="category_id"
                        class="w-full bg-surface-container border border-outline-variant text-on-surface font-ui-label text-ui-label rounded-lg focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 block p-3 outline-none"
                        required>
                    <option value="" disabled>Select a category...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Reading Time Preview --}}
            <div class="bg-surface-container-low border border-outline-variant rounded-xl p-6 flex flex-col gap-3 shadow-[0_4px_24px_rgba(0,0,0,0.2)]">
                <label class="font-ui-label text-ui-label text-on-surface-variant flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">schedule</span>
                    Estimated Reading Time
                </label>
                <p class="font-body-md text-body-md text-on-surface-variant" id="reading-time-display">
                    {{ $article->reading_time }}
                </p>
            </div>
        </div>

        {{-- Content Area --}}
        <div class="flex-1 flex flex-col rounded-xl shadow-[0_8px_32px_rgba(0,0,0,0.2)] border border-outline-variant overflow-hidden bg-surface-container-low">
            {{-- Toolbar --}}
            <div class="bg-surface-container border-b border-outline-variant px-3 py-2 flex items-center gap-3 flex-wrap">
                <div class="flex-1"></div>
                <span class="font-ui-label text-ui-label text-outline px-2">Markdown Supported</span>
            </div>

            {{-- Main Textarea --}}
            <textarea name="content"
                      id="content-editor"
                      class="w-full flex-1 bg-transparent border-none p-8 font-body-md text-body-md text-on-surface placeholder:text-outline focus:ring-0 focus:outline-none resize-none min-h-[500px] leading-relaxed"
                      placeholder="Start documenting your ideas..."
                      required>{{ old('content', $article->content) }}</textarea>
        </div>
    </div>
</form>

{{-- Reading Time Calculator --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editor = document.getElementById('content-editor');
        const display = document.getElementById('reading-time-display');

        function updateReadingTime() {
            const text = editor.value.trim();
            const wordCount = text ? text.split(/\s+/).length : 0;
            const minutes = Math.max(1, Math.ceil(wordCount / 200));

            if (wordCount === 0) {
                display.textContent = 'Start writing to see estimate...';
            } else {
                display.textContent = `~${minutes} min read (${wordCount} words)`;
            }
        }

        editor.addEventListener('input', updateReadingTime);
        updateReadingTime();
    });
</script>

@endsection
