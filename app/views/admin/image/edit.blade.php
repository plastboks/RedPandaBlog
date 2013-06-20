@extends('admin/index')
@section('title')
Edit Image
@endsection
@section('content')
    <h1>Edit image {{ $image->name }}</h1>
    {{ Form::open(array('url'=>'admin/image/update/'.$image->id)) }}
        {{ Form::token() }}

        <!-- name field -->
        <p>{{ Form::label('name', 'Name') }}</p>
        {{ $errors->first('name', '<p class="error">:message</p>') }}
        <p>{{ Form::text('name', $image->name) }}</p>

        <!-- submit button -->
        <p>{{ Form::submit('Update') }}</p>
    {{ Form::close() }}
@endsection
