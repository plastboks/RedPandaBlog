@layout('admin/index')
@section('content')
    <h1>Edit user - {{ $user->username }}</h1>
    @if ($status)
    <p class="message">{{ $status }}</p>
    @endif
    {{ Form::open('admin/user/update/'.$user->id) }}
        {{ Form::token() }}
        <!-- title field -->
        <p>{{ Form::label('username', 'Username') }}</p>
        {{ $errors->first('username', '<p class="error">:message</p>') }}
        <p>{{ Form::text('username', $user->username) }}</p>
        <!-- body field -->
        <p>{{ Form::label('email', 'Email') }}</p>
        {{ $errors->first('email', '<p class="error">:message</p>') }}
        <p>{{ Form::text('email', $user->email) }}</p>
        <!-- password field -->
        <p>{{ Form::label('password', 'Password') }}</p>
        {{ $errors->first('password', '<p class="error">:message</p>') }}
        <p>{{ Form::password('password') }}</p>
        <p>{{ Form::label('password_confirmation', 'Password again') }}</p>
        <p>{{ Form::password('password_confirmation') }}</p>

        <p>{{ Form::label('role', 'Role')}}</p>
        {{ $errors->first('role', '<p class="error">:message</p>') }}
        <p>{{ Form::select('role', array_combine(range(1,3), array('admin', 'publisher', 'editor')), $user->role) }}</p>
        <!-- submit button -->
        <p>{{ Form::submit('Update') }}</p>
    {{ Form::close() }}
@endsection
