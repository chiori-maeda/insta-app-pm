@extends('layouts.app')

@section('title', 'Add Story')

@section('content')

<div class="story-create-modern">
    <div class="create-container">
        
        {{-- Header --}}
        <div class="create-header">
            <div class="header-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="12" y1="8" x2="12" y2="16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="8" y1="12" x2="16" y2="12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h1 class="create-title">Create Your Story</h1>
            <p class="create-subtitle">Share a moment with your followers</p>
        </div>

        {{-- Form --}}
        <form action="{{ route('stories.store') }}" method="POST" enctype="multipart/form-data" class="create-form">
            @csrf
            
            {{-- File Upload Area --}}
            <div class="upload-section">
                <label for="story_image" class="upload-label">
                    <div class="upload-area" id="uploadArea">
                        <div class="upload-icon">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke-width="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5" fill="currentColor"/>
                                <polyline points="21 15 16 10 5 21" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3 class="upload-title">Choose a photo or video</h3>
                        <p class="upload-text">or drag and drop it here</p>
                        <div class="upload-formats">
                            <span class="format-badge">JPG</span>
                            <span class="format-badge">PNG</span>
                            <span class="format-badge">GIF</span>
                            <span class="format-badge">MP4</span>
                        </div>
                        <p class="upload-limit">Maximum file size: 5MB</p>
                    </div>
                    
                    {{-- Preview Area --}}
                    <div class="preview-area" id="previewArea" style="display: none;">
                        <img id="previewImage" src="" alt="Preview" class="preview-image">
                        <div class="preview-overlay">
                            <button type="button" class="btn-change-image" onclick="document.getElementById('story_image').click()">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Change Photo
                            </button>
                        </div>
                    </div>

                    <input 
                        type="file" 
                        id="story_image" 
                        name="story_image" 
                        accept="image/*,video/*"
                        required 
                        class="file-input-hidden"
                        onchange="handleFileSelect(event)">
                </label>

                @error('story_image')
                    <div class="error-message-create">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke-width="2"/>
                            <line x1="12" y1="8" x2="12" y2="12" stroke-width="2" stroke-linecap="round"/>
                            <line x1="12" y1="16" x2="12.01" y2="16" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="action-buttons">
                <a href="{{ url()->previous() }}" class="btn-cancel-create">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="18" y1="6" x2="6" y2="18" stroke-width="2" stroke-linecap="round"/>
                        <line x1="6" y1="6" x2="18" y2="18" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn-post-story" id="submitBtn" disabled>
                    <span>Post Story</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="22" y1="2" x2="11" y2="13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>

        </form>

    </div>
</div>

<script>
    function handleFileSelect(event) {
        const file = event.target.files[0];
        const uploadArea = document.getElementById('uploadArea');
        const previewArea = document.getElementById('previewArea');
        const previewImage = document.getElementById('previewImage');
        const submitBtn = document.getElementById('submitBtn');

        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                uploadArea.style.display = 'none';
                previewArea.style.display = 'block';
                submitBtn.disabled = false;
            };
            
            reader.readAsDataURL(file);
        }
    }

    // Drag and drop functionality
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('story_image');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.style.borderColor = '#667eea';
            uploadArea.style.background = 'rgba(102, 126, 234, 0.1)';
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.style.borderColor = 'rgba(255, 255, 255, 0.2)';
            uploadArea.style.background = 'rgba(255, 255, 255, 0.05)';
        }, false);
    });

    uploadArea.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length) {
            fileInput.files = files;
            handleFileSelect({ target: fileInput });
        }
    }, false);
</script>

<style>
    /* Main Container */
    .story-create-modern {
        min-height: 100vh;
        background: linear-gradient(135deg, #0a0a0a 0%, #1a0a1a 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        position: relative;
        overflow: hidden;
    }

    .story-create-modern::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
        animation: rotate 30s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .create-container {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 600px;
        background: rgba(15, 15, 15, 0.8);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        animation: fadeInUp 0.6s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Header */
    .create-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .header-icon {
        display: inline-flex;
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
        }
    }

    .header-icon svg {
        stroke: white;
        stroke-width: 2;
    }

    .create-title {
        color: #fff;
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .create-subtitle {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.95rem;
        margin: 0;
    }

    /* Upload Section */
    .upload-section {
        margin-bottom: 32px;
    }

    .upload-label {
        display: block;
        cursor: pointer;
    }

    .upload-area {
        border: 2px dashed rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        padding: 60px 30px;
        text-align: center;
        background: rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
    }

    .upload-area:hover {
        border-color: rgba(102, 126, 234, 0.5);
        background: rgba(102, 126, 234, 0.1);
    }

    .upload-icon {
        margin-bottom: 20px;
    }

    .upload-icon svg {
        stroke: rgba(255, 255, 255, 0.4);
        stroke-width: 2;
        transition: stroke 0.3s ease;
    }

    .upload-area:hover .upload-icon svg {
        stroke: #667eea;
    }

    .upload-title {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0 0 8px 0;
    }

    .upload-text {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.9rem;
        margin: 0 0 20px 0;
    }

    .upload-formats {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-bottom: 16px;
    }

    .format-badge {
        background: rgba(102, 126, 234, 0.2);
        border: 1px solid rgba(102, 126, 234, 0.3);
        color: #667eea;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .upload-limit {
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.8rem;
        margin: 0;
    }

    .file-input-hidden {
        display: none;
    }

    /* Preview Area */
    .preview-area {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        max-height: 500px;
    }

    .preview-image {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 16px;
    }

    .preview-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .preview-area:hover .preview-overlay {
        opacity: 1;
    }

    .btn-change-image {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 12px;
        color: #333;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-change-image:hover {
        background: #fff;
        transform: translateY(-2px);
    }

    .btn-change-image svg {
        stroke: #333;
        stroke-width: 2;
    }

    /* Error Message */
    .error-message-create {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 12px;
        padding: 10px 14px;
        background: rgba(239, 68, 68, 0.1);
        border-radius: 10px;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .error-message-create svg {
        stroke: #ef4444;
        stroke-width: 2;
        flex-shrink: 0;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 12px;
    }

    .btn-cancel-create,
    .btn-post-story {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-cancel-create {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: rgba(255, 255, 255, 0.8);
    }

    .btn-cancel-create:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
        color: #fff;
    }

    .btn-cancel-create svg {
        stroke: currentColor;
        stroke-width: 2;
    }

    .btn-post-story {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: #fff;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-post-story::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s ease, height 0.6s ease;
    }

    .btn-post-story:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-post-story:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }

    .btn-post-story:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .btn-post-story:disabled:hover {
        transform: none;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-post-story span,
    .btn-post-story svg {
        position: relative;
        z-index: 1;
    }

    .btn-post-story svg {
        stroke: white;
        stroke-width: 2;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .story-create-modern {
            padding: 20px;
        }

        .create-container {
            padding: 30px 24px;
        }

        .create-title {
            font-size: 1.5rem;
        }

        .upload-area {
            padding: 40px 20px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-cancel-create,
        .btn-post-story {
            width: 100%;
        }
    }
</style>

@endsection