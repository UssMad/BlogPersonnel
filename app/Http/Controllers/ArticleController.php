<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;


class ArticleController extends Controller
{

    public function index(Request $request)
    {
        $query = Article::with('category')->where('status', 'published')->latest();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        
        $articles = $query->paginate(6);
        $categories = Category::all();

        return view('articles.index', compact('articles', 'categories'));
    }

    
    public function dashboard()
    {
        $articles = Article::with('category')->latest()->get();
        return view('dashboard', compact('articles'));
    }

    
    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
        ]);

        Article::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Article créé avec succès.');
    }

    
    public function show(Article $article)
    {
        // Si l'article n'est pas publié, seul l'admin connecté peut le voir
        if ($article->status !== 'published' && !auth()->check()) {
            abort(403, 'Cet article n\'est pas accessible.');
        }

        return view('articles.show', compact('article'));
    }

    
    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
        ]);

        // Gestion de la date de publication
        if ($validated['status'] === 'published' && $article->status === 'draft') {
            $validated['published_at'] = now();
        } elseif ($validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }

        $article->update($validated);

        return redirect()->route('dashboard')->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('dashboard')->with('success', 'Article supprimé avec succès.');
    }
}
