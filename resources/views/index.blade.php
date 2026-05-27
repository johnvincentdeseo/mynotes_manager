@extends('layouts.App')

@section('content')

<a href="/users/create" class="btn btn-primary mb-3">
Add User
</a>

<table class="table table-bordered">

<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Created</th>
    <th>Actions</th>
</tr>

@foreach($users as $user)

<tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->created_at }}</td>

    <td>

        <a href="/users/{{ $user->id }}/edit" class="btn btn-warning btn-sm">
            Edit
        </a>

        <form action="/users/{{ $user->id }}" method="POST">
            @csrf
            @method('DELETE')

            <button class="btn btn-danger btn-sm">
                Delete
            </button>
        </form>

    </td>
</tr>

@endforeach

</table>

@endsection