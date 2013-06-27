@extends('admin/index')
@section('title')
Add new image
@endsection
@section('content')
    <h1>New Image</h1>
    {{ Form::open(array('url'=>'admin/image/create', 'files' => true)) }}
        {{ Form::token() }}
        <!-- name field -->
        <p>{{ Form::label('title', 'Title') }}</p>
        {{ $errors->first('title', '<p class="error">:message</p>') }}
        <p>{{ Form::text('title', Input::old('name')) }}</p>

        <!-- file field -->
        <p>{{ Form::label('image', 'File') }}</p>
        {{ $errors->first('image', '<p class="error">:message</p>') }}
        <p>{{ Form::file('image', Input::old('file')) }}</p>
        <!-- submit button -->
        <p>{{ Form::submit('Create') }}</p>
    {{ Form::close() }}
@endsection
