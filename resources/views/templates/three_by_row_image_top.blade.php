<div class="three__by__row__image__top">
    <div class="image__wrapper">
        <img src="{{ url($post->image) }}" alt="{{ $post->title }}">
    </div>
    <div class="info">
        <a href="{{ (isset($slugIsUrl) && $slugIsUrl) ? url($post->slug) : \App\PagesService::pageRoute($page->code, [$post->slug]) }}">
            <p class="title">{{ $post->title }}</p>
            <p class="date">{{ $post->created_at }}</p>
            <p class="cat">{{ $post->postCategory->title }}</p>
        </a>
    </div>
</div>