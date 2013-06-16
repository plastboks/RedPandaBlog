@extends('base')
@section('content')
    <h1>New password</h1>
    @if ($error)
      <p class="error">{{ $error }}</p>
    @endif
    @if ($status)
      <p class="message">{{ $status }}</p>
    @endif
    {{ Form::open(array('url'=>'password/forgot')) }}
        {{ Form::token() }}
        {{ Form::hidden('confirmcode', $token) }}
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
