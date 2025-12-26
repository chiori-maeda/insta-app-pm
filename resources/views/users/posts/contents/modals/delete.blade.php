<div class="modal fade" id="delete-post-{{ $post->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm-custom">
        <div class="modal-content ig-delete-modal">
            <div class="modal-body text-center pt-4 px-4">
                {{-- Warning Icon --}}
                <div class="delete-icon-wrapper mb-3">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ff4d4d" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"/>
                    </svg>
                </div>
                
                <h5 class="fw-bold text-white mb-2">Delete Post?</h5>
                <p class="small text-secondary mb-4">This will permanently remove your post. You cannot undo this action.</p>
                
                {{-- Mini Preview --}}
                <div class="delete-preview mb-4">
                    <img src="{{ $post->image }}" alt="Preview" class="rounded-3">
                    @if($post->description)
                        <p class="delete-preview-text mt-2 text-truncate">{{ $post->description }}</p>
                    @endif
                </div>
            </div>

            <div class="modal-footer flex-column p-0 border-0">
                <form action="{{ route('post.destroy', $post->id) }}" method="post" class="w-100 m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete-confirm w-100 py-3">Delete</button>
                </form>
                <button type="button" class="btn-delete-cancel w-100 py-3" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<style>

.modal-sm-custom {
    max-width: 380px;
}

.ig-delete-modal {
    background: #1a222b !important;
    border: 1px solid #2d3d4d !important;
    border-radius: 16px !important;
    overflow: hidden;
}

/* Delete Icon Animation */
.delete-icon-wrapper {
    background: rgba(255, 77, 77, 0.1);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.delete-preview img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border: 1px solid #2d3d4d;
}

.delete-preview-text {
    font-size: 12px;
    color: #8a99a8;
    max-width: 200px;
    margin: 0 auto;
}

.btn-delete-confirm {
    background: transparent;
    border: none;
    border-top: 1px solid #2d3d4d;
    color: #ff4d4d; /* Red Danger Color */
    font-weight: 800;
    font-size: 14px;
    transition: background 0.2s;
}

.btn-delete-confirm:hover {
    background: rgba(255, 77, 77, 0.05);
}

.btn-delete-cancel {
    background: transparent;
    border: none;
    border-top: 1px solid #2d3d4d;
    color: #e6edf3;
    font-weight: 400;
    font-size: 14px;
    transition: background 0.2s;
}

.btn-delete-cancel:hover {
    background: rgba(255, 255, 255, 0.05);
}

.btn-delete-confirm:focus, .btn-delete-cancel:focus {
    box-shadow: none;
}

</style>