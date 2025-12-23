<div class="like-component-wrapper">
    <button
        wire:click="toggleLike"
        type="button"
        class="like-button {{ $liked ? 'liked' : '' }}"
        title="{{ $liked ? 'Unlike' : 'Like' }}">
        

        <svg class="heart-icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <defs>
                <linearGradient id="heartGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:#ff6b6b;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#ee5a6f;stop-opacity:1" />
                </linearGradient>
            </defs>
            <path class="heart-path" 
                  d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" 
                  stroke-width="2" 
                  stroke-linecap="round" 
                  stroke-linejoin="round"/>
        </svg>

        <div class="particles">
            <span class="particle particle-1"></span>
            <span class="particle particle-2"></span>
            <span class="particle particle-3"></span>
            <span class="particle particle-4"></span>
            <span class="particle particle-5"></span>
            <span class="particle particle-6"></span>
        </div>

        <div class="ripple-effect"></div>
    </button>

    <span class="like-count {{ $liked ? 'liked' : '' }}" wire:key="count-{{ $likesCount }}">
        {{ $likesCount }}
    </span>
</div>

