<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>{{ $post->title }}</title>
</head>

<body>
    <a href="{{ route('posts.index') }}">← 一覧に戻る</a>

    <h1>{{ $post->title }}</h1>
    <span>{{ $post->category }}</span>
    <span>{{ $post->created_at->format('Y/m/d') }}</span>
    <hr>
    <div id="toc"></div>
    <hr>
    <div id="article-body">{!! $post->body !!}</div>
    <span>投稿者：{{ $post->user->name }}</span>

    @auth
        @if($post->user_id === auth()->id())
            <a href="{{ route('posts.edit', $post) }}">編集</a>
            <form action="{{ route('posts.destroy', $post) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">削除</button>
            </form>
        @endif
    @endauth
    <script>
        const body = document.getElementById('article-body');
        const toc = document.getElementById('toc');
        const headers = body.querySelectorAll('h1, h2');

        if (headers.length > 0) {
            const list = document.createElement('ul');

            headers.forEach((header) => {
                const item = document.createElement('li');
                item.textContent = header.textContent;

                // h2はh1より少しインデントする
                if (header.tagName === 'H2') {
                    item.style.marginLeft = '16px';
                }

                list.appendChild(item);
            });

            toc.appendChild(list);
        }
    </script>
</body>

</html>