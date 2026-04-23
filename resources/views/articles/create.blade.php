<h1>Create Article</h1>

<form action="{{ route('articles.store') }}" method="POST">
    @csrf

    <label>Title:</label><br>
    <input type="text" name="title"><br><br>

    <label>Content:</label><br>
    <textarea name="content"></textarea><br><br>

    <label>Category:</label><br>
    <select name="category_id">
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select><br><br>

    <label>Status:</label><br>
    <select name="status">
        <option value="draft">Draft</option>
        <option value="published">Published</option>
    </select><br><br>

    <button type="submit">Create</button>
</form>