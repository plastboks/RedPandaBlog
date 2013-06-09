@layout('admin/index')
@section('content')
  <h1>Categories</h1>
  <h2>{{ HTML::link('admin/category/new', 'Add new') }}</h2>
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
    @foreach ($categories->results as $category)
      <tr>
        <td class="title">{{ HTML::link('post/category/'.$category->slug, $category->title) }}</td>
        <td class="slug">{{ $category->slug }}</td>
        <td class="count">{{ count($category->posts()->get()) }}</td>
        <td class="action">
          <ul>
            <li class="edit">{{ HTML::link('admin/category/edit/'.$category->id, 'Edit') }}</li>
            @if (!$category->posts()->get())
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
