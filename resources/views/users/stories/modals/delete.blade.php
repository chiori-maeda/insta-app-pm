<style>

.cute-modal {
    border-radius: 40px !important;
    border: none !important;
    box-shadow: 0 15px 35px rgba(240, 143, 179, 0.2) !important;
    padding: 10px;
}


.text-pink-strong {
    color: #E46A9A;
    font-weight: 800;
}

.story-preview-container {
    padding: 10px;
    background: #fff;
    border: 2px solid #FBEFEF;
    border-radius: 20px;
    display: inline-block;
}
.story-preview-img {
    width: 150px;
    height: 200px;
    object-fit: cover;
    border-radius: 15px;
}


.btn-cancel-cute {
    background-color: #DFF4F8 !important;
    color: #4B8FA1 !important;
    border-radius: 50px !important;
    padding: 8px 25px !important;
    font-weight: bold;
    border: none !important;
    transition: all 0.2s;
}
.btn-cancel-cute:hover {
    background-color: #C9ECF3 !important;
    transform: scale(1.05);
}


.btn-delete-strong {
    background-color: #F08FB3 !important;
    color: #fff !important;
    border-radius: 50px !important;
    padding: 8px 25px !important;
    font-weight: bold;
    border: none !important;
    box-shadow: 0 4px 10px rgba(240, 143, 179, 0.3);
    transition: all 0.2s;
}
.btn-delete-strong:hover {
    background-color: #E46A9A !important;
    transform: scale(1.05);
}
</style>

<div class="modal fade" id="delete-story-{{ $story->id }}">
    <div class="modal-dialog modal-dialog-centered"> 
        <div class="modal-content cute-modal">
            <div class="modal-header border-0 justify-content-center">
                <h3 class="h5 modal-title text-pink-strong">
                    <i class="fa-solid fa-heart-crack me-2"></i>Delete Story
                </h3>
            </div>

            <div class="modal-body text-center">
                <p class="text-secondary mb-3">Do you want to delete?</p>
                <div class="story-preview-container">
                    <img src="{{ $story->story_image }}" alt="story id {{ $story->id }}" class="story-preview-img">
                </div>
            </div>

            <div class="modal-footer border-0 justify-content-center pb-4">
                <form action="{{ route('stories.destroy', $story->id) }}" method="post" class="d-flex gap-3">
                    @csrf
                    @method('DELETE')


                    <button type="button" class="btn btn-cancel-cute" data-bs-dismiss="modal">Cancel</button>

                    <button type="submit" class="btn btn-delete-strong">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>