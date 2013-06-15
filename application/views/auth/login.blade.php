@layout('base')
@section('title')
Login
@endsection
@section('content')
<h1>Login</h1>
{{ Form::open('login') }}
    <!-- check for login errors flash var -->
    @if (Session::has('login_errors'))
        <p class="error">Username or password incorrect.</p>
    @endif
    {{ Form::token() }}
    <!-- username field -->
    <p>{{ Form::label('username', 'Email') }}</p>
    <p>{{ Form::text('email') }}</p>
    <!-- password field -->
    <p>{{ Form::label('password', 'Password') }}</p>
    <p>{{ Form::password('password') }}</p>

    <!-- password field -->
    <p>{{ Form::label('remember_me', 'Remember me') }}
    {{ Form::checkbox('remember_me', 1) }}</p>
    <!-- submit button -->
    <p>{{ Form::submit('Login') }}</p>
{{ Form::close() }}
@endsection
