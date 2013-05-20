@layout('admin/index')
@section('content')
  <h1>Posts on this site</h1>
  <h2>{{ HTML::link('admin/post/new', 'Add new') }}</h2>
  <p>
    <h2>Published posts</h2>
    <ul class="postlist publishedposts">
    @foreach ($pubPosts as $post)
      <li>
        <ul class="linklist">
          <li class="title">
            {{ HTML::link('post/view/'.$post->id, $post->title) }}
          </li>
          <li class="edit">
            {{ HTML::link('admin/post/edit/'.$post->id, 'Edit') }}
          </li>
          <li class="unpublish">
            {{ HTML::link('admin/post/unpublish/'.$post->id, 'Unpublish') }}
          </li>
          <li class="delete">
            {{ HTML::link('admin/post/delete/'.$post->id, 'Delete') }}
          </li>
        </ul>
      </li>
    @endforeach
    </ul>
  </p>
  <p>
    <h2>Unpublised posts</h2>
    <ul class="postlist unpublishedpost">
    @foreach ($unpubPosts as $post)
      <li>
        <ul class="linklist">
          <li class="title">
            {{ HTML::link('post/view/'.$post->id, $post->title) }}
          </li>
          <li class="edit">
            {{ HTML::link('admin/post/edit/'.$post->id, 'Edit') }}
          </li>
          <li class="publish">
            {{ HTML::link('admin/post/publish/'.$post->id, 'Publish') }}
          </li>
          <li class="delete">
            {{ HTML::link('admin/post/delete/'.$post->id, 'Delete') }}
          </li>
        </ul>
      </li>
    @endforeach
    </ul>
  </p>
@endsection
