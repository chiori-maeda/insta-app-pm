<div class="mt-4">
    @if ($post->comments->isNotEmpty())
        <div class="comments-container mb-4">
            <div class="comments-header d-flex align-items-center gap-2 mb-3">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-white-50">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="text-white-50 fw-semibold small">{{ $post->comments->count() }} {{ Str::plural('Comment', $post->comments->count()) }}</span>
            </div>

            <div class="comments-list">
                @foreach ($post->comments->take(3) as $comment)
                    <div class="comment-card mb-3">
                        <div class="d-flex gap-3">
                     
                            <div class="comment-avatar flex-shrink-0">
                                <a href="{{ route('profile.show', $comment->user->id) }}" class="avatar-link">
                                    <div class="avatar-circle">
                                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                    </div>
                                </a>
                            </div>

                          
                            <div class="comment-body flex-grow-1">
                                <div class="comment-bubble">
                                    <a href="{{ route('profile.show', $comment->user->id) }}" class="comment-author">
                                        {{ $comment->user->name }}
                                    </a>
                                    <p class="comment-text mb-0">{{ $comment->body }}</p>
                                </div>

                                <div class="comment-actions d-flex align-items-center gap-3 mt-2">
                                    <span class="comment-time">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </span>

                                    @if (Auth::user()->id === $comment->user->id)
                                        <form action="{{ route('comment.destroy', $comment->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete-comment">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                    <polyline points="3 6 5 6 21 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($post->comments->count() > 3)
                    <button type="button" class="btn-view-all" onclick="window.location.href='{{ route('post.show', $post->id) }}'">
                        <span>View all {{ $post->comments->count() }} comments</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <polyline points="9 18 15 12 9 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    @endif

    <form action="{{ route('comment.store', $post->id) }}" method="post" class="comment-form">
        @csrf
        <div class="new-comment-wrapper">
            <div class="comment-input-container">
                <textarea name="comment_body{{ $post->id }}" 
                          rows="1" 
                          class="comment-textarea" 
                          placeholder="Write a thoughtful comment..."
                          oninput="this.style.height = 'auto'; this.style.height = this.scrollHeight + 'px'">{{ old('comment_body' . $post->id) }}</textarea>
                
                <button type="submit" class="btn-post-comment" title="Post Comment">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="22" y1="2" x2="11" y2="13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>

            @error('comment_body' . $post->id)
                <div class="comment-error">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                        <line x1="12" y1="8" x2="12" y2="12" stroke-width="2" stroke-linecap="round"/>
                        <line x1="12" y1="16" x2="12.01" y2="16" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    {{ $message }}
                </div>
            @enderror
        </div>
    </form>
</div>

<style>
    .comments-header {
        padding-bottom: 0.75rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .comment-card {
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .comment-card::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 48px;
        bottom: -12px;
        width: 2px;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .comment-card:not(:last-child)::before {
        opacity: 1;
    }

    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .avatar-link:hover .avatar-circle {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }

    .comment-bubble {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 18px;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }

    .comment-card:hover .comment-bubble {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    .comment-author {
        color: #fff;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 4px;
        transition: color 0.2s ease;
    }

    .comment-author:hover {
        color: #667eea;
    }

    .comment-text {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.9rem;
        line-height: 1.5;
        word-wrap: break-word;
    }

    .comment-actions {
        padding-left: 4px;
    }

    .comment-time {
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: lowercase;
    }

    .btn-delete-comment {
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s ease;
        opacity: 0;
    }

    .comment-card:hover .btn-delete-comment {
        opacity: 1;
    }

    .btn-delete-comment:hover {
        color: #ef4444;
        transform: translateX(2px);
    }

    .btn-delete-comment svg {
        stroke-width: 2;
    }

    .btn-view-all {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border: 1px solid rgba(102, 126, 234, 0.2);
        color: #667eea;
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        margin-top: 8px;
    }

    .btn-view-all:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
        border-color: rgba(102, 126, 234, 0.4);
        transform: translateX(4px);
    }

    .btn-view-all svg {
        transition: transform 0.3s ease;
    }

    .btn-view-all:hover svg {
        transform: translateX(4px);
    }

    .comment-form {
        margin-top: 1.5rem;
    }

    .new-comment-wrapper {
        background: rgba(255, 255, 255, 0.03);
        border: 2px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 8px;
        transition: all 0.3s ease;
    }

    .new-comment-wrapper:focus-within {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(102, 126, 234, 0.5);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .comment-input-container {
        display: flex;
        align-items: flex-end;
        gap: 8px;
    }

    .comment-textarea {
        flex: 1;
        background: transparent;
        border: none;
        color: #fff;
        font-size: 0.9rem;
        padding: 10px 12px;
        resize: none;
        min-height: 44px;
        max-height: 200px;
        overflow-y: auto;
        font-family: inherit;
        line-height: 1.5;
    }

    .comment-textarea:focus {
        outline: none;
    }

    .comment-textarea::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }

    .comment-textarea::-webkit-scrollbar {
        width: 6px;
    }

    .comment-textarea::-webkit-scrollbar-track {
        background: transparent;
    }

    .comment-textarea::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }

    .btn-post-comment {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-post-comment:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }

    .btn-post-comment:active {
        transform: translateY(0) scale(0.98);
    }

    .btn-post-comment svg {
        stroke: white;
        stroke-width: 2;
    }

    .comment-error {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 8px;
        padding: 8px 12px;
        background: rgba(239, 68, 68, 0.1);
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        animation: slideIn 0.3s ease-out;
    }

    .comment-error svg {
        stroke: #ef4444;
        stroke-width: 2;
        flex-shrink: 0;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 576px) {
        .avatar-circle {
            width: 36px;
            height: 36px;
            font-size: 0.85rem;
        }

        .comment-bubble {
            padding: 10px 14px;
            border-radius: 16px;
        }

        .comment-author,
        .comment-text {
            font-size: 0.85rem;
        }
    }
</style>