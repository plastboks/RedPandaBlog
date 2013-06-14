@layout('admin/index')
@section('content')
    <h1> Add a new user</h1>
    @if ($status)
    <p class="message">{{ $status }}</p>
    @endif
    {{ Form::open('admin/user/create') }}
        {{ Form::token() }}

        <!-- username field -->
        <p>{{ Form::label('username', 'Username') }}</p>
        {{ $errors->first('username', '<p class="error">:message</p>') }}
        <p>{{ Form::text('username', $username) }}</p>

        <!-- email field -->
        <p>{{ Form::label('email', 'Email') }}</p>
        {{ $errors->first('email', '<p class="error">:message</p>') }}
        <p>{{ Form::text('email', $email) }}</p>

        <!-- givenname field -->
        <p>{{ Form::label('givenname', 'Givenname') }}</p>
        {{ $errors->first('givenname', '<p class="error">:message</p>') }}
        <p>{{ Form::text('givenname') }}</p>

        <!-- surname field -->
        <p>{{ Form::label('surname', 'Surname') }}</p>
        {{ $errors->first('surname', '<p class="error">:message</p>') }}
        <p>{{ Form::text('surname') }}</p>

        <!-- password field -->
        <p>{{ Form::label('password', 'Password') }}</p>
        {{ $errors->first('password', '<p class="error">:message</p>') }}
        <p>{{ Form::password('password') }}</p>
        <p>{{ Form::label('password_confirmation', 'Password again') }}</p>
        <p>{{ Form::password('password_confirmation') }}</p>

        <p>{{ Form::label('role', 'Role')}}</p>
        {{ $errors->first('role', '<p class="error">:message</p>') }}
        <p>{{ Form::select('role', $roles, 1) }}</p>

        <!-- info field -->
        <p>{{ Form::label('info', 'Info') }}</p>
        {{ $errors->first('info', '<p class="error">:message</p>') }}
        <p>{{ Form::textarea('info') }}</p>

        <!-- submit button -->
        <p>{{ Form::submit('Update') }}</p>
    {{ Form::close() }}
@endsection
