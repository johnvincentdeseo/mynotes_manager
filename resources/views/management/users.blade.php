@extends('layouts.app')

@section('content')
<div class="container py-4 position-relative min-vh-100" style="padding-bottom: 6rem;">
    
    @if(session('toast_success') || session('toast_error'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        <div id="toast" class="toast show align-items-center text-dark bg-white border-0 shadow rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                    <div class="rounded-2 d-flex align-items-center justify-content-center me-2 {{ session('toast_success') ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }}" style="width: 2rem; height: 2rem;">
                        <strong>{{ session('toast_success') ? '✓' : '✕' }}</strong>
                    </div>
                    <span class="fw-semibold text-secondary">{{ session('toast_success') ?? session('toast_error') }}</span>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const toastEl = document.getElementById('toast');
            if(toastEl) {
                toastEl.classList.remove('show');
                setTimeout(() => toastEl.remove(), 300);
            }
        }, 4000);
    </script>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold text-dark mb-1">User Management</h1>
            <p class="text-muted small mb-0">Manage all registered platform accounts.</p>
        </div>
        <button onclick="openAddModal()" class="btn text-white fw-bold px-4 py-2 rounded-3 shadow-sm text-sm" style="background-color: #E67E5A; border-color: #E67E5A;">
            + Add New User
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-start">
                <thead class="bg-light table-light border-bottom border-light">
                    <tr class="text-uppercase tracking-wider text-muted headers-style" style="font-size: 11px; font-weight: 700;">
                        <th class="p-4 bg-transparent text-secondary">Name</th>
                        <th class="p-4 bg-transparent text-secondary">Email Address</th>
                        <th class="p-4 bg-transparent text-secondary">Created Date</th>
                        <th class="p-4 bg-transparent text-secondary text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($users as $user)
                    <tr class="transition-colors">
                        <td class="p-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary fw-bold text-sm" style="width: 2.25rem; height: 2.25rem; font-size: 0.9rem;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="fw-semibold text-dark">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-muted small text-lowercase">{{ $user->email }}</td>
                        <td class="p-4 text-secondary small">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="p-4 text-end gap-2">
                            <button onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')" class="btn btn-link text-decoration-none text-primary p-0 fw-bold text-uppercase tracking-wider mx-2">Edit</button>
                            <button onclick="openDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}')" class="btn btn-link text-decoration-none text-danger p-0 fw-bold text-uppercase tracking-wider">Delete</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-5 text-center text-muted small">No registered users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 p-3">
            <div class="modal-body">
                <h4 class="fw-bold text-dark mb-1">Add New User</h4>
                <p class="text-uppercase tracking-wider text-muted mb-4" style="font-size: 11px; font-weight: 700;">Create a system login profile</p>
                
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px;">Name</label>
                        <input type="text" name="name" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px;">Email</label>
                        <input type="email" name="email" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px;">Password</label>
                        <input type="password" name="password" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light text-secondary fw-semibold px-4 py-2 rounded-3 text-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary fw-semibold px-4 py-2 rounded-3 text-sm shadow-sm">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 p-3">
            <div class="modal-body">
                <h4 class="fw-bold text-dark mb-1">Edit Account Profile</h4>
                <p class="text-uppercase tracking-wider text-muted mb-4" style="font-size: 11px; font-weight: 700;">Update registered account credentials</p>
                
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px;">Name</label>
                        <input type="text" id="edit_name" name="name" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px;">Email</label>
                        <input type="email" id="edit_email" name="email" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px;">Password <span class="text-muted fw-normal text-none" style="text-transform: none;">(Leave blank to keep current)</span></label>
                        <input type="password" name="password" class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light text-secondary fw-semibold px-4 py-2 rounded-3 text-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary fw-semibold px-4 py-2 rounded-3 text-sm shadow-sm">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4 p-3">
            <div class="modal-body text-center">
                <h4 class="fw-bold text-dark mb-2">Delete User?</h4>
                <p class="text-muted small mb-4">Are you sure you want to permanently delete <span id="deleteTargetName" class="fw-bold text-dark"></span>? This process cannot be undone.</p>
                
                <form id="deleteForm" method="POST" class="d-flex justify-content-center gap-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-light text-secondary fw-semibold px-4 py-2 rounded-3 text-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger fw-semibold px-4 py-2 rounded-3 text-sm shadow-sm">Delete Account</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1.5rem !important; }
    .bg-light { background-color: #f8f9fa !important; }
    .tracking-wider { letter-spacing: 0.05em !important; }
    .btn-link { font-size: 0.75rem; letter-spacing: 0.05em; }
    .table > :not(caption) > * > * { border-bottom-width: 1px; border-color: #f1f5f9; }
</style>

<script>
    let bsAddModal, bsEditModal, bsDeleteModal;

    document.addEventListener("DOMContentLoaded", function () {
        bsAddModal = new bootstrap.Modal(document.getElementById('addModal'));
        bsEditModal = new bootstrap.Modal(document.getElementById('editModal'));
        bsDeleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    });

    function openAddModal() {
        bsAddModal.show();
    }

    function openEditModal(id, name, email) {
        document.getElementById('editForm').action = `/users/${id}`;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        bsEditModal.show();
    }

    function openDeleteModal(id, name) {
        document.getElementById('deleteForm').action = `/users/${id}`;
        document.getElementById('deleteTargetName').innerText = name;
        bsDeleteModal.show();
    }
</script>
@endsection