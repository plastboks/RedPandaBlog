@layout('admin/index')
@section('title')
Edit Blog Settings
@endsection
@section('content')
    <h1>Edit Blog Settings</h1>
    {{ Form::open('admin/settings') }}
        {{ Form::token() }}

        <!-- blogName field -->
        <p>{{ Form::label('blogName', 'Blog name') }}</p>
        {{ $errors->first('blogName', '<p class="error">:message</p>') }}
        <p>{{ Form::text('blogName', $s->blogName) }}</p>

        <!-- footer field -->
        <p>{{ Form::label('footertext', 'Footer text') }}</p>
        {{ $errors->first('footertext', '<p class="error">:message</p>') }}
        <p>{{ Form::textarea('footertext', $s->footer) }}</p>

        <!-- posts per page field -->
        <p>{{ Form::label('postperpage', 'Posts per page') }}</p>
        {{ $errors->first('postsperpage', '<p class="error">:message</p>') }}
        <p>{{ Form::select('postsperpage', array_combine(range(3, 20), range(3, 20)), $s->postsPerPage) }}</p>

        <!-- excerpt cut field -->
        <p>{{ Form::label('excerptCut', 'Excerpt length') }}</p>
        {{ $errors->first('excerptCut', '<p class="error">:message</p>') }}
        <p>{{ Form::select('excerptCut', array_combine(range(50, 800, 50), range(50, 800, 50)), $s->excerptCut) }}</p>

        <!-- submit button -->
        <p>{{ Form::submit('Update') }}</p>
    {{ Form::close() }}
@endsection
