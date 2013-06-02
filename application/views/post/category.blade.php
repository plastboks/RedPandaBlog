@layout('base')
@section('title')
Search results
@endsection
@section('content')
    <h1>Posts in category {{ $category->title }}</h1>
@unless ($posts->results)
  <h2>No results</h2>
@else
  @foreach ($posts->results as $post)
    <div>
      <h2>{{ HTML::link('post/view/'.$post->id, $post->title) }}</h2>
      <ul class="postinfo">
        <li class="created">Created: {{ $post->created_at }}</lig>
        <li class="updated">Updated: {{ $post->updated_at }}</li>
        <li class="author">Author: {{ $post->author->username }}</li>
      </ul>
      <p>{{ substr($post->body, 0, 120). ' [..]' }}</p> 
      <p>{{ HTML::link('post/view/'.$post->id, 'Read more &rarr;') }}</p>
    </div>
  @endforeach
@endunless
{{ $posts->links() }}
@endsection
