@extends('layouts.app')
 
@section('title', 'Explore')
 
@section('content')
    <div class="search-results-modern">
        <div class="search-container">
            
            {{-- Search Header --}}
            <div class="search-header">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="11" cy="11" r="8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="m21 21-4.35-4.35" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h2 class="search-title">
                    Search results for <span class="search-query">"{{ $search }}"</span>
                </h2>
                @if($users->isNotEmpty())
                    <span class="results-count">{{ $users->count() }} {{ Str::plural('result', $users->count()) }}</span>
                @endif
            </div>

            {{-- User Results --}}
            <div class="results-list">
                @forelse ($users as $user)
                    <div class="user-card">
                        {{-- Avatar --}}
                        <a href="{{ route('profile.show', $user->id) }}" class="user-avatar-link">
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="user-avatar">
                            @else
                                <div class="user-avatar-default">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </a>

                        {{-- User Info --}}
                        <div class="user-info">
                            <a href="{{ route('profile.show', $user->id) }}" class="user-name">
                                {{ $user->name }}
                                @if ($user->id === Auth::user()->id)
                                    <span class="badge-you-small">You</span>
                                @endif
                            </a>
                            <p class="user-email">{{ $user->email }}</p>
                        </div>

                        {{-- Follow Button --}}
                        <div class="user-actions">
                            @if ($user->id !== Auth::user()->id)
                                @if ($user->isFollowed())
                                    <form action="{{ route('follow.destroy', $user->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-follow-card following">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <polyline points="20 6 9 17 4 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            Following
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('follow.store', $user->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn-follow-card">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <line x1="12" y1="5" x2="12" y2="19" stroke-width="2" stroke-linecap="round"/>
                                                <line x1="5" y1="12" x2="19" y2="12" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                            Follow
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-results">
                        <div class="empty-icon">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="11" cy="11" r="8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="m21 21-4.35-4.35" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <line x1="11" y1="8" x2="11" y2="14" stroke-width="2" stroke-linecap="round"/>
                                <line x1="11" y1="16" x2="11.01" y2="16" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <h3>No users found</h3>
                        <p>We couldn't find any users matching "<span class="highlight-text">{{ $search }}</span>"</p>
                        <p class="suggestion">Try searching with different keywords</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <style>
        .search-results-modern {
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .search-container {
            background: #0a0a0a;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 24px;
            animation: slideUp 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .search-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .search-header svg {
            stroke: #667eea;
            stroke-width: 2;
            flex-shrink: 0;
        }

        .search-title {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
            font-weight: 500;
            margin: 0;
            flex: 1;
        }

        .search-query {
            color: #fff;
            font-weight: 700;
        }

        .results-count {
            background: rgba(102, 126, 234, 0.15);
            color: #667eea;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .results-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.5s ease forwards;
            opacity: 0;
        }

        .user-card:nth-child(1) { animation-delay: 0.1s; }
        .user-card:nth-child(2) { animation-delay: 0.15s; }
        .user-card:nth-child(3) { animation-delay: 0.2s; }
        .user-card:nth-child(4) { animation-delay: 0.25s; }
        .user-card:nth-child(5) { animation-delay: 0.3s; }

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

        .user-card:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(102, 126, 234, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .user-avatar-link {
            flex-shrink: 0;
        }

        .user-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .user-avatar-link:hover .user-avatar {
            border-color: rgba(102, 126, 234, 0.6);
            transform: scale(1.05);
        }

        .user-avatar-default {
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
            border: 2px solid rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .user-avatar-link:hover .user-avatar-default {
            border-color: rgba(102, 126, 234, 0.6);
            transform: scale(1.05);
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: color 0.2s ease;
            margin-bottom: 4px;
        }

        .user-name:hover {
            color: #667eea;
        }

        .badge-you-small {
            background: rgba(102, 126, 234, 0.2);
            color: #667eea;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .user-email {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.85rem;
            margin: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-actions {
            flex-shrink: 0;
        }

        .btn-follow-card {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 20px;
            color: #fff;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        .btn-follow-card svg {
            stroke: currentColor;
            stroke-width: 2;
        }

        .btn-follow-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.5);
        }

        .btn-follow-card:active {
            transform: translateY(0);
        }

        .btn-follow-card.following {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
            box-shadow: none;
        }

        .btn-follow-card.following:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.4);
            color: #ef4444;
        }

        .empty-results {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            text-align: center;
        }

        .empty-icon {
            margin-bottom: 24px;
            opacity: 0;
            animation: fadeInScale 0.6s ease forwards;
        }

        .empty-icon svg {
            stroke: rgba(255, 255, 255, 0.2);
            stroke-width: 1.5;
        }

        .empty-results h3 {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 12px;
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
            animation-delay: 0.2s;
        }

        .empty-results p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.95rem;
            margin-bottom: 8px;
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
            animation-delay: 0.3s;
        }

        .highlight-text {
            color: #667eea;
            font-weight: 600;
        }

        .suggestion {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.85rem;
            font-style: italic;
            animation-delay: 0.4s !important;
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


        @media (max-width: 768px) {
            .search-results-modern {
                padding: 16px;
            }

            .search-container {
                padding: 20px;
            }

            .search-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .search-title {
                font-size: 0.95rem;
            }

            .results-count {
                align-self: flex-start;
            }

            .user-card {
                padding: 12px;
            }

            .user-avatar,
            .user-avatar-default {
                width: 48px;
                height: 48px;
                font-size: 1.1rem;
            }

            .user-name {
                font-size: 0.95rem;
            }

            .user-email {
                font-size: 0.8rem;
            }

            .btn-follow-card {
                padding: 6px 16px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .search-container {
                padding: 16px;
            }

            .user-card {
                gap: 12px;
            }

            .btn-follow-card {
                padding: 6px 12px;
                font-size: 0.75rem;
            }

            .btn-follow-card svg {
                width: 14px;
                height: 14px;
            }
        }
    </style>
@endsection