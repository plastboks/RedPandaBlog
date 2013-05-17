@layout('account/index')
@section('content')
<h1>Holla!</h1>
<p> Welcome back {{ Auth::user()->username }}</p>
@endsection
