@extends('layouts.App')

@section('content')

<div class="card">
<div class="card-body">

<h3>Edit Note</h3>

<form method="POST" action="/notes/{{ $note->id }}">
@csrf
@method('PUT')

<input type="text"
name="title"
value="{{ $note->title }}"
class="form-control mb-3">

<textarea
name="content"
class="form-control mb-3">{{ $note->content }}</textarea>

<button class="btn btn-warning">
Update Note
</button>

</form>

</div>
</div>

@endsection