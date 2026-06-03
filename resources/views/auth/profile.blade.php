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
        <h6 class="fw-bold mb-2">Please correct the entries below:</h6>
        <ul class="mb-0 small ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="mb-5">
        <h1 class="h2 fw-bold text-dark mb-1">My Profile</h1>
        <p class="text-muted small mb-0">Modify identity parameters, credentials, and verification keys for your active session.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
        <div class="card-body">
            
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="d-flex flex-column flex-sm-row align-items-center gap-4 border-bottom pb-4 mb-4">
                          <div class="position-relative">
    @if($user->profile_picture)
        <img src="{{ Storage::url($user->profile_picture) }}" 
             alt="Profile Picture" 
             class="rounded-circle object-fit-cover border border-light shadow-sm" 
             style="width: 110px; height: 110px; min-width: 110px; min-height: 110px;">
    @else
        <div class="rounded-circle border border-light shadow-sm text-white fw-bold d-flex align-items-center justify-content-center" 
             style="width: 110px; height: 110px; min-width: 110px; min-height: 110px; font-size: 2.8rem; background-color: #15325B;">
            {{ substr($user->name, 0, 1) }}
        </div>
    @endif
</div>
                    
                    <div class="w-100 text-center text-sm-start">
                        <h5 class="fw-bold text-dark mb-1">Profile Picture</h5>
                                                
                        <div style="max-width: 320px;" class="mx-auto mx-sm-0">
                            <input type="file" name="profile_picture" class="form-control bg-light border-0 py-2 rounded-3 text-sm shadow-none" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Full Registered Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Official Email Identity</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Contact Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Gender Registry Designation</label>
                        <select name="gender" class="form-select bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                            <option value="">Select Designation</option>
                            <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Mailing Address Locations</label>
                        <textarea name="address" rows="2" class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">New Authentication Secret (Optional)</label>
                        <input type="password" name="password" class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none" placeholder="••••••••">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Confirm New Secret</label>
                        <input type="password" name="password_confirmation" class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none" placeholder="••••••••">
                    </div>
                </div>

                <div class="d-flex justify-content-end pt-3 border-top border-light">
                    <button type="submit" class="btn btn-primary fw-semibold px-4 py-2.5 rounded-3 text-sm border-0 shadow-sm" style="background: linear-gradient(135deg, #15325B 0%, #0c203d 100%);">
                        Update Profile
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1.25rem !important; }
    .bg-light { background-color: #f8fafc !important; }
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
