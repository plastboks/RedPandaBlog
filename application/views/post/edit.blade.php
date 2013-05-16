@layout('base')
@section('title')
Edit post {{ $post->title }}
@endsection
@section('content')
    {{ Form::open('admin/updatepost/'.$post->id) }}
        {{ Form::hidden('author_id', $user->id) }}
        <!-- title field -->
        <p>{{ Form::label('title', 'Title') }}</p>
        {{ $errors->first('title', '<p class="error">:message</p>') }}
        <p>{{ Form::text('title', $post->title) }}</p>
        <!-- body field -->
        <p>{{ Form::label('body', 'Body') }}</p>
        {{ $errors->first('body', '<p class="error">:message</p>') }}
        <p>{{ Form::textarea('body', $post->body) }}</p>
        <!-- submit button -->
        <p>{{ Form::submit('Create') }}</p>
    {{ Form::close() }}
@endsection
