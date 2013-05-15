@layout('base')
@section('title')
Alexander's Webpage!
@endsection
@section('navigation')
    @parent
    <li><a href="#">About</a></li>
@endsection
@section('content')
    <h1>Welcome!</h1>
    <p>Welcome to Alexander's web page!</p>
@endsection
