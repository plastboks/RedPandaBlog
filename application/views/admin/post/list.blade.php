@layout('admin/index')
@section('content')
  <h1>Posts on this site</h1>
  <h2>{{ HTML::link('admin/post/new', 'Add new') }}</h2>
  <p>
    <h2>Published posts</h2>
    <ul>
    @foreach ($pubPosts as $post)
      <li>{{ HTML::link('post/view/'.$post->id, $post->title) }}
          - {{ HTML::link('admin/post/edit/'.$post->id, 'Edit') }}
          - {{ HTML::link('admin/post/delete/'.$post->id, 'Delete') }}</li>
    @endforeach
    </ul>
  </p>
  <p>
    <h2>Unpublised posts</h2>
    <ul>
    @foreach ($unpubPosts as $post)
      <li>{{ HTML::link('post/view/'.$post->id, $post->title) }}
          - {{ HTML::link('admin/post/edit/'.$post->id, 'Edit') }}
          - {{ HTML::link('admin/post/delete/'.$post->id, 'Delete') }}</li>
    @endforeach
    </ul>
  </p>
@endsection
