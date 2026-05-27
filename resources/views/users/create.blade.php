@extends('layouts.App')

@section('content')

<div class="card">
<div class="card-body">

<h3>Add User</h3>

<form method="POST" action="/users">
@csrf

<input type="text"
name="name"
class="form-control mb-3"
placeholder="Name">

<input type="email"
name="email"
class="form-control mb-3"
placeholder="Email">

<input type="password"
name="password"
class="form-control mb-3"
placeholder="Password">

<button class="btn btn-primary">
Save User
</button>

</form>

</div>
</div>

@endsection