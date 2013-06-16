@extends('base')
@section('title')
{{ $post->title }}
@endsection
@section('content')
  <div>
    <h1>{{ $post->title }}</h1>
    <ul class="postinfo">
      <li class="created">Created: {{ $post->created_at }}, </li>
      <li class="updated">Updated: {{ $post->updated_at }}, </li>
      <li class="author">Author: {{ $post->author->username }}, </li>
      @if ($post->categories)
        <li class="categories">Categories: 
        @foreach ($post->categories as $category)
            {{ HTML::link('post/category/'.$category->slug, $category->title) }}
        @endforeach
        </li>
      @endif
    </ul>
    <p class="excerpt">{{ $post->excerpt }}</p>
    <p class="body">{{ $post->body }}</p>
    @if (!Auth::guest())
      {{ HTML::link('admin/post/edit/'.$post->id, 'Edit') }}  
    @endif
  </div>
@endsection
