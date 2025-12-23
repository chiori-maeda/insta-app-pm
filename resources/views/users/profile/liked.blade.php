@extends('layouts.app')

@section('title', $user->name . ' • Liked posts')

@section('content')
    <div class="profile-page-modern">

        @include('users.profile.header')

        {{-- MODERN TABS --}}
        <div class="profile-tabs-modern">
            <div class="tabs-container">
                <a href="{{ route('profile.show', $user->id) }}"
                    class="tab-item-modern {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="3" y="3" width="7" height="7" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <rect x="14" y="3" width="7" height="7" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <rect x="14" y="14" width="7" height="7" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <rect x="3" y="14" width="7" height="7" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span>Posts</span>
                    {{-- <span class="tab-count">{{ $user->posts->count() }}</span> --}}
                </a>

                <a href="{{ route('profile.liked', $user->id) }}"
                    class="tab-item-modern {{ request()->routeIs('profile.liked') ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path
                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Liked</span>
                </a>

                <a href="{{ route('profile.commented', $user->id) }}"
                    class="tab-item-modern {{ request()->routeIs('profile.commented') ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Commented</span>
                </a>

                <div class="active-indicator"></div>
            </div>
        </div>

        {{-- LIKED POSTS GRID --}}
        <div class="profile-posts-modern">
            @if ($likedPosts->isNotEmpty())
                <div class="posts-grid">
                    @foreach ($likedPosts as $post)
                        <div class="grid-item">
                            <a href="{{ route('post.show', $post->id) }}" class="grid-link">
                                <img src="{{ $post->image }}" class="grid-image" alt="Post">

                                {{-- Liked Badge --}}
                                <div class="liked-badge">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#ff6b6b" stroke="#ff6b6b">
                                        <path
                                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
                                            stroke-width="2" />
                                    </svg>
                                </div>

                                <div class="grid-overlay-modern">
                                    <div class="overlay-stats">
                                        <div class="stat-item">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="white"
                                                stroke="white">
                                                <path
                                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
                                                    stroke-width="2" />
                                            </svg>
                                            <span>{{ $post->likes->count() }}</span>
                                        </div>
                                        <div class="stat-item">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="white"
                                                stroke="white">
                                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"
                                                    stroke-width="2" />
                                            </svg>
                                            <span>{{ $post->comments->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state-modern">
                    <div class="empty-icon">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h4>No liked posts yet</h4>
                    <p>Posts that {{ $user->name }} likes will appear here.</p>
                </div>
            @endif
        </div>

    </div>

    <style>
        /* Page Container */
        .profile-page-modern {
            max-width: 935px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Modern Tabs */
        .profile-tabs-modern {
            margin-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .tabs-container {
            display: flex;
            justify-content: center;
            gap: 0;
            position: relative;
        }

        .tab-item-modern {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 16px 24px;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border-top: 2px solid transparent;
            margin-top: -1px;
        }

        .tab-item-modern svg {
            stroke: rgba(255, 255, 255, 0.5);
            stroke-width: 2;
            transition: all 0.3s ease;
        }

        .tab-item-modern:hover {
            color: rgba(255, 255, 255, 0.8);
        }

        .tab-item-modern:hover svg {
            stroke: rgba(255, 255, 255, 0.8);
            transform: scale(1.1);
        }

        .tab-item-modern.active {
            color: #fff;
            border-top-color: #667eea;
        }

        .tab-item-modern.active svg {
            stroke: #667eea;
        }

        .tab-count {
            background: rgba(102, 126, 234, 0.15);
            color: #667eea;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 700;
        }

        /* Posts Grid */
        .profile-posts-modern {
            margin-top: 24px;
        }

        .posts-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 4px;
        }

        .grid-item {
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
            background: #000;
            border-radius: 4px;
        }

        .grid-link {
            display: block;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .grid-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .grid-item:hover .grid-image {
            transform: scale(1.1);
        }

        /* Liked Badge */
        .liked-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3;
            box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4);
            animation: heartBeat 1.5s ease-in-out infinite;
            opacity: 0.9;
            transition: all 0.3s ease;
        }

        .grid-item:hover .liked-badge {
            transform: scale(1.15);
            opacity: 1;
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
        }

        @keyframes heartBeat {

            0%,
            100% {
                transform: scale(1);
            }

            10%,
            30% {
                transform: scale(1.1);
            }

            20%,
            40% {
                transform: scale(1);
            }
        }

        /* Grid Overlay */
        .grid-overlay-modern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.7) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .grid-item:hover .grid-overlay-modern {
            opacity: 1;
        }

        .overlay-stats {
            display: flex;
            gap: 24px;
            z-index: 2;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            animation: fadeInUp 0.4s ease forwards;
            opacity: 0;
        }

        .grid-item:hover .stat-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .grid-item:hover .stat-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stat-item svg {
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Empty State */
        .empty-state-modern {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 80px 20px;
            text-align: center;
        }

        .empty-icon {
            margin-bottom: 24px;
            opacity: 0;
            animation: fadeInScale 0.6s ease forwards;
        }

        .empty-icon svg {
            stroke: rgba(255, 107, 107, 0.3);
            stroke-width: 1.5;
        }

        .empty-state-modern h4 {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 12px;
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
            animation-delay: 0.2s;
        }

        .empty-state-modern p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.95rem;
            margin: 0;
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
            animation-delay: 0.4s;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-page-modern {
                padding: 16px;
            }

            .tabs-container {
                gap: 0;
            }

            .tab-item-modern {
                padding: 14px 16px;
                font-size: 0.75rem;
                gap: 6px;
            }

            .tab-item-modern svg {
                width: 16px;
                height: 16px;
            }

            .tab-item-modern span:last-child {
                display: none;
            }

            .tab-count {
                display: none;
            }

            .posts-grid {
                gap: 2px;
            }

            .liked-badge {
                width: 28px;
                height: 28px;
                top: 6px;
                right: 6px;
            }

            .liked-badge svg {
                width: 14px;
                height: 14px;
            }

            .overlay-stats {
                gap: 16px;
            }

            .stat-item {
                font-size: 0.9rem;
            }

            .stat-item svg {
                width: 20px;
                height: 20px;
            }
        }

        @media (max-width: 576px) {
            .tab-item-modern {
                padding: 12px;
                font-size: 0.7rem;
            }

            .empty-state-modern {
                padding: 60px 20px;
            }

            .empty-icon svg {
                width: 60px;
                height: 60px;
            }

            .empty-state-modern h4 {
                font-size: 1.2rem;
            }

            .empty-state-modern p {
                font-size: 0.85rem;
            }
        }

        /* Loading Animation for Grid Items */
        .grid-item {
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }

        .grid-item:nth-child(1) {
            animation-delay: 0.05s;
        }

        .grid-item:nth-child(2) {
            animation-delay: 0.10s;
        }

        .grid-item:nth-child(3) {
            animation-delay: 0.15s;
        }

        .grid-item:nth-child(4) {
            animation-delay: 0.20s;
        }

        .grid-item:nth-child(5) {
            animation-delay: 0.25s;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
@endsection
