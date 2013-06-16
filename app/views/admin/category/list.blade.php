@extends('admin/index')
@section('content')
  <h1>Categories</h1>
  <ul class='thirdmenu'>
    @if ($p->canI('createCategory'))
      <li>{{ HTML::link('admin/category/new', 'Add new') }}</li>
    @endif
  </ul>
  @if ($status)
    <p class="message">{{$status}}</p>
  @endif 
  <h3>Categories</h3>
  <div class="tablewrapper round5">
    <table class="list postlist publishedposts">
    <thead>
      <th>Title</th>
      <th>Slug</th>
      <th>Post count</th>
      <th>Action</th>
    </thead>
    <tbody>
    @foreach ($categories as $category)
      <tr>
        <td class="title">{{ HTML::link('post/category/'.$category->slug, $category->title) }}</td>
        <td class="slug">{{ $category->slug }}</td>
        <td class="count">{{ count($category->posts()->get()) }}</td>
        <td class="action">
          <ul>
            @if ($p->canI('updateCategory'))
            <li class="edit">{{ HTML::link('admin/category/edit/'.$category->id, 'Edit') }}</li>
            @endif
            @if (!$category->posts()->get() && $p->canI('deleteCategory'))
            <li class="delete">{{ HTML::link('admin/category/delete/'.$category->id, 'Delete') }}</li>
            @endif
          </ul>
        </td>
      </tr>
    @endforeach
    </tbody>
    </table>
  </div>
{{ $categories->links() }}
@endsection
