@layout('account/index')
@section('content')
    <h1>My Account</h1>
    @if ($status)
    <p class="message">{{ $status }}</p>
    @endif
    {{ Form::open('account/update') }}
        {{ Form::token() }}
        <!-- title field -->
        <p>{{ Form::label('username', 'Username') }}</p>
        {{ $errors->first('username', '<p class="error">:message</p>') }}
        <p>{{ Form::text('username', $user->username) }}</p>
        <!-- email field -->
        <p>{{ Form::label('email', 'Email') }}</p>
        {{ $errors->first('email', '<p class="error">:message</p>') }}
        <p>{{ Form::text('email', $user->email) }}</p>
        <!-- submit button -->
        <p>{{ Form::submit('Update') }}</p>
    {{ Form::close() }}
@endsection
