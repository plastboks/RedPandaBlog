@layout('admin/index')
@section('content')
  <h1>Posts on this site</h1>
  <h2>{{ HTML::link('admin/post/new', 'Add new') }}</h2>
  <p>
    <ul>
    @foreach ($posts as $post)
      <li>{{ HTML::link('post/view/'.$post->id, $post->title) }}
          - {{ HTML::link('admin/post/edit/'.$post->id, 'Edit') }}</li>
    @endforeach
    </ul>
  </p>
@endsection
