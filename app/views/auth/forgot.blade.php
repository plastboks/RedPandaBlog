@extends('base')
@section('title')
Forgot password
@endsection
@section('content')
<h1>Forgot password</h1>
{{ Form::open(array('url'=>'auth/sendmail')) }}
    {{ Form::token() }}
    {{ $errors->first('email', '<p class="error">:message</p>') }}
    <!-- username field -->
    <p>{{ Form::label('email', 'Email') }}</p>
    <p>{{ Form::text('email') }}</p>
    <!-- submit button -->
    <p>{{ Form::submit('Send') }}</p>
{{ Form::close() }}
@endsection
