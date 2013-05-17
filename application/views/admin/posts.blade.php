@layout('admin/index')
@section('content')
  <h1>Posts on this site</h1>
  <h2>{{ HTML::link('admin/newpost', 'Add new') }}</h2>
  <p>
    <ul>
    @foreach ($posts as $post)
      <li>{{ HTML::link('post/view/'.$post->id, $post->title) }}
          - {{ HTML::link('post/edit/'.$post->id, 'Edit') }}</li>
    @endforeach
    </ul>
  </p>
@endsection
