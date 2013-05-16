@layout('base')
@section('title')
{{ $post->title }}
@endsection
@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->body }}</p>
    @if (!Auth::guest())
      {{ HTML::link('post/edit/'.$post->id, 'Edit') }}  
    @endif
@endsection
