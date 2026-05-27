@extends('layouts.app')

@section('content')
    <div style="background: white; padding: 20px; border-radius: 10px;">
        <h1 style="color: black;">Notes Page Loaded!</h1>
        <p>Total Notes: {{ count($notes) }}</p>
    </div>
@endsection