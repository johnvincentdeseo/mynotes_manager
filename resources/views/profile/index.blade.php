@extends('layouts.app')

@section('content')
<div class="container py-2" style="max-width: 800px; padding-bottom: 6rem !important;">
    
    @if(session('toast_success'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        <div class="toast show align-items-center border-0 shadow rounded-4 bg-white" role="alert">
            <div class="d-flex p-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success me-3" style="width: 2.5rem; height: 2.5rem;">
                    <strong>✓</strong>
                </div>
                <div class="me-auto fw-semibold text-secondary d-flex align-items-center">{{ session('toast_success') }}</div>
                <button type="button" class="btn-close m-auto shadow-none" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger border-0 rounded-4 shadow-sm p-4 mb-4">
        <h6 class="fw-bold mb-2">Please correct the administrative entries below:</h6>
        <ul class="mb-0 small ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="mb-5">
        <h1 class="h2 fw-bold text-dark mb-1">Account Architecture</h1>
        <p class="text-muted small mb-0">Modify identity parameters, credentials, and verification keys for your active session profile.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
        <div class="card-body">
            
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="d-flex flex-column flex-sm-row align-items-center gap-4 border-bottom pb-4 mb-4">
                    <div class="position-relative">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                                 class="rounded-circle object-fit-cover border border-light shadow-sm" 
                                 style="width: 110px; height: 110px; min-width: 110px; min-height: 110px;">
                        @else
                            <div class="rounded-circle border border-light shadow-sm text-white fw-bold d-flex align-items-center justify-content-center brand-initial-avatar" 
                                 style="width: 110px; height: 110px; min-width: 110px; min-height: 110px; font-size: 2.8rem; background-color: #E67E5A;">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="w-100 text-center text-sm-start">
                        <h5 class="fw-bold text-dark mb-1">Session Avatar Identity</h5>
                        <p class="text-muted small mb-3">Accepts standard PNG, JPG, or GIF structures. Max resolution parameter limits up to 2MB storage footprints.</p>
                        
                        <div style="max-width: 320px;" class="mx-auto mx-sm-0">
                            <input type="file" name="profile_picture" class="form-control bg-light border-0 py-2 rounded-3 text-sm shadow-none" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Full Registered Name</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Official Email Workspace Identity</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                    </div>
                </div>

                <div class="d-flex justify-content-end pt-3 border-top border-light">
                    <button type="submit" class="btn btn-primary fw-semibold px-4 py-2.5 rounded-3 text-sm border-0 shadow-sm" style="background: linear-gradient(135deg, #15325B 0%, #0c203d 100%);">
                        Commit Parameter Changes
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1.25rem !important; }
    .bg-light { background-color: #f8fafc !important; }
    .form-control:focus { background-color: #ffffff !important; border: 1px solid #15325B !important; }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(() => {
            const toastEl = document.querySelector('.toast');
            if(toastEl) { toastEl.classList.remove('show'); setTimeout(() => toastEl.remove(), 300); }
        }, 4000);
    });
</script>
@endsection