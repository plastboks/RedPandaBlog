@layout('admin/index')
@section('content')
    <h1> Add a new user</h1>
    <p class="message">{{ $status }}</p>
    {{ Form::open('admin/user/create') }}
        <!-- title field -->
        <p>{{ Form::label('username', 'Username') }}</p>
        {{ $errors->first('username', '<p class="error">:message</p>') }}
        <p>{{ Form::text('username', $username) }}</p>
        <!-- body field -->
        <p>{{ Form::label('email', 'Email') }}</p>
        {{ $errors->first('email', '<p class="error">:message</p>') }}
        <p>{{ Form::text('email', $email) }}</p>
        <!-- password field -->
        <p>{{ Form::label('password', 'Password') }}</p>
        {{ $errors->first('password', '<p class="error">:message</p>') }}
        <p>{{ Form::password('password') }}</p>
        <p>{{ Form::label('password_confirmation', 'Password again') }}</p>
        <p>{{ Form::password('password_confirmation') }}</p>
        <!-- submit button -->
        <p>{{ Form::submit('Update') }}</p>
    {{ Form::close() }}
@endsection
