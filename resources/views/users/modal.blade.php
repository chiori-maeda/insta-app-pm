<!-- See All Suggestions Modal -->
                        <div class="modal fade" id="seeAllModal" tabindex="-1" aria-labelledby="seeAllModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content bg-dark text-white">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title" id="seeAllModalLabel">Suggestions For You</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="list-group">
                                            @foreach ($suggested_users as $user)
                                                <div
                                                    class="list-group-item list-group-item-dark d-flex align-items-center justify-content-between mb-2 rounded">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <a href="{{ route('profile.show', $user->id) }}">
                                                            @if ($user->avatar)
                                                                <img src="{{ $user->avatar }}" class="rounded-circle"
                                                                    width="50" height="50"
                                                                    alt="{{ $user->name }}">
                                                            @else
                                                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-gradient-primary text-white"
                                                                    style="width:50px; height:50px;">
                                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                        </a>
                                                        <div>
                                                            <a href="{{ route('profile.show', $user->id) }}"
                                                                class="text-white fw-bold text-decoration-none">{{ $user->name }}</a>
                                                            <div class="text-muted small">Suggested for you</div>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('follow.store', $user->id) }}" method="post">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-sm btn-primary">Follow</button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>