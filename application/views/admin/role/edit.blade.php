@layout('admin/index')
@section('title')
Edit Role
@endsection
@section('content')
    <h1>Edit role {{ $role->title }}</h1>
    {{ Form::open('admin/role/update/'.$role->id) }}
        {{ Form::token() }}

        <!-- title field -->
        <p>{{ Form::label('name', 'Name') }}</p>
        {{ $errors->first('name', '<p class="error">:message</p>') }}
        <p>{{ Form::text('name', $role->name) }}</p>

        <p>
            <span>Capabilities</span>
            <ul class="capabilitieslist">
            @foreach ($caps as $cap)
                <li>
                    <label>{{ Form::label('cap', $cap->name) }}</label>
                    {{ Form::checkbox('caps[]',$cap->id,$role->capabilities()->where('name', '=', $cap->name)->first())}}
                </li>
            @endforeach
            </ul>
        </p>
        <!-- submit button -->
        <p>{{ Form::submit('Update') }}</p>
    {{ Form::close() }}
@endsection
