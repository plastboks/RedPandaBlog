@extends('admin/index')
@section('content')
  <h1>Posts</h1>
  <ul class="thirdmenu">
    <li>{{ HTML::link('admin/post/list', 'Published') }}</li>
    <li>{{ HTML::link('admin/post/unpublished', 'Unpublished') }}</li>
    <li>{{ HTML::link('admin/post/archived', 'Archived') }}</li>
    <li>{{ HTML::link('admin/post/new', 'Add new') }}</li>
  </ul>
  <h3>{{ $title }}</h3>
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
            @unless ($archived)
            {{ HTML::link('post/view/'.$post->id, $post->title) }}
            @else
              {{ $post->title }}
            @endunless
        </td>
        <td class="date">{{ $post->created_at }}</td>
        <td class="author">{{ $post->author->username }}</td>
        <td class="action">
          <ul>
            @unless ($archived)
              @if ($p->canI('updatePost'))
              <li class="edit">
                {{ HTML::link('admin/post/edit/'.$post->id, 'Edit') }}
              </li>
              @endif
              @if ($p->canI('changePostState') && $action)
              <li class="unpublish">
                {{ HTML::link('admin/post/'.$action.'/'.$post->id, ucwords($action)) }}
              </li>
              @endif
              @if ($p->canI('deletePost'))
              <li class="delete">
                {{ HTML::link('admin/post/delete/'.$post->id, 'Archive') }}
              </li>
              @endif
            @else
              @if ($p->canI('undeletePost'))
              <li class="delete">
                {{ HTML::link('admin/post/undelete/'.$post->id, 'Unarchive') }}
              </li>
              @endif
              @if ($p->canI('truePost'))
              <li class="delete">
                {{ HTML::link('admin/post/truedelete/'.$post->id, 'Delete') }}
              </li>
              @endif
            @endunless
          </ul>
        </ul>
      </tr>
    @endforeach
    </tbody>
    </table>
  </div>
{{ $posts->links() }}
@endsection
