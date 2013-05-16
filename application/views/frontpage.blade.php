@layout('base')
@section('title')
Alexanders dope blog
@endsection
@section('content')
    <h1>Welcome!</h1>
@foreach ($posts as $post)
  <div>
    <p><h2>{{ HTML::link('post/view/'.$post->id, $post->title) }}</h2></p>
    <p><span>Created: {{ $post->created_at }}</span></p>
    <p>{{ $post->body }}</p>
    <p>Updated: {{ $post->updated_at }}</p>
  </div>
@endforeach
@endsection
