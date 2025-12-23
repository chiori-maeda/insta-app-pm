@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')
    <div class="admin-container-modern">
        {{-- Header Section --}}
        <div class="admin-header-modern">
            <div class="header-content">
                <div class="header-main-group">
                    <div class="header-icon-main">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="header-title">Categories</h2>
                        <p class="header-subtitle">Manage and organize your content tags</p>
                    </div>
                </div>
                <div class="stats-badges">
                    <div class="stat-badge">
                        <span class="stat-number">{{ $all_categories->total() }}</span>
                        <span class="stat-label">Total Categories</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Add Category Form --}}
        <form action="{{ route('admin.categories.store') }}" method="post" class="my-4">
            @csrf
            <div class="input-group-modern">
                <input type="text" name="name" class="form-control-modern" placeholder="Add a new category..."
                    autofocus>
                <button type="submit" class="btn-add-modern">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="12" y1="5" x2="12" y2="19" stroke-width="2.5"
                            stroke-linecap="round" />
                        <line x1="5" y1="12" x2="19" y2="12" stroke-width="2.5"
                            stroke-linecap="round" />
                    </svg>
                    <span>Add</span>
                </button>
            </div>
            @error('name')
                <p class="error-msg-modern"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
            @enderror
        </form>

        {{-- Categories Table --}}
        <div class="row">
            <div class="col-lg-9">
                <div class="table-container-modern">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th class="text-center" width="10%">ID</th>
                                <th width="35%">NAME</th>
                                <th class="text-center" width="15%">COUNT</th>
                                <th width="20%">LAST UPDATED</th>
                                <th class="text-end" width="20%">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($all_categories as $category)
                                <tr class="row-modern">
                                    <td class="text-center text-muted">{{ $category->id }}</td>
                                    <td><span class="category-name-main">{{ $category->name }}</span></td>
                                    <td class="text-center">
                                        <div class="count-pill">{{ $category->categoryPost->count() }}</div>
                                    </td>
                                    <td class="text-secondary small">{{ $category->updated_at }}</td>
                                    <td class="text-end">
                                        <button class="action-btn edit" data-bs-toggle="modal"
                                            data-bs-target="#edit-category-{{ $category->id }}">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button class="action-btn delete" data-bs-toggle="modal"
                                            data-bs-target="#delete-category-{{ $category->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                        @include('admin.categories.modals.action')
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-5 text-muted">No categories found.</td>
                                </tr>
                            @endforelse
                            <tr class="row-modern uncategorized">
                                <td class="text-center">
                                    <span class="category-tag category-tag-empty">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor">
                                            <circle cx="12" cy="12" r="10" stroke-width="2" />
                                            <line x1="12" y1="8" x2="12" y2="12"
                                                stroke-width="2" stroke-linecap="round" />
                                            <line x1="12" y1="16" x2="12.01" y2="16"
                                                stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </td>
                                <td>
                                    <span class="category-name-main">Uncategorized</span>
                                    <div class="consequence-text small">System default</div>
                                </td>
                                <td class="text-center">
                                    <div class="count-pill secondary">{{ $uncategorized_count }}</div>
                                </td>
                                <td class="text-muted small">-</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #0a0a0a;
            color: #fff;
            font-family: 'Inter', sans-serif;
        }

        .admin-container-modern {
            padding: 2rem;
        }

        .admin-header-modern {
            background: rgba(20, 20, 20, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-main-group {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-icon-main {
            background: rgba(102, 126, 234, 0.1);
            padding: 14px;
            border-radius: 14px;
            color: #667eea;
            border: 1px solid rgba(102, 126, 234, 0.2);
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

        .stat-badge {
            background: rgba(102, 126, 234, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.2);
            padding: 10px 20px;
            border-radius: 14px;
            text-align: center;
        }

        .stat-number {
            display: block;
            color: #667eea;
            font-size: 1.4rem;
            font-weight: 800;
        }

        .stat-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 1px;
        }

        .input-group-modern {
            display: flex;
            gap: 10px;
            background: rgba(255, 255, 255, 0.05);
            padding: 8px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            max-width: 450px;
        }

        .form-control-modern {
            background: transparent;
            border: none;
            color: white;
            padding: 10px;
            width: 100%;
            outline: none;
        }

        .btn-add-modern {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 0 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }

        .table-container-modern {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            overflow: hidden;
        }

        .table-modern {
            width: 100%;
            border-collapse: collapse;
        }

        .table-modern thead th {
            padding: 20px;
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.8rem;
            text-transform: uppercase;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .row-modern td {
            padding: 20px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(255, 255, 255, 0.02);
        }

        .action-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            color: white;
            transition: 0.3s;
        }

        .action-btn.edit:hover {
            background: #fbbf24;
            color: black;
            border-color: #fbbf24;
        }

        .action-btn.delete:hover {
            background: #ef4444;
            color: white;
            border-color: #ef4444;
        }

        .modal-content {
            background: #1a1a1a !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 24px !important;
            color: white;
        }

        .modal-backdrop.show {
            opacity: 0.8;
            backdrop-filter: blur(4px);
        }

        .modal-header-custom {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .icon-box {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .icon-box.warning {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        .icon-box.danger {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .modal-footer-modern {
            padding: 24px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-modal-update,
        .btn-modal-delete {
            padding: 10px 25px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            z-index: 1060;
            position: relative;
        }

        .btn-modal-update {
            background: #fbbf24;
            color: black;
        }

        .btn-modal-delete {
            background: #ef4444;
            color: white;
        }
    </style>
@endsection
