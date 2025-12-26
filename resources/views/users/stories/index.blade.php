@extends('layouts.app')

@section('title', 'Story')

@section('content')

<div class="story-viewer-modern">
    
    @if ($story->user->isFollowing(Auth::user()) || $story->user->id === Auth::id())
        
        {{-- Story Container --}}
        <div class="story-container-modern">
            
            {{-- Progress Bar --}}
            <div class="story-progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>

            {{-- Header --}}
            <div class="story-header-modern">
                <div class="story-user-info">
                    <a href="{{ route('profile.show', $story->user->id) }}" class="story-avatar-link">
                        @if ($story->user->avatar)
                            <img src="{{ $story->user->avatar }}" alt="{{ $story->user->name }}" class="story-avatar-modern">
                        @else
                            <div class="story-avatar-default-modern">
                                {{ strtoupper(substr($story->user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="story-avatar-ring-modern"></div>
                    </a>
                    
                    <div class="story-user-details">
                        <a href="{{ route('profile.show', $story->user->id) }}" class="story-username-modern">
                            {{ $story->user->name }}
                        </a>
                        <span class="story-time-modern">{{ $story->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                

                <div class="story-actions-modern">
                    @if (Auth::user()->id === $story->user->id)
                        <button class="btn-story-action" data-bs-toggle="modal" data-bs-target="#delete-story-{{ $story->id }}" title="Delete Story">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <polyline points="3 6 5 6 21 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    @endif
                    
                    <button class="btn-story-action" onclick="window.location.href='{{ route('index') }}'" title="Close">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <line x1="18" y1="6" x2="6" y2="18" stroke-width="2" stroke-linecap="round"/>
                            <line x1="6" y1="6" x2="18" y2="18" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Story Image --}}
            <div class="story-image-wrapper">
                <img src="{{ $story->story_image }}" class="story-image-modern" alt="Story">
                
                {{-- Navigation Zones --}}
                <div class="story-nav-left" onclick="history.back()"></div>
                <div class="story-nav-right" onclick="goToNextStory()"></div>
            </div>

            {{-- Navigation Hints --}}
            <div class="story-hints">
                <div class="hint-left">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <polyline points="15 18 9 12 15 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Previous
                </div>
                <div class="hint-right">
                    Next
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <polyline points="9 18 15 12 9 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

        </div>

    @endif

</div>

@include('users.stories.modals.delete')

<script>
    const nextStoryUrl = @json($nextStory ? route('stories.show', $nextStory->id) : route('index'));
    const storyDuration = 10000; // 10 seconds

    @if (!($story->user->isFollowing(Auth::user()) || $story->user->id === Auth::id()))
        window.location.href = nextStoryUrl;
    @endif

    // Progress bar animation
    let startTime = Date.now();
    const progressBar = document.getElementById('progressFill');

    function updateProgress() {
        const elapsed = Date.now() - startTime;
        const progress = Math.min((elapsed / storyDuration) * 100, 100);
        progressBar.style.width = progress + '%';

        if (progress < 100) {
            requestAnimationFrame(updateProgress);
        } else {
            goToNextStory();
        }
    }

    updateProgress();

    // Navigation function
    function goToNextStory() {
        window.location.href = nextStoryUrl;
    }

    // Pause on hover
    let isPaused = false;
    let pauseTime = 0;

    document.querySelector('.story-container-modern').addEventListener('mouseenter', () => {
        isPaused = true;
        pauseTime = Date.now();
    });

    document.querySelector('.story-container-modern').addEventListener('mouseleave', () => {
        if (isPaused) {
            const pausedDuration = Date.now() - pauseTime;
            startTime += pausedDuration;
            isPaused = false;
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') {
            goToNextStory();
        } else if (e.key === 'ArrowLeft') {
            history.back();
        } else if (e.key === 'Escape') {
            window.location.href = '{{ route('index') }}';
        }
    });
</script>

<style>
    /* Story Viewer */
    .story-viewer-modern {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Story Container */
    .story-container-modern {
        position: relative;
        max-width: 500px;
        width: 100%;
        height: 90vh;
        background: #1a1a1a;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.8);
        animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Progress Bar */
    .story-progress-bar {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: rgba(255, 255, 255, 0.3);
        z-index: 10;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        width: 0%;
        transition: width 0.1s linear;
    }

    /* Header */
    .story-header-modern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        padding: 16px;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.6) 0%, transparent 100%);
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 5;
    }

    .story-user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .story-avatar-link {
        position: relative;
        display: block;
    }

    .story-avatar-modern {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #000;
        position: relative;
        z-index: 1;
    }

    .story-avatar-default-modern {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        border: 2px solid #000;
        position: relative;
        z-index: 1;
    }

    .story-avatar-ring-modern {
        position: absolute;
        top: -3px;
        left: -3px;
        right: -3px;
        bottom: -3px;
        border-radius: 50%;
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        z-index: 0;
    }

    .story-user-details {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .story-username-modern {
        color: #fff;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    .story-time-modern {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.75rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    /* Actions */
    .story-actions-modern {
        display: flex;
        gap: 8px;
    }

    .btn-story-action {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-story-action:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    .btn-story-action svg {
        stroke: #fff;
        stroke-width: 2;
    }

    /* Story Image */
    .story-image-wrapper {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #000;
    }

    .story-image-modern {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    /* Navigation Zones */
    .story-nav-left,
    .story-nav-right {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 30%;
        cursor: pointer;
        z-index: 3;
    }

    .story-nav-left {
        left: 0;
    }

    .story-nav-right {
        right: 0;
    }

    /* Navigation Hints */
    .story-hints {
        position: absolute;
        bottom: 24px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: space-between;
        padding: 0 24px;
        pointer-events: none;
        z-index: 4;
    }

    .hint-left,
    .hint-right {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.8rem;
        font-weight: 600;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .story-container-modern:hover .hint-left,
    .story-container-modern:hover .hint-right {
        opacity: 1;
    }

    .hint-left svg,
    .hint-right svg {
        stroke: rgba(255, 255, 255, 0.7);
        stroke-width: 2;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .story-container-modern {
            max-width: 100%;
            height: 100vh;
            border-radius: 0;
        }

        .hint-left,
        .hint-right {
            font-size: 0.75rem;
            padding: 6px 12px;
        }
    }

    /* Loading Animation */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }
</style>

@endsection