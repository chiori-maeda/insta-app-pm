@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')
    <div class="admin-posts-modern">
        
        {{-- Header --}}
        <div class="admin-header">
            <div class="header-content">
                <div class="header-info">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="14 2 14 8 20 8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="16" y1="13" x2="8" y2="13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="16" y1="17" x2="8" y2="17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="10 9 9 9 8 9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div>
                        <h2 class="header-title">Posts Management</h2>
                        <p class="header-subtitle">Monitor and moderate community content</p>
                    </div>
                </div>
                <div class="stats-badges">
                    <div class="stat-badge">
                        <span class="stat-number">{{ $all_posts->total() }}</span>
                        <span class="stat-label">Total Posts</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Posts Table --}}
        <div class="posts-table-container">
            <div class="table-wrapper">
                <table class="posts-table-modern">
                    <thead>
                        <tr>
                            <th class="th-id">ID</th>
                            <th class="th-preview">Preview</th>
                            <th class="th-category">Category</th>
                            <th class="th-owner">Owner</th>
                            <th class="th-date">Created At</th>
                            <th class="th-status">Status</th>
                            <th class="th-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($all_posts as $post)
                            <tr class="post-row">
                                <td class="td-id">{{ $post->id }}</td>
                                
                                <td class="td-preview">
                                    <a href="{{ route('post.show', $post->id) }}" class="post-preview-link">
                                        <img src="{{ $post->image }}" alt="Post {{ $post->id }}" class="post-img-thumb">
                                    </a>
                                </td>

                                <td class="td-category">
                                    <div class="category-stack">
                                        @forelse ($post->categoryPost as $category_post)
                                            <span class="modern-badge-category">
                                                {{ $category_post->category->name }}
                                            </span>
                                        @empty
                                            <span class="modern-badge-uncategorized">Uncategorized</span>
                                        @endforelse
                                    </div>
                                </td>

                                <td class="td-owner">
                                    <a href="{{ route('profile.show', $post->user->id) }}" class="owner-link">
                                        {{ $post->user->name }}
                                    </a>
                                </td>

                                <td class="td-date">{{ $post->created_at->format('M d, Y') }}</td>

                                <td class="td-status">
                                    @if ($post->trashed())
                                        <span class="status-badge status-hidden">
                                            <svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor">
                                                <circle cx="12" cy="12" r="10"/>
                                            </svg>
                                            Hidden
                                        </span>
                                    @else
                                        <span class="status-badge status-visible">
                                            <svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor">
                                                <circle cx="12" cy="12" r="10"/>
                                            </svg>
                                            Visible
                                        </span>
                                    @endif
                                </td>

                                <td class="td-actions">
                                    <div class="dropdown">
                                        <button class="action-btn-table" data-bs-toggle="dropdown">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <circle cx="12" cy="12" r="1" stroke-width="2"/>
                                                <circle cx="12" cy="5" r="1" stroke-width="2"/>
                                                <circle cx="12" cy="19" r="1" stroke-width="2"/>
                                            </svg>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-modern">
                                            @if ($post->trashed())
                                                <button class="dropdown-item-modern item-success" data-bs-toggle="modal" data-bs-target="#unhide-post-{{ $post->id }}">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <circle cx="12" cy="12" r="3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    <span>Unhide Post</span>
                                                </button>
                                            @else
                                                <button class="dropdown-item-modern item-danger" data-bs-toggle="modal" data-bs-target="#hide-post-{{ $post->id }}">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <line x1="1" y1="1" x2="23" y2="23" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    <span>Hide Post</span>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    @include('admin.posts.modals.status')
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="no-posts-msg">No posts found in the database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="pagination-container">
            {{ $all_posts->links() }}
        </div>
    </div>

    <style>
        .admin-posts-modern { opacity: 1; }

        /* Header Styles */
        .admin-header {
            background: rgba(10, 10, 10, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .header-info { display: flex; align-items: center; gap: 16px; }
        .header-info svg { stroke: #667eea; }
        .header-title { color: #fff; font-size: 1.5rem; font-weight: 700; margin: 0; }
        .header-subtitle { color: rgba(255, 255, 255, 0.5); font-size: 0.9rem; }

        .stat-badge {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
            border: 1px solid rgba(102, 126, 234, 0.3);
            border-radius: 12px;
            padding: 12px 20px;
            text-align: center;
        }

        .stat-number { color: #667eea; font-size: 1.5rem; font-weight: 700; display: block; }
        .stat-label { color: rgba(255, 255, 255, 0.6); font-size: 0.75rem; text-transform: uppercase; }

        /* Table Container */
        .posts-table-container {
            background: rgba(10, 10, 10, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            overflow: hidden;
        }

        .table-wrapper { overflow-x: auto; }

        .posts-table-modern { width: 100%; border-collapse: separate; border-spacing: 0; }
        .posts-table-modern thead { background: rgba(255, 255, 255, 0.03); }

        .posts-table-modern th {
            padding: 16px 20px;
            text-align: left;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .post-row { transition: background 0.3s ease; }
        .post-row:hover { background: rgba(255, 255, 255, 0.03); }
        .posts-table-modern td { padding: 16px 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.05); color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; }

        /* Preview Image */
        .post-img-thumb {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
        }
        .post-preview-link:hover .post-img-thumb { transform: scale(1.1); border-color: #667eea; }

        /* Category Badges */
        .category-stack { display: flex; flex-wrap: wrap; gap: 4px; }
        .modern-badge-category {
            background: rgba(102, 126, 234, 0.1);
            color: #a3bffa;
            border: 1px solid rgba(102, 126, 234, 0.2);
            padding: 2px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
        }
        .modern-badge-uncategorized {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.4);
            padding: 2px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
        }

        /* Owner Link */
        .owner-link { color: #fff; text-decoration: none; font-weight: 600; }
        .owner-link:hover { color: #667eea; }

        /* Status Badges */
        .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .status-visible { background: rgba(34, 197, 94, 0.15); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.3); }
        .status-hidden { background: rgba(156, 163, 175, 0.15); color: #9ca3af; border: 1px solid rgba(156, 163, 175, 0.3); }

        /* Action Button & Dropdown (Matched to Users page) */
        .action-btn-table {
            background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);
            width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.3s ease;
        }
        .action-btn-table:hover { background: rgba(102, 126, 234, 0.15); border-color: #667eea; }
        .action-btn-table svg { stroke: rgba(255, 255, 255, 0.6); }
        .action-btn-table:hover svg { stroke: #667eea; }

        .dropdown-menu-modern {
            background: rgba(15, 15, 15, 0.98); backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 12px; padding: 6px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6); min-width: 180px;
        }

        .dropdown-item-modern {
            display: flex; align-items: center; gap: 12px; padding: 10px 14px; border-radius: 8px;
            color: rgba(255, 255, 255, 0.85); font-size: 0.9rem; transition: all 0.2s ease;
            background: transparent; border: none; width: 100%; text-align: left;
        }

        .item-success:hover { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
        .item-danger:hover { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

        .no-posts-msg { padding: 40px !important; text-align: center; color: rgba(255, 255, 255, 0.4); font-style: italic; }
        .pagination-container { margin-top: 24px; display: flex; justify-content: center; }
    </style>
@endsection