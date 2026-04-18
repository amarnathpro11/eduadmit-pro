@extends('counselor.layout.app')
@section('page_title', 'Master Schedule')
@section('page_subtitle', 'View all your upcoming and past follow-up tasks')

@section('content')
    <div class="row g-4">
        <!-- Upcoming Tasks -->
        <div class="col-md-7">
            <div class="white-card border-0 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-white mb-0"><i class="fa fa-calendar-alt text-primary me-2"></i> Upcoming Tasks
                    </h5>
                    <span class="badge bg-primary rounded-pill">{{ $upcoming->count() }} Pending</span>
                </div>

                <div class="task-timeline">
                    @forelse($upcoming as $task)
                        <div class="d-flex gap-3 mb-4 position-relative">
                            <div class="text-center" style="min-width: 80px;">
                                <div class="fw-bold text-primary fs-5">{{ $task->scheduled_at->format('M d') }}</div>
                                <div class="text-secondary small fw-bold opacity-75">
                                    {{ $task->scheduled_at->format('h:i A') }}</div>
                            </div>
                            <div class="flex-grow-1 p-3 rounded-3 border border-secondary border-opacity-25 shadow-sm"
                                style="background: rgba(255,255,255,0.03);">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="fw-bold text-white mb-2 fs-5">{{ $task->lead->name }}</h6>
                                        <span
                                            class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 fw-medium"
                                            style="font-size: 0.75rem;">
                                            <i class="fa fa-graduation-cap me-1"></i>
                                            {{ $task->lead->course->name ?? 'General Inquiry' }}
                                        </span>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <form action="{{ route('counselor.leads.followup.complete', $task->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success px-3 rounded-pill fw-bold"
                                                style="font-size: 0.75rem;">Done</button>
                                        </form>
                                        <a href="{{ route('counselor.leads.show', $task->lead_id) }}"
                                            class="btn btn-sm btn-dark px-3 rounded-pill fw-bold border border-secondary border-opacity-50"
                                            style="font-size: 0.75rem;">View</a>
                                        <form action="{{ route('counselor.leads.followup.destroy', $task->id) }}"
                                            method="POST" onsubmit="return confirm('Remove this task?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger px-2 rounded-pill"><i
                                                    class="fa fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                </div>
                                @if ($task->note)
                                    <p class="text-muted small mb-0 mt-2 italic"><i
                                            class="fa fa-quote-left me-1 opacity-25"></i> {{ $task->note }}</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fa fa-calendar-check fs-1 text-muted opacity-25 mb-3 d-block"></i>
                            <p class="text-muted fw-bold">No upcoming tasks scheduled.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Completed Tasks -->
        <div class="col-md-5">
            <div class="white-card border-0">
                <h5 class="fw-bold text-white mb-4"><i class="fa fa-history text-primary me-2"></i> Recently Completed</h5>

                @forelse($completed as $task)
                    <div class="p-3 rounded-3 border border-secondary border-opacity-10 mb-3"
                        style="background: rgba(255,255,255,0.01);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-primary fw-bold mb-0" style="font-size: 0.9rem;">{{ $task->lead->name }}
                                </h6>
                                <small class="text-muted" style="font-size: 0.75rem;">Finished
                                    {{ $task->updated_at->diffForHumans() }}</small>
                            </div>
                            <span class="text-success small"><i class="fa fa-check-circle"></i> Completed</span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small fst-italic">History will appear here once tasks are marked done.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
