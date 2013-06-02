@layout('admin/index')
@section('title')
Add new post
@endsection
@section('content')
    <h1>New post</h1>
    {{ Form::open('admin/post/create') }}
        {{ Form::hidden('author_id', $user->id) }}
        {{ Form::token() }}
        <!-- title field -->
        <p>{{ Form::label('title', 'Title') }}</p>
        {{ $errors->first('title', '<p class="error">:message</p>') }}
        <p>{{ Form::text('title', Input::old('title')) }}</p>
        <!-- body field -->
        <p>{{ Form::label('body', 'Body') }}</p>
        {{ $errors->first('body', '<p class="error">:message</p>') }}
        <p>{{ Form::textarea('body', Input::old('body')) }}</p>
        <p>{{ Form::label('published', 'Published' )}}</p>
        {{ $errors->first('published') }}
        <p>{{ Form::checkbox('published', Input::old('published', true)) }}</p>
        <!-- submit button -->
        <p>{{ Form::submit('Create') }}</p>
    {{ Form::close() }}
@endsection
