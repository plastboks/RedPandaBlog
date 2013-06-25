@extends('admin/index')
@section('content')
  <h1>Categories</h1>
  <ul class='thirdmenu'>
    <li>{{ HTML::link('admin/category/list', 'Public')}}</li>
    @if ($p->canI('seeArchivedCategories'))
      <li>{{ HTML::link('admin/category/archived', 'Archived') }}</li>
    @endif
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
          @unless ($archived)
            @if ($p->canI('updateCategory'))
              <li class="edit">{{ HTML::link('admin/category/edit/'.$category->id, 'Edit') }}</li>
            @endif
            @if (!count($category->posts()->get()) && $p->canI('deleteCategory'))
              <li class="delete">{{ HTML::link('admin/category/delete/'.$category->id, 'Archive') }}</li>
            @endif
          @else
            @if ($p->canI('undeleteCategory'))
              <li class="delete">{{ HTML::link('admin/category/undelete/'.$category->id, 'Unarchive') }}</li>
            @endif
            @if ($p->canI('truedeleteCategory'))
              <li class="delete">{{ HTML::link('admin/category/truedelete/'.$category->id, 'Delete') }}</li>
            @endif
          @endunless
          </ul>
        </td>
      </tr>
    @endforeach
    </tbody>
    </table>
  </div>
{{ $categories->links() }}
@endsection
