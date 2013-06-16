@extends('account/index')
@section('content')
  <h1>My posts</h1>
  <div class="tablewrapper round5">
    <table class="list postlist publishedposts">
    <thead>
        <th>Title</th>
        <th>Published</th>
        <th>Author</th>
        <th>Action</th>
    </thead>
    <tbody>
    @foreach ($posts as $post)
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
            @if ($p->canI('deletePost'))
            <li class="delete">
              {{ HTML::link('admin/post/delete/'.$post->id, 'Delete') }}
            </li>
            @endif
          </ul>
        </ul>
      </tr>
    @endforeach
    </tbody>
    </table>
  </div>
{{ $posts->links() }}
@endsection
