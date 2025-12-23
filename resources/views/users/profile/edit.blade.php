@extends('layouts.app')

@section('title', $user->name)

@section('content')
<div class="ig-edit-wrap">
    <div class="ig-edit-card">

        <div class="ig-edit-head">
            <h5 class="ig-edit-title mb-0">Update Profile</h5>
            <button type="submit" form="editProfileForm" class="ig-save-btn">Save</button>
        </div>

        <div class="ig-edit-body">
            <form id="editProfileForm" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data" class="ig-edit-form">
                @csrf
                @method('PATCH')

                <div class="ig-avatar-section mb-4">
                    <div class="avatar-preview">
                        @if ($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="profile-avatar">
                        @else
                            <i class="fa-solid fa-circle-user profile-avatar-icon"></i>
                        @endif
                    </div>
                    <div class="avatar-upload-info">
                        <label class="ig-drop" for="avatar">
                            <div class="ig-drop-title">Change avatar</div>
                            <div class="ig-drop-sub">Click to upload</div>
                        </label>
                        <input type="file" name="avatar" id="avatar" class="ig-file" accept="image/jpeg,image/png,image/gif,image/jpg">
                        <div class="ig-help mt-2">
                            Allowed: JPG, PNG, GIF (Max: 1MB)
                        </div>
                        @error('avatar')
                            <div class="ig-error mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Name --}}
                <div class="ig-block">
                    <label for="name" class="ig-label">Name</label>
                    <input type="text" name="name" id="name" class="ig-input" value="{{ old('name', $user->name) }}">
                    @error('name')
                        <div class="ig-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="ig-block">
                    <label for="email" class="ig-label">E-Mail Address</label>
                    <input type="text" name="email" id="email" class="ig-input" value="{{ old('email', $user->email) }}">
                    @error('email')
                        <div class="ig-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Introduction --}}
                <div class="ig-block">
                    <label for="introduction" class="ig-label">Introduction</label>
                    <textarea name="introduction" id="introduction" rows="4" class="ig-textarea" placeholder="Describe yourself">{{ old('introduction', $user->introduction) }}</textarea>
                    @error('introduction')
                        <div class="ig-error">{{ $message }}</div>
                    @enderror
                </div>
            </form>
        </div>

        <div class="ig-edit-foot">
            <button type="submit" form="editProfileForm" class="ig-save-btn-large w-100">Save Changes</button>
        </div>

    </div>
</div>

<style>

body {
    background: #0b1118 !important;
    color: #e6edf3;
}

.ig-edit-wrap {
    padding: 40px 0;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 80vh;
}

.ig-edit-card {
    width: min(520px, 92vw);
    background: #0f1720;
    border: 1px solid #22303c;
    border-radius: 16px;
    box-shadow: 0 20px 70px rgba(0, 0, 0, .55);
}

.ig-edit-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #22303c;
}

.ig-edit-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
}

.ig-edit-body {
    padding: 24px 20px;
}

.ig-avatar-section {
    display: flex;
    align-items: center;
    gap: 20px;
}

.avatar-preview {
    flex-shrink: 0;
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #22303c;
}

.profile-avatar-icon {
    font-size: 80px;
    color: #314454;
}

.avatar-upload-info {
    flex-grow: 1;
}

.ig-drop {
    display: block;
    border: 1px dashed #314454;
    border-radius: 12px;
    background: #0b141c;
    padding: 12px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.ig-drop:hover {
    border-color: #1d9bf0;
    background: rgba(29, 155, 240, 0.05);
}

.ig-drop-title {
    font-weight: 700;
    font-size: 14px;
    color: #1d9bf0;
}

.ig-drop-sub {
    color: #9aa7b4;
    font-size: 12px;
    margin-top: 2px;
}

.ig-edit-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.ig-block {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.ig-label {
    font-weight: 700;
    font-size: 13px;
    color: #9aa7b4;
    margin-left: 4px;
}

.ig-input, .ig-textarea {
    width: 100%;
    border: 1px solid #22303c;
    background: #0b141c;
    color: #e6edf3;
    border-radius: 10px;
    padding: 12px;
    outline: none;
    transition: border 0.2s, box-shadow 0.2s;
}

.ig-input:focus, .ig-textarea:focus {
    border-color: #1d9bf0;
    box-shadow: 0 0 0 3px rgba(29, 155, 240, 0.15);
}


.ig-save-btn {
    background: #1d9bf0;
    color: #fff;
    border: none;
    border-radius: 20px;
    padding: 6px 16px;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
}

.ig-save-btn-large {
    background: #1d9bf0;
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 14px;
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    transition: opacity 0.2s;
}

.ig-save-btn:hover, .ig-save-btn-large:hover {
    opacity: 0.9;
}

.ig-edit-foot {
    padding: 0 20px 24px;
}

.ig-help {
    color: #71767b;
    font-size: 11px;
    line-height: 1.4;
}

.ig-error {
    color: #f4212e;
    font-size: 12px;
    font-weight: 500;
}

.ig-file { display: none; }
</style>
@endsection