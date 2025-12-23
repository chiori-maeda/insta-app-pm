{{-- Edit Category Modal --}}
<div class="modal fade" id="edit-category-{{ $category->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-modern border-warning-subtle">
            <div class="modal-header-custom">
                <div class="icon-box warning">
                    <i class="fa-regular fa-pen-to-square"></i>
                </div>
                <div>
                    <h3 class="modal-title-modern">Edit Category</h3>
                    <p class="modal-subtitle-modern">Update the name for this category</p>
                </div>
            </div>

            <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="modal-body py-4">
                    <div class="input-group-modern">
                        <input type="text" name="new_name" class="form-control-modern" 
                               value="{{ $category->name }}" placeholder="Category name" required>
                    </div>
                </div>
                <div class="modal-footer-modern">
                    <button type="button" class="btn-modal-close" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modal-update">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Category Modal --}}
<div class="modal fade" id="delete-category-{{ $category->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-modern border-danger-subtle">
            <div class="modal-header-custom">
                <div class="icon-box danger">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <div>
                    <h3 class="modal-title-modern">Delete Category</h3>
                    <p class="modal-subtitle-modern">Confirm permanent removal</p>
                </div>
            </div>

            <div class="modal-body py-4 text-center">
                <p class="text-white-50">Are you sure you want to delete <span class="text-danger fw-bold">{{ $category->name }}</span>?</p>
                <div class="alert-warning-modern mt-3">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>
                    Posts under this category will move to <strong>Uncategorized</strong>.
                </div>
            </div>

            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-footer-modern">
                    <button type="button" class="btn-modal-close" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modal-delete">Delete Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>

.modal-content-modern {
    background: rgba(15, 15, 15, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}


.modal-header-custom {
    padding: 24px 24px 10px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
}

.icon-box {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.icon-box.warning { background: rgba(251, 191, 36, 0.1); color: #fbbf24; }
.icon-box.danger { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

.modal-title-modern { color: #fff; font-weight: 700; margin: 0; font-size: 1.25rem; }
.modal-subtitle-modern { color: rgba(255, 255, 255, 0.4); margin: 0; font-size: 0.85rem; }


.alert-warning-modern {
    background: rgba(251, 191, 36, 0.05);
    border: 1px solid rgba(251, 191, 36, 0.15);
    color: #fbbf24;
    padding: 12px;
    border-radius: 12px;
    font-size: 0.85rem;
}


.modal-footer-modern {
    padding: 20px 24px 24px 24px;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn-modal-close {
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
    padding: 10px 20px;
    border-radius: 12px;
    font-weight: 600;
    transition: 0.2s;
}

.btn-modal-close:hover { background: rgba(255, 255, 255, 0.05); }

.btn-modal-update {
    background: #fbbf24;
    color: #000;
    border: none;
    padding: 10px 24px;
    border-radius: 12px;
    font-weight: 700;
    transition: 0.3s;
}

.btn-modal-update:hover { background: #fcd34d; transform: translateY(-2px); }

.btn-modal-delete {
    background: #ef4444;
    color: #fff;
    border: none;
    padding: 10px 24px;
    border-radius: 12px;
    font-weight: 700;
    transition: 0.3s;
}

.btn-modal-delete:hover { background: #f87171; box-shadow: 0 0 15px rgba(239, 68, 68, 0.4); }
</style>