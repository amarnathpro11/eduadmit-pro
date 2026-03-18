@extends('admin.layout.app')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="text-white fw-bold mb-1">Follow-up & Reminders</h3>
                <p class="text-white-50 small">Manage your scheduled calls and daily counselor tasks.</p>
            </div>
            <button class="btn btn-primary d-flex align-items-center gap-2 px-4 py-2 shadow-sm"
                    style="border-radius: 12px; background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%); border: none;"
                    data-bs-toggle="modal" data-bs-target="#quickAddModal">
                <i class="fa fa-calendar-plus"></i> Schedule Follow-up
            </button>
        </div>

        {{-- Background Calendar-like structure (Simplified for now) --}}
        <div class="card dark-card border-0 shadow-sm overflow-hidden" style="min-height: 550px; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(10px);">
            <div class="card-header bg-transparent border-bottom border-white border-opacity-10 p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="text-white mb-0 fw-bold">{{ now()->format('F Y') }}</h5>
                        <p class="text-white-50 small mb-0">Total {{ $followUps->count() }} active schedules</p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle" style="width: 8px; height: 8px; background: #10b981;"></span>
                            <span class="text-white-50 x-small">Completed</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle" style="width: 8px; height: 8px; background: #f59e0b;"></span>
                            <span class="text-white-50 x-small">Postponed</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle" style="width: 8px; height: 8px; background: #6366f1;"></span>
                            <span class="text-white-50 x-small">Scheduled</span>
                        </div>
                        <div class="btn-group shadow-sm ms-2" style="border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.1);">
                            <button class="btn btn-sm btn-primary px-3 mt-0">Month</button>
                            <button class="btn btn-sm btn-dark text-white-50 px-3 mt-0">Week</button>
                            <button class="btn btn-sm btn-dark text-white-50 px-3 mt-0">Day</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover border-0 align-middle mb-0">
                        <thead>
                            <tr class="text-white-50 small text-uppercase fw-bold" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                <th class="ps-4 py-3">Lead Name</th>
                                <th class="py-3">Scheduled At</th>
                                <th class="py-3">Priority</th>
                                <th class="py-3">Status</th>
                                <th class="pe-4 py-3 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($followUps as $task)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.03);">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-placeholder rounded-circle me-3 d-flex align-items-center justify-content-center text-white small fw-bold"
                                                 style="width: 32px; height: 32px; background: rgba(99, 102, 241, 0.1); border: 1px solid rgba(99, 102, 241, 0.2);">
                                                {{ strtoupper(substr($task->lead->name, 0, 1)) }}
                                            </div>
                                            <span class="text-white fw-medium">{{ $task->lead->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-white fw-medium">{{ $task->scheduled_at->format('M d, Y') }}</div>
                                        <div class="text-white-50 small">{{ $task->scheduled_at->format('h:i A') }}</div>
                                    </td>
                                    <td>
                                        @php
                                            $priorityClass = match($task->priority) {
                                                'high' => 'bg-danger text-white',
                                                'medium' => 'bg-primary text-white',
                                                'low' => 'bg-info text-dark',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $priorityClass }} px-3 py-1" style="border-radius: 6px; font-size: 0.75rem;">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.follow_ups.status', $task->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" 
                                                    class="form-select form-select-sm bg-dark text-white border-0 py-1" 
                                                    style="width: auto; font-size: 0.8rem; background-color: rgba(255,255,255,0.05) !important;">
                                                <option value="scheduled" {{ $task->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $task->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                <option value="missed" {{ $task->status == 'missed' ? 'selected' : '' }}>Missed</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <form action="{{ route('admin.follow_ups.destroy', $task->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Are you sure?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-white-50">
                                        <i class="fa fa-calendar-times d-block mb-3 fs-3"></i>
                                        No follow-ups scheduled yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- SIDEBAR: Today's Tasks & Overdue --}}
    <div class="col-lg-4">
        <div class="dashboard-card p-4 border-Glow h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="text-white fw-bold mb-0">Today's Tasks</h5>
                <span class="badge bg-primary rounded-pill">{{ $todayTasks->count() }}</span>
            </div>
            
            @forelse($todayTasks as $task)
                <div class="task-card mb-3 p-3 rounded-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2 rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 24px; height: 24px; font-size: 0.7rem;">
                                {{ strtoupper(substr($task->lead->name, 0, 1)) }}
                            </div>
                            <span class="text-white small fw-bold">{{ $task->lead->name }}</span>
                        </div>
                        <span class="text-white-50 small">{{ $task->scheduled_at->format('h:i A') }}</span>
                    </div>
                    <p class="text-white-50 x-small mb-2 fw-light" style="font-size: 0.75rem;">{{ Str::limit($task->note ?? 'Follow up regarding admission process', 60) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'primary' : 'info') }} bg-opacity-25 text-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'primary' : 'info') }} border-0 px-2 py-1" style="font-size: 0.65rem;">
                            {{ strtoupper($task->priority) }}
                        </span>
                        <form action="{{ route('admin.follow_ups.status', $task->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-link text-success p-0 text-decoration-none x-small fw-bold" style="font-size: 0.75rem;">Mark Done</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-4 border-Glow rounded-4" style="border-style: dashed !important; border-width: 2px !important;">
                    <i class="fa fa-check-circle text-success fs-4 mb-2"></i>
                    <p class="text-white-50 small mb-0">No tasks for today.</p>
                </div>
            @endforelse

            <div class="mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-danger fw-bold mb-0">Overdue</h5>
                    <span class="badge bg-danger rounded-pill">{{ $overdueTasks->count() }}</span>
                </div>
                
                @forelse($overdueTasks as $task)
                    <div class="task-card mb-3 p-3 rounded-4" style="background: rgba(220,38,38,0.05); border: 1px solid rgba(220,38,38,0.1);">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="text-white small fw-bold">{{ $task->lead->name }}</span>
                            <span class="text-danger x-small fw-bold">{{ $task->scheduled_at->diffForHumans() }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="text-white-50 x-small">{{ $task->scheduled_at->format('M d, h:i A') }}</span>
                            <form action="{{ route('admin.follow_ups.status', $task->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-sm btn-danger px-2 py-0 border-0" style="font-size: 0.65rem; border-radius: 4px;">Done</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-white-50 small">Great job! No overdue tasks.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Quick-Add Follow-up --}}
<div class="modal fade" id="quickAddModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden; background: #ffffff;">
            <div class="modal-header border-0 px-4 py-3" style="background: #2563eb;">
                <h5 class="modal-title text-white fw-bold" id="exampleModalLabel">Quick-Add Follow-up</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.follow_ups.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label text-secondary small fw-bold text-uppercase">Select Lead</label>
                        <select name="lead_id" class="form-select border-0 shadow-sm py-2 px-3" 
                                style="background: #f8fafc; border-radius: 12px;" required>
                            <option value="" disabled selected>Search and select lead...</option>
                            @foreach($leads as $lead)
                                <option value="{{ $lead->id }}">{{ $lead->name }} ({{ $lead->phone }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-4">
                        <div class="col-6">
                            <label class="form-label text-secondary small fw-bold text-uppercase">Date</label>
                            <input type="date" name="date" class="form-control border-0 shadow-sm py-2 px-3" 
                                   style="background: #f8fafc; border-radius: 12px;" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-secondary small fw-bold text-uppercase">Time</label>
                            <input type="time" name="time" class="form-control border-0 shadow-sm py-2 px-3" 
                                   style="background: #f8fafc; border-radius: 12px;" required>
                        </div>
                    </div>

                    <div class="mb-4 text-center">
                        <label class="form-label text-secondary small fw-bold text-uppercase d-block mb-3">Priority Level</label>
                        <div class="btn-group w-100 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                            <input type="radio" class="btn-check" name="priority" id="priorityLow" value="low">
                            <label class="btn btn-outline-light text-secondary border-0 py-2" for="priorityLow">Low</label>

                            <input type="radio" class="btn-check" name="priority" id="priorityMed" value="medium" checked>
                            <label class="btn btn-outline-light text-secondary border-0 py-2" for="priorityMed">Medium</label>

                            <input type="radio" class="btn-check" name="priority" id="priorityHigh" value="high">
                            <label class="btn btn-outline-light text-secondary border-0 py-2" for="priorityHigh">High</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary small fw-bold text-uppercase">Notification Methods</label>
                        <div class="d-flex justify-content-between align-items-center mb-2 px-2">
                            <div class="d-flex align-items-center gap-3">
                                <i class="fa fa-bell text-primary"></i>
                                <span class="text-dark fw-medium">System Alert</span>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="system_notification" checked>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center px-2">
                            <div class="d-flex align-items-center gap-3">
                                <i class="fa fa-envelope text-muted"></i>
                                <span class="text-dark fw-medium">Email Reminder</span>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="email_notification">
                            </div>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label text-secondary small fw-bold text-uppercase">Note</label>
                        <textarea name="note" class="form-control border-0 shadow-sm py-2 px-3" 
                                  style="background: #f8fafc; border-radius: 12px;" rows="2" placeholder="Brief note about the call..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0 d-flex justify-content-between">
                    <button type="button" class="btn btn-link text-decoration-none text-muted fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow" 
                            style="border-radius: 12px; background: #2563eb; border: none;">Save Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-check:checked + .btn-outline-light {
        background-color: #e2e8f0 !important;
        color: #2563eb !important;
        font-weight: 700;
    }
    .modal-content select, .modal-content input, .modal-content textarea {
        color: #1e293b !important;
    }
    .modal-content .form-select:focus, .modal-content .form-control:focus {
        background: #f1f5f9 !important;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2) !important;
    }
</style>
@endsection
