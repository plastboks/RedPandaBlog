@layout('admin/index')
@section('content')
  <h1>Posts</h1>
  <h2>{{ HTML::link('admin/post/new', 'Add new') }}</h2>
  <h3>Published posts</h3>
  <div class="tablewrapper round5">
    <table class="list postlist publishedposts">
    <thead>
        <th>Title</th>
        <th>Published</th>
        <th>Author</th>
        <th>Action</th>
    </thead>
    <tbody>
    @foreach ($pubPosts as $post)
      <tr>
        <td class="linklist">
            {{ HTML::link('post/view/'.$post->id, $post->title) }}
        </td>
        <td class="date">{{ $post->created_at }}</td>
        <td class="author">{{ $post->author->username }}</td>
        <td class="action">
          <ul>
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
        </ul>
      </tr>
    @endforeach
    </tbody>
    </table>
  </div>
  <h3>Unpublised posts</h3>
  <div class="tablewrapper round5">
    <table class="list postlist publishedposts">
    <thead>
        <th>Title</th>
        <th>Published</th>
        <th>Author</th>
        <th>Action</th>
    </thead>
    <tbody>
    @foreach ($unpubPosts as $post)
      <tr>
        <td class="linklist">
            {{ HTML::link('post/view/'.$post->id, $post->title) }}
        </td>
        <td class="date">{{ $post->created_at }}</td>
        <td class="author">{{ $post->author->username }}</td>
        <td class="action">
          <ul>
            <li>
              {{ HTML::link('admin/post/edit/'.$post->id, 'Edit') }}
            </li>
            <li class="unpublish">
              {{ HTML::link('admin/post/publish/'.$post->id, 'Publish') }}
            </li>
            <li class="delete">
              {{ HTML::link('admin/post/delete/'.$post->id, 'Delete') }}
            </li>
          </ul>
        </ul>
      </tr>
    @endforeach
    </tbody>
    </table>
  </div>
@endsection
