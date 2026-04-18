@extends('counselor.layout.app')
@section('page_title', 'Communication History')
@section('page_subtitle', 'Detailed Activity Log for ' . $lead->name)

@section('content')
    <div class="row g-4">
        <!-- Header Summary Card -->
        <div class="col-12">
            <div class="white-card d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-4">
                    <div class="text-white d-flex align-items-center justify-content-center fw-bold rounded-3 shadow"
                        style="width: 72px; height: 72px; font-size: 2rem; background: linear-gradient(135deg, var(--primary), #1d4ed8);">
                        {{ substr($lead->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1 text-white">{{ $lead->name }} <span
                                class="badge bg-{{ $lead->status == 'Converted' ? 'success' : 'warning' }} text-{{ $lead->status == 'Converted' ? 'success' : 'warning' }} bg-opacity-10 border border-{{ $lead->status == 'Converted' ? 'success' : 'warning' }} border-opacity-25 py-1 px-2 ms-2 fs-6"
                                style="vertical-align: middle;">{{ strtoupper($lead->status) }}</span></h3>
                        <p class="text-muted mb-0"><i class="fa fa-envelope opacity-75"></i> {{ $lead->email }}
                            &nbsp;|&nbsp; <i class="fa fa-phone opacity-75"></i> {{ $lead->phone }}</p>
                    </div>
                </div>

                <div class="d-flex gap-4 border-start border-secondary border-opacity-25 ps-4 py-2">
                    <div>
                        <span class="d-block text-white small fw-bold text-uppercase letter-spacing-1">Total
                            Interactions</span>
                        <h4 class="text-white fw-bold mb-0">{{ $stats['total'] }}</h4>
                    </div>
                    <div>
                        <span class="d-block text-white small fw-bold text-uppercase letter-spacing-1">Assigned To</span>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=fff"
                                style="width:24px; height:24px; border-radius:50%;">
                            <span class="text-white" style="font-size: 0.9rem;">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="d-block text-white small fw-bold text-uppercase letter-spacing-1">Lead Score</span>
                        <div class="text-warning fs-5 mt-1">
                            @for ($i = 0; $i < 5; $i++)
                                <i
                                    class="fa fa-star {{ $i < round($lead->lead_score / 20) ? '' : 'text-white opacity-25' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <div class="ms-3">
                        <a href="{{ route('counselor.leads.show', $lead->id) }}"
                            class="btn btn-dark border border-secondary border-opacity-50"><i
                                class="fa fa-arrow-left me-2"></i> Back to Tasks</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Left Bar -->
        <div class="col-lg-3">
            <div class="white-card p-0 overflow-hidden">
                <h6 class="text-white text-uppercase fw-bold px-4 pt-4 pb-2 mb-0"
                    style="font-size: 0.75rem; letter-spacing: 1px;">Filter Activities</h6>
                <div class="list-group list-group-flush border-0">
                    <a href="#"
                        class="list-group-item list-group-item-action bg-transparent text-white border-0 py-3 px-4 d-flex justify-content-between align-items-center"
                        style="background: rgba(59,130,246,0.1) !important; border-left: 3px solid var(--primary) !important;">
                        <span><i class="fa fa-bars text-white fw-normal me-2 w-20px"></i> All Activity</span>
                        <span class="badge bg-primary bg-opacity-20 text-primary rounded-pill">{{ $stats['total'] }}</span>
                    </a>
                    <a href="#"
                        class="list-group-item list-group-item-action bg-transparent text-white border-0 py-3 px-4 d-flex justify-content-between align-items-center opacity-75">
                        <span><i class="fa fa-phone fw-normal me-2 w-20px"></i> Calls</span>
                        <span
                            class="badge bg-dark border border-secondary rounded-pill text-muted">{{ $stats['calls'] }}</span>
                    </a>
                    <a href="#"
                        class="list-group-item list-group-item-action bg-transparent text-white border-0 py-3 px-4 d-flex justify-content-between align-items-center opacity-75">
                        <span><i class="fa fa-envelope fw-normal me-2 w-20px"></i> Emails</span>
                        <span
                            class="badge bg-dark border border-secondary rounded-pill text-muted">{{ $stats['emails'] }}</span>
                    </a>
                    <a href="#"
                        class="list-group-item list-group-item-action bg-transparent text-white border-0 py-3 px-4 d-flex justify-content-between align-items-center opacity-75 mb-2">
                        <span><i class="fa fa-whatsapp fw-normal me-2 w-20px"></i> WhatsApp</span>
                        <span class="badge bg-dark border border-secondary rounded-pill text-muted">0</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Timeline Stream -->
        <div class="col-lg-9">
            <div class="position-relative ps-4" style="border-left: 2px solid rgba(255,255,255,0.05);">
                @forelse($communications as $comm)
                    @php
                        $typeClass = 'phone';
                        $icon = 'fa-phone';
                        $color = '#3b82f6';
                        if (stripos($comm->type, 'email') !== false) {
                            $typeClass = 'email';
                            $icon = 'fa-envelope';
                            $color = '#10b981';
                        }
                        if (stripos($comm->type, 'system') !== false || stripos($comm->type, 'note') !== false) {
                            $typeClass = 'system';
                            $icon = 'fa-sticky-note';
                            $color = '#f59e0b';
                        }
                        if (stripos($comm->type, 'whatsapp') !== false) {
                            $typeClass = 'whatsapp';
                            $icon = 'fa-whatsapp';
                            $color = '#22c55e';
                        }
                    @endphp
                    <div class="mb-4 position-relative">
                        <!-- Icon Pin -->
                        <div class="position-absolute d-flex align-items-center justify-content-center text-white rounded-circle shadow"
                            style="width: 32px; height: 32px; background: {{ $color }}; left: -42px; top: 0; box-shadow: 0 0 0 4px #0f172a;">
                            <i class="fa {{ $icon }} fs-6"></i>
                        </div>

                        <!-- Post Card -->
                        <div class="white-card p-4 transition" style="transition: 0.2s;">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold text-white mb-1">{{ $comm->type }}</h5>
                                    <p class="text-muted small mb-0"><i class="fa fa-calendar-alt opacity-50 me-1"></i>
                                        {{ $comm->communicated_at->format('M d, Y') }} at
                                        {{ $comm->communicated_at->format('h:i A') }}</p>
                                </div>
                                <span class="badge bg-dark border border-secondary text-white text-uppercase"
                                    style="letter-spacing: 1px;"><i class="fa fa-user me-1 text-primary"></i>
                                    {{ $comm->user->name ?? 'System' }}</span>
                            </div>

                            <div class="p-3 rounded-3"
                                style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.02); color: #e2e8f0; font-size: 0.95rem; line-height: 1.6;">
                                "{{ $comm->message }}"
                            </div>

                            <div class="d-flex gap-3 mt-3 pt-3 border-top border-secondary border-opacity-25">
                                <button class="btn btn-sm btn-link text-decoration-none text-muted p-0"><i
                                        class="fa fa-play-circle me-1"></i> Listen Recording</button>
                                <button class="btn btn-sm btn-link text-decoration-none text-muted p-0"><i
                                        class="fa fa-plus me-1"></i> Add Internal Note</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fa fa-wind fs-1 text-muted opacity-25 mb-3 d-block"></i>
                        <h5 class="text-muted fw-bold">No interactions recorded yet.</h5>
                    </div>
                @endforelse

                <!-- Initial State -->
                <div class="mb-4 position-relative opacity-75">
                    <div class="position-absolute d-flex align-items-center justify-content-center text-secondary rounded-circle"
                        style="width: 32px; height: 32px; background: rgba(255,255,255,0.1); left: -42px; top: 0; box-shadow: 0 0 0 4px #0f172a;">
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="white-card p-3" style="background: rgba(255,255,255,0.01);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold text-white mb-0">Initial Inquiry Received</h6>
                                <small class="text-white">Source: {{ $lead->source }}</small>
                            </div>
                            <span class="text-white small">{{ $lead->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>
                </div>

                @if ($communications->hasPages())
                    <div class="mt-4 text-center">
                        <button
                            class="btn btn-dark border border-secondary border-opacity-50 text-white rounded-pill px-4"><i
                                class="fa fa-redo me-2"></i> Load Previous Interactions</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
