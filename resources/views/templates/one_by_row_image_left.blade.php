<div class="one__by__row__image__left">
    <div class="image__wrapper">
        <img src="{{ url($post->image) }}" alt="{{ $post->title }}">
    </div>
    <div class="info">
        <a href="{{ $post->url }}">
            <p class="title">{{ $post->title }}</p>
            <p class="date">{{ $post->created_at }}</p>
            <p class="excerpt">{{ $post->excerpt }}</p>
        </a>
    </div>
</div>