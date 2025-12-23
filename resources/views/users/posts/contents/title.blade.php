<div class="post-header-section">
    <div class="header-content">
        
        <div class="user-info-wrapper">
            <a href="{{ route('profile.show', $post->user->id) }}" class="user-avatar-link">
                @if ($post->user->avatar)
                    <div class="avatar-container">
                        <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" class="user-avatar-img">
                        <div class="avatar-ring"></div>
                    </div>
                @else
                    <div class="avatar-container avatar-default">
                        <span class="avatar-initial">{{ strtoupper(substr($post->user->name, 0, 1)) }}</span>
                        <div class="avatar-ring"></div>
                    </div>
                @endif
            </a>
            
            <div class="user-details">
                <a href="{{ route('profile.show', $post->user->id) }}" class="user-name">
                    {{ $post->user->name }}
                    @if ($post->user->id === Auth::user()->id)
                        <span class="badge-you">You</span>
                    @endif
                </a>
                <div class="post-timestamp">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                        <polyline points="12 6 12 12 16 14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <div class="post-actions">
            <div class="dropdown">
                <button class="action-menu-btn" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="1" stroke-width="2"/>
                        <circle cx="12" cy="5" r="1" stroke-width="2"/>
                        <circle cx="12" cy="19" r="1" stroke-width="2"/>
                    </svg>
                </button>

                <ul class="dropdown-menu dropdown-menu-end custom-dropdown">
                    @if (Auth::user()->id === $post->user->id)
                        <li>
                            <a href="{{ route('post.edit', $post->id) }}" class="dropdown-item-custom">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>Edit Post</span>
                            </a>
                        </li>
                        <li><div class="dropdown-divider-custom"></div></li>
                        <li>
                            <button class="dropdown-item-custom item-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{ $post->id }}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <polyline points="3 6 5 6 21 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <line x1="10" y1="11" x2="10" y2="17" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="14" y1="11" x2="14" y2="17" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                <span>Delete Post</span>
                            </button>
                        </li>
                        @include('users.posts.contents.modals.delete')
                    @else
                        <li>
                            <form action="{{ route('follow.destroy', $post->user->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item-custom item-danger">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="8.5" cy="7" r="4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <line x1="23" y1="11" x2="17" y2="11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Unfollow</span>
                                </button>
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .post-header-section {
        background: #0a0a0a;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 16px 20px;
        transition: background 0.3s ease;
    }

    .header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .user-info-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }

    .user-avatar-link {
        position: relative;
        display: block;
        text-decoration: none;
    }

    .avatar-container {
        position: relative;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .avatar-container::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        z-index: 0;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .user-avatar-link:hover .avatar-container::before {
        opacity: 1;
    }

    .user-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: relative;
        z-index: 1;
        border: 2px solid #0a0a0a;
        border-radius: 50%;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .user-avatar-link:hover .user-avatar-img {
        transform: scale(1.05);
    }

    .avatar-default {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-initial {
        color: white;
        font-size: 1.2rem;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    .avatar-ring {
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        border: 2px solid #667eea;
        border-radius: 50%;
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
    }

    .user-avatar-link:hover .avatar-ring {
        opacity: 0.6;
        transform: scale(1.1);
    }

    .user-details {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .user-name {
        color: #fff;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: color 0.2s ease;
    }

    .user-name:hover {
        color: #667eea;
    }

    .badge-you {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
        border: 1px solid rgba(102, 126, 234, 0.3);
        color: #667eea;
        font-size: 0.65rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .post-timestamp {
        display: flex;
        align-items: center;
        gap: 5px;
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.8rem;
        font-weight: 500;
    }

    .post-timestamp svg {
        stroke: rgba(255, 255, 255, 0.4);
        stroke-width: 2;
        flex-shrink: 0;
    }

    .post-timestamp span {
        text-transform: lowercase;
    }


    .action-menu-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 0;
    }

    .action-menu-btn svg {
        stroke: rgba(255, 255, 255, 0.6);
        stroke-width: 2;
        transition: stroke 0.3s ease;
    }

    .action-menu-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg);
    }

    .action-menu-btn:hover svg {
        stroke: rgba(255, 255, 255, 0.9);
    }

    .action-menu-btn:active {
        transform: rotate(90deg) scale(0.95);
    }


    .custom-dropdown {
        background: rgba(20, 20, 20, 0.98);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 6px;
        margin-top: 8px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
        min-width: 200px;
    }

    .dropdown-item-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        border-radius: 8px;
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
        background: transparent;
        width: 100%;
        text-decoration: none;
    }

    .dropdown-item-custom svg {
        stroke: rgba(255, 255, 255, 0.6);
        stroke-width: 2;
        flex-shrink: 0;
        transition: stroke 0.2s ease;
    }

    .dropdown-item-custom:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
    }

    .dropdown-item-custom:hover svg {
        stroke: #fff;
    }


    .item-danger {
        color: rgba(239, 68, 68, 0.9);
    }

    .item-danger svg {
        stroke: rgba(239, 68, 68, 0.8);
    }

    .item-danger:hover {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .item-danger:hover svg {
        stroke: #ef4444;
    }

    .dropdown-divider-custom {
        height: 1px;
        background: rgba(255, 255, 255, 0.1);
        margin: 6px 0;
    }

    @media (max-width: 576px) {
        .post-header-section {
            padding: 14px 16px;
        }

        .avatar-container {
            width: 42px;
            height: 42px;
        }

        .avatar-initial {
            font-size: 1rem;
        }

        .user-name {
            font-size: 0.9rem;
        }

        .post-timestamp {
            font-size: 0.75rem;
        }

        .badge-you {
            font-size: 0.6rem;
            padding: 2px 6px;
        }
    }


    .action-menu-btn:focus,
    .dropdown-item-custom:focus {
        outline: 2px solid rgba(102, 126, 234, 0.5);
        outline-offset: 2px;
    }

    .action-menu-btn:focus:not(:focus-visible),
    .dropdown-item-custom:focus:not(:focus-visible) {
        outline: none;
    }
</style>