<div class="section is__paddingless simple__post__section">
    @if(isset($post))
        <div class="container">
            <img src="{{ url($post->image) }}" alt="{{ $post->title }}" class="img-responsive">
        </div>
        <div class="container pad-5-xs pad-0-md">
            <div class="section__header">
                <h3 class="col-12-xs col-md">{{ $post->title }}</h3>
                <p class="col-12-xs col-md date">{{ $post->created }}</p>
            </div>
            <div class="body">
                {!! $post->body !!}
            </div>
        </div>
    @else
        <p>ничего не найдено</p>
    @endif
</div>