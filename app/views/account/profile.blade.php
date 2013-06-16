@extends('account/index')
@section('content')
    <h1>My Account</h1>
    @if ($status)
    <p class="message">{{ $status }}</p>
    @endif
    {{ Form::open(array('url' => 'account/update')) }}
        {{ Form::token() }}
        <!-- title field -->
        <p>{{ Form::label('username', 'Username') }}</p>
        {{ $errors->first('username', '<p class="error">:message</p>') }}
        <p>{{ Form::text('username', $user->username) }}</p>
        <!-- givenname field -->
        <p>{{ Form::label('givenname', 'Givenname') }}</p>
        {{ $errors->first('givenname', '<p class="error">:message</p>') }}
        <p>{{ Form::text('givenname', $user->givenname) }}</p>
        <!-- surname field -->
        <p>{{ Form::label('surname', 'Surname') }}</p>
        {{ $errors->first('surname', '<p class="error">:message</p>') }}
        <p>{{ Form::text('surname', $user->surname) }}</p>
        <!-- email field -->
        <p>{{ Form::label('email', 'Email') }}</p>
        {{ $errors->first('email', '<p class="error">:message</p>') }}
        <p>{{ Form::text('email', $user->email) }}</p>
        <!-- info field -->
        <p>{{ Form::label('info', 'Info') }}</p>
        {{ $errors->first('info', '<p class="error">:message</p>') }}
        <p>{{ Form::textarea('info', $user->info) }}</p>
        <!-- submit button -->
        <p>{{ Form::submit('Update') }}</p>
    {{ Form::close() }}
@endsection
