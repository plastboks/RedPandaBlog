@layout('base')
@section('title')
Admin Area
@endsection
@section('content')
    <h1>Admin area</h1>
    <p>{{ HTML::link('admin/newpost', 'Newpost') }}</p>
    @foreach ($posts as $post)
      <p>{{ HTML::link('post/edit/'.$post->id, "Edit - ".$post->title) }}</p>
    @endforeach
@endsection
