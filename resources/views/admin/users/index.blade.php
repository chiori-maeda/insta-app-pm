@extends('layouts.app')
 
@section('title', 'Admin: Users')
 
@section('content')
    <div class="admin-users-modern">
        
        {{-- Header --}}
        <div class="admin-header">
            <div class="header-content">
                <div class="header-info">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="9" cy="7" r="4" stroke-width="2"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div>
                        <h2 class="header-title">Users Management</h2>
                        <p class="header-subtitle">Manage user accounts and permissions</p>
                    </div>
                </div>
                <div class="stats-badges">
                    <div class="stat-badge">
                        <span class="stat-number">{{ $all_users->total() }}</span>
                        <span class="stat-label">Total Users</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Users Table --}}
        <div class="users-table-container">
            <div class="table-wrapper">
                <table class="users-table-modern">
                    <thead>
                        <tr>
                            <th class="th-avatar">User</th>
                            <th class="th-name">Details</th>
                            <th class="th-email">Email</th>
                            <th class="th-date">Joined</th>
                            <th class="th-status">Status</th>
                            <th class="th-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_users as $user)
                            <tr class="user-row">
                                <td class="td-user">
                                    <a href="{{ route('profile.show', $user->id) }}" class="user-avatar-link">
                                        @if ($user->avatar)
                                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="user-avatar-table">
                                        @else
                                            <div class="user-avatar-default-table">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </a>
                                </td>
                                
                                <td class="td-name">
                                    <a href="{{ route('profile.show', $user->id) }}" class="user-name-link">
                                        {{ $user->name }}
                                        @if (Auth::user()->id === $user->id)
                                            <span class="badge-you-admin">You</span>
                                        @endif
                                    </a>
                                </td>

                                <td class="td-email">{{ $user->email }}</td>
                                <td class="td-date">{{ $user->created_at->format('M d, Y') }}</td>

                                <td class="td-status">
                                    @if ($user->trashed())
                                        <span class="status-badge status-inactive">
                                            <svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor">
                                                <circle cx="12" cy="12" r="10"/>
                                            </svg>
                                            Inactive
                                        </span>
                                    @else
                                        <span class="status-badge status-active">
                                            <svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor">
                                                <circle cx="12" cy="12" r="10"/>
                                            </svg>
                                            Active
                                        </span>
                                    @endif
                                </td>

                                <td class="td-actions">
                                    @if (Auth::user()->id !== $user->id)
                                        <div class="dropdown">
                                            <button class="action-btn-table" data-bs-toggle="dropdown">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                    <circle cx="12" cy="12" r="1" stroke-width="2"/>
                                                    <circle cx="12" cy="5" r="1" stroke-width="2"/>
                                                    <circle cx="12" cy="19" r="1" stroke-width="2"/>
                                                </svg>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-modern">
                                                @if ($user->trashed())
                                                    <button class="dropdown-item-modern item-success" data-bs-toggle="modal" data-bs-target="#activate-user-{{ $user->id }}">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <circle cx="8.5" cy="7" r="4" stroke-width="2"/>
                                                            <polyline points="17 11 19 13 23 9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                        <span>Activate User</span>
                                                    </button>
                                                @else
                                                    <button class="dropdown-item-modern item-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user-{{ $user->id }}">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <circle cx="8.5" cy="7" r="4" stroke-width="2"/>
                                                            <line x1="23" y1="11" x2="17" y2="11" stroke-width="2" stroke-linecap="round"/>
                                                        </svg>
                                                        <span>Deactivate User</span>
                                                    </button> 
                                                @endif
                                            </div>
                                        </div>
                                        @include('admin.users.modals.status')
                                    @else
                                        <span class="no-action">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-container">
            {{ $all_users->links() }}
        </div>
    </div>

    <style>
        .admin-users-modern {
            opacity: 1;
        }

        /* Header */
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

        .header-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-info svg {
            stroke: #667eea;
            stroke-width: 2;
            flex-shrink: 0;
        }

        .header-title {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .header-subtitle {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
            margin: 4px 0 0 0;
        }

        .stats-badges {
            display: flex;
            gap: 12px;
        }

        .stat-badge {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
            border: 1px solid rgba(102, 126, 234, 0.3);
            border-radius: 12px;
            padding: 12px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .stat-number {
            color: #667eea;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Table Container */
        .users-table-container {
            background: rgba(10, 10, 10, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        /* Table Styles */
        .users-table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .users-table-modern thead {
            background: rgba(255, 255, 255, 0.03);
        }

        .users-table-modern th {
            padding: 16px 20px;
            text-align: left;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .user-row {
            transition: background 0.3s ease;
            opacity: 1;
        }

        .user-row:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .users-table-modern td {
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        /* Avatar in Table */
        .user-avatar-table {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .user-avatar-link:hover .user-avatar-table {
            border-color: rgba(102, 126, 234, 0.6);
            transform: scale(1.05);
        }

        .user-avatar-default-table {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            border: 2px solid rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .user-avatar-link:hover .user-avatar-default-table {
            border-color: rgba(102, 126, 234, 0.6);
            transform: scale(1.05);
        }

        /* User Name */
        .user-name-link {
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .user-name-link:hover {
            color: #667eea;
        }

        .badge-you-admin {
            background: rgba(102, 126, 234, 0.2);
            color: #667eea;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 8px;
            text-transform: uppercase;
        }

        /* Email & Date */
        .td-email, .td-date {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-active {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .status-inactive {
            background: rgba(156, 163, 175, 0.15);
            color: #9ca3af;
            border: 1px solid rgba(156, 163, 175, 0.3);
        }

        /* Actions Button */
        .action-btn-table {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-btn-table svg {
            stroke: rgba(255, 255, 255, 0.6);
            stroke-width: 2;
        }

        .action-btn-table:hover {
            background: rgba(102, 126, 234, 0.15);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .action-btn-table:hover svg {
            stroke: #667eea;
        }

        .no-action {
            color: rgba(255, 255, 255, 0.3);
            font-size: 1.2rem;
        }

        /* Dropdown */
        .dropdown-menu-modern {
            background: rgba(15, 15, 15, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 6px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
            min-width: 200px;
        }

        .dropdown-item-modern {
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
            text-align: left;
        }

        .item-success { color: rgba(34, 197, 94, 0.9); }
        .item-success:hover { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
        .item-danger { color: rgba(239, 68, 68, 0.9); }
        .item-danger:hover { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

        .pagination-container {
            margin-top: 24px;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 1024px) {
            .header-content { flex-direction: column; align-items: flex-start; }
            .stats-badges { width: 100%; justify-content: flex-start; }
        }

        @media (max-width: 768px) {
            .admin-header { padding: 20px; }
            .header-title { font-size: 1.3rem; }
            .users-table-modern th, .users-table-modern td { padding: 12px; font-size: 0.85rem; }
            .user-avatar-table, .user-avatar-default-table { width: 40px; height: 40px; font-size: 1rem; }
        }
    </style>
@endsection