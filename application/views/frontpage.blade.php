@layout('base')
@section('title')
Welcome
@endsection
@section('content')
    <h1>Welcome!</h1>
    @if ($errormessage)
    <p class="errormessage">{{ $errormessage }}</p>
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
    <p class='readmore'>{{ HTML::link('post/view/'.$post->id, 'Read more &rarr;') }}</p>
  </div>
@endforeach
{{ $posts->links() }}
@endsection
