@layout('admin/index')
@section('title')
Edit Category
@endsection
@section('content')
    <h1>Edit category {{ $category->title }}</h1>
    {{ Form::open('admin/category/update/'.$category->id) }}
        {{ Form::token() }}

        <!-- title field -->
        <p>{{ Form::label('title', 'Title') }}</p>
        {{ $errors->first('title', '<p class="error">:message</p>') }}
        <p>{{ Form::text('title', $category->title) }}</p>

        <!-- slug field -->
        <p>{{ Form::label('slug', 'Slug') }}</p>
        {{ $errors->first('slug', '<p class="error">:message</p>') }}
        <p>{{ Form::text('slug', $category->slug) }}</p>

        <!-- submit button -->
        <p>{{ Form::submit('Update') }}</p>
    {{ Form::close() }}
@endsection
