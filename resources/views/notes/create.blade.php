@extends('layouts.App')

@section('content')

<div class="card">
<div class="card-body">

<h3>Add Note</h3>

<form method="POST" action="/notes">
@csrf

<input type="text"
name="title"
class="form-control mb-3"
placeholder="Title">

<textarea
name="content"
class="form-control mb-3"
placeholder="Content"></textarea>

<button class="btn btn-success">
Save Note
</button>

</form>

</div>
</div>

@endsection