@extends('layouts.app')

@section('content')
<div class="container py-4 position-relative min-vh-100" style="padding-bottom: 6rem;">
    
    @if(session('toast_success'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        <div id="toast" class="toast show align-items-center text-dark bg-white border-0 shadow rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                    <div class="rounded-2 d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success me-2" style="width: 2rem; height: 2rem;">
                        <strong>✓</strong>
                    </div>
                    <span class="fw-semibold text-secondary">{{ session('toast_success') }}</span>
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
            <h1 class="h2 fw-bold text-dark mb-1">My Notes</h1>
            <p class="text-muted small mb-0">Organize your thoughts and manage your entry vault logs securely.</p>
        </div>
        <button onclick="openAddNoteModal()" class="btn text-white fw-bold px-4 py-2 rounded-3 shadow-sm text-sm" style="background-color: #E67E5A; border-color: #E67E5A;">
            + Create New Note
        </button>
    </div>

    <div class="row g-4">
        @forelse($notes as $note)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-2 backend-card">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title fw-bold text-dark text-truncate pe-3 mb-0" style="max-width: 70%;">{{ $note->title }}</h5>
                            <span class="badge bg-light text-muted fw-bold rounded-2 text-uppercase" style="font-size: 10px; padding: 0.4rem 0.6rem;">{{ $note->created_at->format('M d, Y') }}</span>
                        </div>
                        <p class="card-text text-muted small text-break mb-4" style="white-space: pre-line; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;">{{ $note->content }}</p>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-3 pt-3 border-top border-light" style="font-size: 11px;">
                        <button onclick="openEditNoteModal({{ $note->id }}, '{{ addslashes($note->title) }}', '{{ addslashes($note->content) }}')" class="btn btn-link text-decoration-none text-primary p-0 fw-bold tracking-wider text-uppercase">Edit</button>
                        <button onclick="openDeleteNoteModal({{ $note->id }})" class="btn btn-link text-decoration-none text-danger p-0 fw-bold tracking-wider text-uppercase">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 bg-white shadow-sm rounded-4 p-5 text-center text-muted border-dashed">
                <div class="card-body">
                    Your vault is currently empty. Click "Create New Note" to write your first log.
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>

<div class="modal fade" id="addNoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 p-3">
            <div class="modal-body">
                <h4 class="fw-bold text-dark mb-1">Create New Note</h4>
                <p class="text-uppercase tracking-wider text-muted mb-4" style="font-size: 11px; font-weight: 700;">Save new entry log inside system vault</p>
                
                <form action="{{ route('notes.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px;">Title</label>
                        <input type="text" name="title" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px;">Note Content</label>
                        <textarea name="content" rows="5" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none"></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light text-secondary fw-semibold px-4 py-2 rounded-3 text-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary fw-semibold px-4 py-2 rounded-3 text-sm shadow-sm">Save Entry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editNoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 p-3">
            <div class="modal-body">
                <h4 class="fw-bold text-dark mb-1">Modify Note Log</h4>
                <p class="text-uppercase tracking-wider text-muted mb-4" style="font-size: 11px; font-weight: 700;">Update target vault information parameters</p>
                
                <form id="editNoteForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px;">Title</label>
                        <input type="text" id="edit_note_title" name="title" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px;">Note Content</label>
                        <textarea id="edit_note_content" name="content" rows="5" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none"></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light text-secondary fw-semibold px-4 py-2 rounded-3 text-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary fw-semibold px-4 py-2 rounded-3 text-sm shadow-sm">Update Entry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteNoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4 p-3">
            <div class="modal-body text-center">
                <h4 class="fw-bold text-dark mb-2">Purge Entry?</h4>
                <p class="text-muted small mb-4">Are you sure you want to delete this log? This item cannot be recovered from storage files.</p>
                
                <form id="deleteNoteForm" method="POST" class="d-flex justify-content-center gap-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-light text-secondary fw-semibold px-4 py-2 rounded-3 text-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger fw-semibold px-4 py-2 rounded-3 text-sm shadow-sm">Purge Note</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1.5rem !important; }
    .bg-light { background-color: #f8f9fa !important; }
    .btn-link { font-size: 0.75rem; letter-spacing: 0.05em; }
    .tracking-wider { letter-spacing: 0.05em !important; }
    .backend-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .backend-card:hover { transform: translateY(-2px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.08)!important; }
    .border-dashed { border: 2px dashed #dee2e6 !important; background: transparent !important; }
</style>

<script>
    let addModal, editModal, deleteModal;

    document.addEventListener("DOMContentLoaded", function () {
        addModal = new bootstrap.Modal(document.getElementById('addNoteModal'));
        editModal = new bootstrap.Modal(document.getElementById('editNoteModal'));
        deleteModal = new bootstrap.Modal(document.getElementById('deleteNoteModal'));
    });

    function openAddNoteModal() {
        addModal.show();
    }
    
    function openEditNoteModal(id, title, content) {
        document.getElementById('editNoteForm').action = `/notes/${id}`;
        document.getElementById('edit_note_title').value = title;
        document.getElementById('edit_note_content').value = content;
        editModal.show();
    }
    
    function openDeleteNoteModal(id) {
        document.getElementById('deleteNoteForm').action = `/notes/${id}`;
        deleteModal.show();
    }
</script>
@endsection