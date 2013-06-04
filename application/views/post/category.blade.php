@layout('base')
@section('title')
Search results
@endsection
@section('content')
@unless ($posts->results)
    <h1>No results</h1>
@else
  @if (count($posts) > 1)
      <h1>Posts in category {{ $category->title }}</h1>
  @else
      <h1>Post in category {{ $category->title }}</h1>
  @endif
  @foreach ($posts->results as $post)
    <div class="post">
      <h2>{{ HTML::link('post/view/'.$post->id, $post->title) }}</h2>
      <ul class="postinfo">
        <li class="created">Created: {{ $post->created_at }}, </li>
        <li class="updated">Updated: {{ $post->updated_at }}, </li>
        <li class="author">Author: {{ $post->author->username }}, </li>
        @if ($post->categories)
          <li class="categories">Categories: 
          @foreach ($post->categories as $category)
              {{ HTML::link('post/category/'.$category->slug, $category->title) }}
          @endforeach
          </li>
        @endif
      </ul>
      @if ($post->excerpt)
        <p>{{ substr($post->excerpt, 0, 400). ' [..]' }}</p> 
      @else
        <p>{{ substr($post->body, 0, 400). ' [..]' }}</p> 
      @endif
      <p class="readmore">{{ HTML::link('post/view/'.$post->id, 'Read more &rarr;') }}</p>
    </div>
  @endforeach
@endunless
{{ $posts->links() }}
@endsection
