@extends('admin/index')
@section('title')
Add new image
@endsection
@section('content')
    <h1>New Image</h1>
    {{ Form::open(array('url'=>'admin/role/create')) }}
        {{ Form::token() }}
        <!-- name field -->
        <p>{{ Form::label('name', 'Name') }}</p>
        {{ $errors->first('name', '<p class="error">:message</p>') }}
        <p>{{ Form::text('name', Input::old('name')) }}</p>

        <!-- file field -->
        <p>{{ Form::label('file', 'File') }}</p>
        {{ $errors->first('file', '<p class="error">:message</p>') }}
        <p>{{ Form::file('file', Input::old('file')) }}</p>
        <!-- submit button -->
        <p>{{ Form::submit('Create') }}</p>
    {{ Form::close() }}
@endsection
