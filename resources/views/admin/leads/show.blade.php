@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white fw-bold mb-1">Lead Details</h2>
        <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i> Back to Leads
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <!-- Lead Profile Card -->
            <div class="dark-card p-4 rounded-4" style="background: #1a1f2e; border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                        style="width: 60px; height: 60px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; font-size: 1.2rem;">
                        {{ collect(explode(' ', $lead->name))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->join('') }}
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-1">{{ $lead->name }}</h4>
                        <span class="badge bg-primary bg-opacity-10 text-primary">{{ $lead->status }}</span>
                    </div>
                </div>
                <hr class="border-secondary border-opacity-25">
                <div class="mb-3">
                    <small class="text-secondary text-uppercase fw-bold">Contact Info</small>
                    <div class="text-white mt-2"><i class="bi bi-envelope me-2"></i>{{ $lead->email ?? 'N/A' }}</div>
                    <div class="text-white mt-1"><i class="bi bi-telephone me-2"></i>{{ $lead->phone }}</div>
                </div>
                <div class="mb-3">
                    <small class="text-secondary text-uppercase fw-bold">Course Interested</small>
                    <div class="text-white mt-2"><i class="bi bi-book me-2"></i>{{ $lead->course->name ?? 'N/A' }}</div>
                </div>
                <div class="mb-3">
                    <small class="text-secondary text-uppercase fw-bold">Other Info</small>
                    <div class="text-white mt-2"><i class="bi bi-box-arrow-in-right me-2"></i>Source: {{ $lead->source }}</div>
                    <div class="text-white mt-1"><i class="bi bi-person me-2"></i>Assigned To: {{ $lead->assignedTo->name ?? 'Unassigned' }}</div>
                    <div class="text-white mt-1"><i class="bi bi-star me-2"></i>Score: {{ $lead->lead_score }}%</div>
                </div>
                @if($lead->notes)
                <div class="mb-3">
                    <small class="text-secondary text-uppercase fw-bold">Notes</small>
                    <div class="text-white mt-2"><i class="bi bi-card-text me-2"></i>{{ $lead->notes }}</div>
                </div>
                @endif
            </div>
        </div>

        <div class="col-md-8">
            <!-- Communication History -->
            <div class="dark-card p-4 rounded-4 h-100" style="background: #121826; border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-white fw-bold mb-0">Communication History</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCommModal">
                        <i class="bi bi-plus-lg me-1"></i> Log Activity
                    </button>
                </div>

                <div class="timeline ps-3" style="border-left: 2px solid rgba(255,255,255,0.1);">
                    @forelse($communications as $comm)
                        <div class="position-relative mb-4 ps-4">
                            <!-- Timeline dot -->
                            <div class="position-absolute bg-primary rounded-circle" 
                                 style="width: 12px; height: 12px; left: -23px; top: 5px; border: 2px solid #121826;"></div>
                            
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="badge bg-{{ $comm->type == 'call' ? 'success' : ($comm->type == 'email' ? 'warning' : 'info') }} bg-opacity-10 text-{{ $comm->type == 'call' ? 'success' : ($comm->type == 'email' ? 'warning' : 'info') }} mb-2">
                                        <i class="bi bi-{{ $comm->type == 'call' ? 'telephone' : ($comm->type == 'email' ? 'envelope' : 'chat') }} me-1"></i>
                                        {{ ucfirst($comm->type) }}
                                    </span>
                                    <h6 class="text-white mb-1">{{ $comm->user->name ?? 'System' }}</h6>
                                    <p class="text-secondary small mb-0">{{ $comm->message }}</p>
                                </div>
                                <div class="text-end">
                                    <small class="text-secondary">{{ $comm->communicated_at->format('M d, Y h:i A') }}</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-chat-square-text fs-1 text-secondary opacity-50 mb-3 d-block"></i>
                            <h6 class="text-secondary fw-bold">No communication history yet</h6>
                            <p class="text-secondary small">Click 'Log Activity' to add the first record.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Communication Modal -->
<div class="modal fade" id="addCommModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary border-opacity-25 rounded-4 shadow-lg">
            <form action="{{ route('admin.leads.communications.store', $lead->id) }}" method="POST">
                @csrf
                <div class="modal-header border-white border-opacity-5 px-4 py-3">
                    <h5 class="modal-title fw-bold">Log New Activity</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small text-secondary fw-bold">ACTIVITY TYPE</label>
                        <select name="type" class="form-select bg-dark text-white border-white border-opacity-10 py-2" required>
                            <option value="call">Phone Call</option>
                            <option value="email">Email Sent</option>
                            <option value="meeting">Meeting</option>
                            <option value="note">Internal Note</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-secondary fw-bold">MESSAGE / NOTES</label>
                        <textarea name="message" class="form-control bg-dark text-white border-white border-opacity-10 py-2" rows="4" placeholder="What was discussed?" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-white border-opacity-5 p-4">
                    <button type="button" class="btn btn-outline-light px-4 py-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">Save Activity</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
