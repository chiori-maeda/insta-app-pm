@if ($user->trashed())
    {{-- Activate Modal --}}
    <div class="modal fade" id="activate-user-{{ $user->id }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-admin activate-modal">
                <div class="modal-header-admin">
                    <div class="modal-icon-wrapper activate-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="8.5" cy="7" r="4" stroke-width="2"/>
                            <polyline points="17 11 19 13 23 9" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="modal-header-text">
                        <h3 class="modal-title-admin">Activate User</h3>
                        <p class="modal-subtitle-admin">This will restore user access</p>
                    </div>
                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <line x1="18" y1="6" x2="6" y2="18" stroke-width="2" stroke-linecap="round"/>
                            <line x1="6" y1="6" x2="18" y2="18" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
                
                <div class="modal-body-admin">
                    <div class="confirmation-message">
                        <p>Are you sure you want to activate</p>
                        <p class="user-name-highlight">{{ $user->name }}</p>
                        <p class="consequence-text">They will regain full access to their account.</p>
                    </div>
                </div>
                
                <div class="modal-footer-admin">
                    <form action="{{ route('admin.users.activate', $user->id) }}" method="post" class="w-100">
                        @csrf
                        @method('PATCH')
                        
                        <div class="button-group">
                            <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <line x1="18" y1="6" x2="6" y2="18" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="6" y1="6" x2="18" y2="18" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                Cancel
                            </button>
                            <button type="submit" class="btn-modal-activate">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <polyline points="20 6 9 17 4 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Activate User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    {{-- Deactivate Modal --}}
    <div class="modal fade" id="deactivate-user-{{ $user->id }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-admin deactivate-modal">
                <div class="modal-header-admin">
                    <div class="modal-icon-wrapper deactivate-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="8.5" cy="7" r="4" stroke-width="2"/>
                            <line x1="23" y1="11" x2="17" y2="11" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="modal-header-text">
                        <h3 class="modal-title-admin">Deactivate User</h3>
                        <p class="modal-subtitle-admin">This will suspend user access</p>
                    </div>
                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <line x1="18" y1="6" x2="6" y2="18" stroke-width="2" stroke-linecap="round"/>
                            <line x1="6" y1="6" x2="18" y2="18" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
                
                <div class="modal-body-admin">
                    <div class="confirmation-message">
                        <p>Are you sure you want to deactivate</p>
                        <p class="user-name-highlight">{{ $user->name }}</p>
                        <p class="consequence-text danger-text">They will lose access to their account immediately.</p>
                    </div>
                </div>
                
                <div class="modal-footer-admin">
                    <form action="{{ route('admin.users.deactivate', $user->id) }}" method="post" class="w-100">
                        @csrf
                        @method('DELETE')
                        
                        <div class="button-group">
                            <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <line x1="18" y1="6" x2="6" y2="18" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="6" y1="6" x2="18" y2="18" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                Cancel
                            </button>
                            <button type="submit" class="btn-modal-deactivate">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <line x1="18" y1="6" x2="6" y2="18" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="6" y1="6" x2="18" y2="18" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                Deactivate User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<style>
    /* Modal Content */
    .modal-content-admin {
        background: rgba(15, 15, 15, 0.98);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 16px;
        overflow: hidden;
        animation: modalSlideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    /* Modal Header */
    .modal-header-admin {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
    }

    .modal-icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        animation: iconPulse 2s ease-in-out infinite;
    }

    @keyframes iconPulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .activate-icon {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.2) 0%, rgba(34, 197, 94, 0.1) 100%);
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .activate-icon svg {
        stroke: #22c55e;
        stroke-width: 2;
    }

    .deactivate-icon {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(239, 68, 68, 0.1) 100%);
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .deactivate-icon svg {
        stroke: #ef4444;
        stroke-width: 2;
    }

    .modal-header-text {
        flex: 1;
    }

    .modal-title-admin {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0 0 4px 0;
    }

    .modal-subtitle-admin {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.85rem;
        margin: 0;
    }

    .btn-close-modal {
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
        padding: 0;
        flex-shrink: 0;
    }

    .btn-close-modal:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg);
    }

    .btn-close-modal svg {
        stroke: rgba(255, 255, 255, 0.7);
        stroke-width: 2;
    }

    /* Modal Body */
    .modal-body-admin {
        padding: 24px;
    }

    .confirmation-message {
        text-align: center;
    }

    .confirmation-message p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.95rem;
        margin: 0 0 8px 0;
    }

    .user-name-highlight {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 700;
        margin: 12px 0 !important;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .consequence-text {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.85rem;
        font-style: italic;
        margin-top: 12px !important;
    }

    .danger-text {
        color: rgba(239, 68, 68, 0.8);
    }

    /* Modal Footer */
    .modal-footer-admin {
        padding: 20px 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .button-group {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .btn-modal-secondary,
    .btn-modal-activate,
    .btn-modal-deactivate {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-modal-secondary {
        background: rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .btn-modal-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
    }

    .btn-modal-secondary svg {
        stroke: currentColor;
        stroke-width: 2;
    }

    .btn-modal-activate {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: #fff;
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    }

    .btn-modal-activate:hover {
        box-shadow: 0 6px 20px rgba(34, 197, 94, 0.5);
        transform: translateY(-2px);
    }

    .btn-modal-activate svg {
        stroke: currentColor;
        stroke-width: 2;
    }

    .btn-modal-deactivate {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-modal-deactivate:hover {
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
        transform: translateY(-2px);
    }

    .btn-modal-deactivate svg {
        stroke: currentColor;
        stroke-width: 2;
    }

    .btn-modal-activate:active,
    .btn-modal-deactivate:active,
    .btn-modal-secondary:active {
        transform: translateY(0);
    }

    /* Responsive */
    @media (max-width: 576px) {
        .modal-header-admin {
            padding: 20px;
        }

        .modal-icon-wrapper {
            width: 48px;
            height: 48px;
        }

        .modal-icon-wrapper svg {
            width: 28px;
            height: 28px;
        }

        .modal-title-admin {
            font-size: 1.1rem;
        }

        .modal-body-admin {
            padding: 20px;
        }

        .button-group {
            flex-direction: column-reverse;
        }

        .btn-modal-secondary,
        .btn-modal-activate,
        .btn-modal-deactivate {
            width: 100%;
            justify-content: center;
        }
    }
</style>