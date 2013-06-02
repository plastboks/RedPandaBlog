@layout('admin/index')
@section('content')
  <h1>Categories</h1>
  <h2>{{ HTML::link('admin/category/new', 'Add new') }}</h2>
  <p>
    <h2>Categories</h2>
    <ul class="postlist publishedposts">
    @foreach ($categories as $category)
      <li>
        <ul class="linklist">
          <li class="title">{{ $category->title }}</li>
          <li class="count">Post count: {{ count($category->posts()->get()) }}</li>
          @if (!$category->posts()->get())
          <li class="delete">{{ HTML::link('admin/category/delete/'.$category->id, 'Delete') }}</li>
          @endif
        </ul>
      </li>
    @endforeach
    </ul>
  </p>
@endsection
