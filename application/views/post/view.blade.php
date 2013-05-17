@layout('base')
@section('title')
{{ $post->title }}
@endsection
@section('content')
  <div>
    <h1>{{ $post->title }}</h1>
    <p class="timestamps">
      <span class="created">Created: {{ $post->created_at }}</span>
      <span class="updated">Updated: {{ $post->updated_at }}</span>
    </p>
    <p>Author: {{ $post->author->username }}</p>
    <p>{{ $post->body }}</p>
    @if (!Auth::guest())
      {{ HTML::link('post/edit/'.$post->id, 'Edit') }}  
    @endif
  </div>
@endsection
