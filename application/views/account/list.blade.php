<h1>users on this site</h1>
<p>
@foreach ($users as $user)
  {{ $user->username }}
@endforeach
</p>
