@layout('base')
@section('title')
Alexanders dope blog
@endsection
@section('content')
    <h1>Welcome!</h1>
@foreach ($posts as $post)
  <div>
    <h2>{{ HTML::link('post/view/'.$post->id, $post->title) }}</h2>
    <p class="timestamps">
      <span class="created">Created: {{ $post->created_at }}</span>
      <span class="updated">Updated: {{ $post->updated_at }}</span>
    </p>
    <p>Author: {{ $post->author->username }}</p>
    <p>{{ $post->body }}</p>
  </div>
@endforeach
@endsection
