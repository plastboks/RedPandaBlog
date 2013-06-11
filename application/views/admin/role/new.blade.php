@layout('admin/index')
@section('title')
Add new role
@endsection
@section('content')
    <h1>New role</h1>
    {{ Form::open('admin/role/create') }}
        {{ Form::token() }}
        <!-- title field -->
        <p>{{ Form::label('name', 'Name') }}</p>
        {{ $errors->first('name', '<p class="error">:message</p>') }}
        <p>{{ Form::text('name', Input::old('name')) }}</p>
        <p>
            <span>Capabilities</span>
            <ul class="capabilitieslist">
            @foreach ($caps as $cap)
                <li>
                    <label>{{ Form::label('cap', $cap->name) }}</label>
                    {{ Form::checkbox('caps[]',$cap->id)}}
                </li>
            @endforeach
            </ul>
        </p>
        <!-- submit button -->
        <p>{{ Form::submit('Create') }}</p>
    {{ Form::close() }}
@endsection
