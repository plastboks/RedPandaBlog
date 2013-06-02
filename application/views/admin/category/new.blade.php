@layout('admin/index')
@section('title')
Add new category
@endsection
@section('content')
    <h1>New category</h1>
    {{ Form::open('admin/category/create') }}
        {{ Form::token() }}
        <!-- title field -->
        <p>{{ Form::label('title', 'Title') }}</p>
        {{ $errors->first('title', '<p class="error">:message</p>') }}
        <p>{{ Form::text('title', Input::old('title')) }}</p>
        <!-- slug field -->
        <p>{{ Form::label('slug', 'Slug') }}</p>
        {{ $errors->first('slug', '<p class="error">:message</p>') }}
        <p>{{ Form::text('slug', Input::old('slug')) }}</p>
        <!-- submit button -->
        <p>{{ Form::submit('Create') }}</p>
    {{ Form::close() }}
@endsection
