@extends('layouts.app')

@section('title', 'Home')

@section('content')
    {{-- Stories Bar --}}
    <div class="stories-section-modern">
        <div class="stories-container-modern">
            {{-- Create Story --}}
            <a href="{{ route('stories.create') }}" class="story-card-modern create-story">
                <div class="story-avatar-wrapper create-avatar">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="12" y1="5" x2="12" y2="19" stroke-width="2.5"
                            stroke-linecap="round" />
                        <line x1="5" y1="12" x2="19" y2="12" stroke-width="2.5"
                            stroke-linecap="round" />
                    </svg>
                </div>
                <span class="story-username">Create</span>
            </a>

            {{-- User Stories --}}
            @foreach ($home_stories->sortByDesc(fn($stories, $userId) => $userId == Auth::id()) as $userId => $stories)
                @php
                    $first_story = $stories->first();
                @endphp
                <a href="{{ route('stories.show', $first_story->id) }}" class="story-card-modern">
                    <div class="story-avatar-wrapper">
                        @if ($first_story->user->avatar)
                            <img src="{{ $first_story->user->avatar }}" class="story-avatar-img"
                                alt="{{ $first_story->user->name }}">
                        @else
                            <div class="story-avatar-default">
                                {{ strtoupper(substr($first_story->user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="story-ring"></div>
                    </div>
                    <span class="story-username">{{ $first_story->user->name }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Main Content --}}
    <div class="home-content-modern">
        <div class="home-grid">

            {{-- Posts Feed --}}
            <div class="posts-feed-modern">
                @forelse ($home_posts as $post)
                    <div class="post-card-home" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                        @include('users.posts.contents.title')
                        @include('users.posts.contents.body')
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div class="empty-feed-modern">
                        <div class="empty-icon-feed">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <circle cx="8.5" cy="8.5" r="1.5" fill="currentColor" />
                                <polyline points="21 15 16 10 5 21" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h2 class="empty-title-feed">Share Your Moments</h2>
                        <p class="empty-text-feed">When you share photos, they'll appear here on your feed.</p>
                        <a href="{{ route('post.create') }}" class="btn-create-first">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="12" cy="12" r="10" stroke-width="2" />
                                <line x1="12" y1="8" x2="12" y2="16" stroke-width="2"
                                    stroke-linecap="round" />
                                <line x1="8" y1="12" x2="16" y2="12" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                            Share Your First Photo
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Sidebar --}}
            <div class="sidebar-modern">

                {{-- Profile Card --}}
                <div class="profile-card-modern">
                    <a href="{{ route('profile.show', Auth::user()->id) }}" class="profile-link-home">
                        @if (Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}"
                                class="profile-avatar-home">
                        @else
                            <div class="profile-avatar-default-home">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </a>
                    <div class="profile-info-home">
                        <a href="{{ route('profile.show', Auth::user()->id) }}" class="profile-name-home">
                            {{ Auth::user()->name }}
                        </a>
                        <p class="profile-email-home">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                {{-- Suggestions --}}
                @if ($suggested_users)
                    <div class="suggestions-section">
                        <div class="suggestions-header">
                            <h3 class="suggestions-title">Suggestions For You</h3>
                            <a href="#" class="see-all-link" data-bs-toggle="modal"
                                data-bs-target="#seeAllSuggestions">See all</a>
                        </div>

                        <div class="suggestions-list">
                            @foreach (array_slice($suggested_users, 0, 5) as $user)
                                <div class="suggestion-item" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                                    <a href="{{ route('profile.show', $user->id) }}"
                                        class="suggestion-avatar-link text-decoration-none">
                                        @if ($user->avatar)
                                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                                class="suggestion-avatar">
                                        @else
                                            <div class="suggestion-avatar-default">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </a>
                                    <div class="suggestion-info">
                                        <a href="{{ route('profile.show', $user->id) }}" class="suggestion-name">
                                            {{ $user->name }}
                                        </a>
                                        <p class="suggestion-meta">Suggested for you</p>
                                    </div>
                                    <form action="{{ route('follow.store', $user->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn-follow-suggestion">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor">
                                                <line x1="12" y1="5" x2="12" y2="19"
                                                    stroke-width="2" stroke-linecap="round" />
                                                <line x1="5" y1="12" x2="19" y2="12"
                                                    stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                            Follow
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>

    <div class="modal fade" id="seeAllSuggestions" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content suggestion-modal-content">
                <div class="modal-header suggestion-modal-header">
                    <h5 class="modal-title text-white">Suggested For You</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body suggestion-modal-body">
                    <div class="suggestions-list-full">
                        @foreach ($suggested_users as $user)
                            <div class="suggestion-item modal-item">
                                <a href="{{ route('profile.show', $user->id) }}" class="suggestion-avatar-link">
                                    @if ($user->avatar)
                                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                            class="suggestion-avatar">
                                    @else
                                        <div class="suggestion-avatar-default">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </a>
                                <div class="suggestion-info">
                                    <a href="{{ route('profile.show', $user->id) }}"
                                        class="suggestion-name">{{ $user->name }}</a>
                                    <p class="suggestion-meta">{{ $user->email }}</p>
                                </div>
                                <form action="{{ route('follow.store', $user->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn-follow-suggestion">Follow</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    /* Suggestion Modal Styling */
    .suggestion-modal-content {
        background: #0a0a0a !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 20px !important;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    }

    .suggestion-modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 20px !important;
    }

    .suggestion-modal-body {
        max-height: 400px;
        overflow-y: auto;
        padding: 10px 20px !important;
    }

    /* Custom Scrollbar for Modal */
    .suggestion-modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .suggestion-modal-body::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    .modal-item {
        padding: 12px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .modal-item:last-child {
        border-bottom: none;
    }

    .modal-item .suggestion-name {
        font-size: 1rem;
    }

    /* Fade in animation for items inside modal */
    .modal.show .modal-item {
        animation: fadeInUp 0.4s ease forwards;
    }

    /* Stories Section */
    .stories-section-modern {
        background: #0a0a0a;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 20px 0;
        margin-bottom: 24px;
    }

    .stories-container-modern {
        max-width: 935px;
        margin: 0 auto;
        padding: 10px 20px;
        display: flex;
        gap: 16px;
        overflow-x: auto;
        scroll-behavior: smooth;
    }

    .stories-container-modern::-webkit-scrollbar {
        height: 6px;
    }

    .stories-container-modern::-webkit-scrollbar-track {
        background: transparent;
    }

    .stories-container-modern::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }

    /* Story Card */
    .story-card-modern {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        min-width: 80px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .story-card-modern:hover {
        transform: translateY(-4px);
    }

    .story-avatar-wrapper {
        position: relative;
        width: 70px;
        height: 70px;
    }

    .story-avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #0a0a0a;
        position: relative;
        /* z-index: 1; */
    }

    .story-avatar-default {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.5rem;
        border: 3px solid #0a0a0a;
        position: relative;
        /* z-index: 1; */
    }

    .story-ring {
        /* position: absolute; */
        top: -3px;
        left: -3px;
        right: -3px;
        bottom: -3px;
        border-radius: 50%;
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        /* z-index: 0; */
    }

    /* Create Story */
    .create-story .create-avatar {
        background: rgba(102, 126, 234, 0.15);
        border: 2px dashed rgba(102, 126, 234, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .create-story .create-avatar svg {
        stroke: #667eea;
        stroke-width: 2;
    }

    .create-story:hover .create-avatar {
        background: rgba(102, 126, 234, 0.25);
        border-color: rgba(102, 126, 234, 0.7);
    }

    .story-username {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.75rem;
        font-weight: 500;
        max-width: 80px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-align: center;
    }

    /* Main Content */
    .home-content-modern {
        max-width: 935px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .home-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 28px;
    }

    /* Posts Feed */
    .posts-feed-modern {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .post-card-home {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
        }
    }

    /* Empty State */
    .empty-feed-modern {
        background: #0a0a0a;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 80px 40px;
        text-align: center;
        animation: fadeIn 0.6s ease;
    }

    .empty-icon-feed {
        margin-bottom: 24px;
        display: inline-block;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .empty-icon-feed svg {
        stroke: rgba(255, 255, 255, 0.3);
        stroke-width: 2;
    }

    .empty-title-feed {
        color: #fff;
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0 0 12px 0;
    }

    .empty-text-feed {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.95rem;
        margin: 0 0 24px 0;
    }

    .btn-create-first {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-create-first:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: #fff;
    }

    .btn-create-first svg {
        stroke: currentColor;
        stroke-width: 2;
    }

    /* Sidebar */
    .sidebar-modern {
        position: sticky;
        top: 140px;
        height: fit-content;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Profile Card */
    .profile-card-modern {
        background: #0a0a0a;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
    }

    .profile-card-modern:hover {
        border-color: rgba(102, 126, 234, 0.3);
        transform: translateY(-2px);
    }

    .profile-avatar-home {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(102, 126, 234, 0.3);
    }

    .profile-avatar-default-home {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.3rem;
    }

    .profile-info-home {
        flex: 1;
        min-width: 0;
    }

    .profile-name-home {
        color: #fff;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        display: block;
        transition: color 0.2s ease;
        margin-bottom: 4px;
    }

    .profile-name-home:hover {
        color: #667eea;
    }

    .profile-email-home {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.8rem;
        margin: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Suggestions */
    .suggestions-section {
        background: #0a0a0a;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 20px;
    }

    .suggestions-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .suggestions-title {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
    }

    .see-all-link {
        color: #667eea;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .see-all-link:hover {
        color: #7c8ef5;
    }

    .suggestions-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .suggestion-item {
        display: flex;
        align-items: center;
        gap: 12px;
        animation: fadeInLeft 0.5s ease forwards;
        opacity: 0;
    }

    @keyframes fadeInLeft {
        to {
            opacity: 1;
        }
    }

    .suggestion-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
    }

    .suggestion-avatar-default {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
    }

    .suggestion-info {
        flex: 1;
        min-width: 0;
    }

    .suggestion-name {
        color: #fff;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        display: block;
        transition: color 0.2s ease;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .suggestion-name:hover {
        color: #667eea;
    }

    .suggestion-meta {
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.75rem;
        margin: 2px 0 0 0;
    }

    .btn-follow-suggestion {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 16px;
        color: #fff;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-follow-suggestion:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.5);
    }

    .btn-follow-suggestion svg {
        stroke: currentColor;
        stroke-width: 2;
    }

    /* Sidebar Footer */
    .sidebar-footer {
        padding: 16px 0;
        text-align: center;
    }

    .footer-text-home {
        color: rgba(255, 255, 255, 0.3);
        font-size: 0.75rem;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .home-grid {
            grid-template-columns: 1fr;
        }

        .sidebar-modern {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .stories-section-modern {
            padding: 16px 0;
        }

        .stories-container-modern {
            padding: 0 16px;
            gap: 12px;
        }

        .story-card-modern {
            min-width: 70px;
        }

        .story-avatar-wrapper {
            width: 60px;
            height: 60px;
        }

        .home-content-modern {
            padding: 0 16px;
        }
    }
</style>
