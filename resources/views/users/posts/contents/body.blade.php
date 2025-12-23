{{-- Image Section --}}
<div class="post-image-wrapper">
    <a href="{{ route('post.show', $post->id) }}" class="image-link">
        <div class="image-overlay"></div>
        <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="post-main-img">
        
        {{-- View Post Indicator --}}
        {{-- <div class="view-indicator">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <circle cx="12" cy="12" r="10" stroke-width="2"/>
                <polyline points="12 16 16 12 12 8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <line x1="8" y1="12" x2="16" y2="12" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div> --}}
    </a>
</div>

{{-- Content Section --}}
<div class="post-content-section">
    
    {{-- Action Bar --}}
    <div class="action-bar">
        {{-- Like Button --}}
        <div class="like-section">
            <div class="like-button-wrapper">
                <livewire:post-like :post="$post" />
            </div>
            <span class="like-label">likes</span>
        </div>

        {{-- Categories --}}
        <div class="category-section">
            @forelse ($post->categoryPost as $category_post)
                <span class="category-tag">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="7" y1="7" x2="7.01" y2="7" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    {{ strtolower($category_post->category->name) }}
                </span>
            @empty
                <span class="category-tag category-tag-empty">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                        <line x1="12" y1="8" x2="12" y2="12" stroke-width="2" stroke-linecap="round"/>
                        <line x1="12" y1="16" x2="12.01" y2="16" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    uncategorized
                </span>
            @endforelse
        </div>
    </div>

    <div class="post-caption-section">
        <div class="author-caption-wrapper">
            <a href="{{ route('profile.show', $post->user->id) }}" class="author-link">
                <div class="author-avatar">
                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                </div>
                <span class="author-name">{{ $post->user->name }}</span>
            </a>
        </div>
        
        @if($post->description)
            <p class="post-description">{{ $post->description }}</p>
        @endif

        {{-- Timestamp --}}
        {{-- <div class="post-metadata">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <circle cx="12" cy="12" r="10" stroke-width="2"/>
                <polyline points="12 6 12 12 16 14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <time>{{ $post->created_at->diffForHumans() }}</time>
        </div> --}}
    </div>

    {{-- Comments Section --}}
    <div class="comments-section">
        @include('users.posts.contents.comments')
    </div>
</div>

<style>
  
    .post-image-wrapper {
        position: relative;
        overflow: hidden;
        background: #000;
        border-radius: 0;
    }

    .image-link {
        display: block;
        position: relative;
    }

    .post-main-img {
        width: 100%;
        max-height: 650px;
        object-fit: cover;
        display: block;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.4) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: 1;
        pointer-events: none;
    }

    .view-indicator {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.8);
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 2;
    }

    .view-indicator svg {
        stroke: white;
        stroke-width: 2;
    }

    .image-link:hover .post-main-img {
        transform: scale(1.05);
    }

    .image-link:hover .image-overlay,
    .image-link:hover .view-indicator {
        opacity: 1;
    }

    .image-link:hover .view-indicator {
        transform: translate(-50%, -50%) scale(1);
    }

    /* Content Section */
    .post-content-section {
        background: #0a0a0a;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-top: none;
        padding: 0;
    }

    /* Action Bar */
    .action-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.02) 0%, transparent 100%);
    }

    .like-section {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .like-button-wrapper {
        display: flex;
        align-items: center;
    }

    .like-label {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.9rem;
        font-weight: 600;
        min-width: 30px;
    }

    .category-section {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .category-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border: 1px solid rgba(102, 126, 234, 0.25);
        color: rgba(102, 126, 234, 0.9);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: default;
    }

    .category-tag svg {
        stroke-width: 2;
        flex-shrink: 0;
    }

    .category-tag:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
        border-color: rgba(102, 126, 234, 0.4);
        color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .category-tag-empty {
        background: rgba(255, 255, 255, 0.03);
        border-color: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.4);
    }

    .category-tag-empty:hover {
        background: rgba(255, 255, 255, 0.06);
        border-color: rgba(255, 255, 255, 0.15);
        color: rgba(255, 255, 255, 0.6);
        box-shadow: none;
    }

    .post-caption-section {
        padding: 20px;
    }

    .author-caption-wrapper {
        margin-bottom: 12px;
    }

    .author-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        transition: all 0.2s ease;
        padding: 4px 8px 4px 4px;
        border-radius: 25px;
        margin-left: -4px;
    }

    .author-link:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    .author-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.8rem;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
    }

    .author-link:hover .author-avatar {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.5);
    }

    .author-name {
        color: #fff;
        font-weight: 600;
        font-size: 0.95rem;
        transition: color 0.2s ease;
    }

    .author-link:hover .author-name {
        color: #667eea;
    }

    .post-description {
        color: rgba(255, 255, 255, 0.85);
        line-height: 1.6;
        font-size: 0.95rem;
        margin: 0 0 12px 0;
        word-wrap: break-word;
    }

    .post-metadata {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.8rem;
        font-weight: 500;
        padding: 4px 10px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.06);
    }

    .post-metadata svg {
        stroke: rgba(255, 255, 255, 0.4);
        stroke-width: 2;
        flex-shrink: 0;
    }

    .post-metadata time {
        text-transform: lowercase;
    }

    .comments-section {
        padding: 0 20px 20px 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        background: rgba(255, 255, 255, 0.01);
    }

    @media (max-width: 768px) {
        .action-bar {
            padding: 14px 16px;
            flex-direction: column;
            gap: 12px;
            align-items: flex-start;
        }

        .like-section {
            width: 100%;
        }

        .category-section {
            width: 100%;
            justify-content: flex-start;
        }

        .post-caption-section {
            padding: 16px;
        }

        .comments-section {
            padding: 0 16px 16px 16px;
        }

        .post-main-img {
            max-height: 500px;
        }
    }

    @media (max-width: 576px) {
        .category-tag {
            font-size: 0.7rem;
            padding: 5px 10px;
        }

        .post-description {
            font-size: 0.9rem;
        }

        .author-name {
            font-size: 0.9rem;
        }
    }
</style>