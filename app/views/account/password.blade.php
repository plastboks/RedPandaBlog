@extends('account/index')
@section('content')
    <h1>Change password</h1>
    @if ($error)
      <p class="error">{{ $error }}</p>
    @endif
    @if ($status)
      <p class="message">{{ $status }}</p>
    @endif
    {{ Form::open(array('url'=>'account/changepassword')) }}
        {{ Form::token() }}
        <!-- old field -->
        <p>{{ Form::label('old_password', 'Old password') }}</p>
        {{ $errors->first('old_password', '<p class="error">:message</p>') }}
        <p>{{ Form::password('old_password') }}</p>

        <!-- password field -->
        <p>{{ Form::label('password', 'New Password') }}</p>
        {{ $errors->first('password', '<p class="error">:message</p>') }}
        <p>{{ Form::password('password') }}</p>
        <p>{{ Form::label('password_confirmation', 'New password again') }}</p>
        <p>{{ Form::password('password_confirmation') }}</p>
        <!-- submit button -->
        <p>{{ Form::submit('Update') }}</p>
    {{ Form::close() }}
@endsection
