@extends('admin/index')
@section('title')
Add new post
@endsection
@section('content')
    <h1>New post</h1>
    {{ Form::open(array('url'=>'admin/post/create')) }}
        {{ Form::hidden('author_id', $user->id) }}
        {{ Form::token() }}
        <!-- title field -->
        <p>{{ Form::label('title', 'Title') }}</p>
        {{ $errors->first('title', '<p class="error">:message</p>') }}
        <p>{{ Form::text('title', Input::old('title')) }}</p>
        <!-- excerpt field -->
        <p>{{ Form::label('excerpt', 'Excerpt') }}</p>
        {{ $errors->first('excerpt', '<p class="error">:message</p>') }}
        <p>{{ Form::textarea('excerpt', Input::old('excerpt')) }}</p>
        <!-- body field -->
        <p>{{ Form::label('body', 'Body') }}</p>
        {{ $errors->first('body', '<p class="error">:message</p>') }}
        <p>{{ Form::textarea('body', Input::old('body')) }}</p>
        @if ($p->canI('publishPost'))
        <p>
          {{ Form::label('published', 'Published' )}}
          {{ $errors->first('published') }}
          {{ Form::checkbox('published', Input::old('published', true)) }}
        </p>
        @endif
        <p>
            <span>Categories</span>
            <ul class="categorylist">
            @foreach ($categories as $category)
                <li>
                    <label>{{ Form::label('category', $category->title) }}</label>
                    {{ Form::checkbox('category[]', $category->id) }}
                </li>
            @endforeach
            </ul>
        </p>
        <p>
            <div id="jqPostImageList" data-type="newpost"></div>
            <p><input type="button" class="jqGetImages" data-id="" value="Add image"/></p>
        </p>
        <!-- submit button -->
        <p>{{ Form::submit('Create') }}</p>
    {{ Form::close() }}
@endsection
