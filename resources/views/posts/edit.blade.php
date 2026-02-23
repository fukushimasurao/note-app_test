<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>記事編集</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body>
    <h1>記事編集</h1>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>タイトル</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}">
        </div>

        <div>
            <label>カテゴリ</label>
            <select name="category">
                <option value="">選択してください</option>
                <option value="tech" {{ old('category', $post->category) == 'tech' ? 'selected' : '' }}>Tech</option>
                <option value="life" {{ old('category', $post->category) == 'life' ? 'selected' : '' }}>Life</option>
                <option value="idea" {{ old('category', $post->category) == 'idea' ? 'selected' : '' }}>Idea</option>
            </select>
        </div>

        <div>
            <label>本文</label>
            <div id="editor" style="height: 300px;"></div>
            <input type="hidden" name="body" id="body">
        </div>

        <button type="submit">更新する</button>
    </form>

    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        const quill = new Quill('#editor', { theme: 'snow' });
        quill.root.innerHTML = `{!! $post->body !!}`;

        document.querySelector('form').addEventListener('submit', function () {
            document.getElementById('body').value = quill.root.innerHTML;
        });
    </script>
</body>

</html>