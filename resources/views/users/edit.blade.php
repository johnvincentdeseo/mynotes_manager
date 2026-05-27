@extends('layouts.app')

@section('content')

<div class="card">
<div class="card-body">

<h3>Edit User</h3>

<form method="POST" action="/users/{{ $user->id }}">
@csrf
@method('PUT')

<input type="text"
name="name"
value="{{ $user->name }}"
class="form-control mb-3">

<input type="email"
name="email"
value="{{ $user->email }}"
class="form-control mb-3">

<button class="btn btn-warning">
Update User
</button>

</form>

</div>
</div>

@endsection