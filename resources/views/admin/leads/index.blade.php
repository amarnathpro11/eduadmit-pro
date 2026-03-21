@extends('admin.layout.app')

@section('content')
    <div class="container-fluid">
        {{-- Header --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h2 class="text-white fw-bold mb-1">Lead Management</h2>
                <p class="text-secondary mb-0">Track, score, and convert prospective students with ease.</p>
            </div>
            <button class="btn btn-primary px-4 py-2 fw-semibold shadow-sm rounded-3" data-bs-toggle="modal"
                data-bs-target="#addLeadModal">
                <i class="bi bi-person-plus-fill me-2"></i> Add New Lead
            </button>
        </div>

        {{-- Stat Cards --}}
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="dark-card p-4 d-flex align-items-center justify-content-between h-100"
                    style="background: #1a1f2e; border: 1px solid rgba(255,255,255,0.05);">
                    <div>
                        <h6 class="text-secondary small text-uppercase fw-bold mb-2">Total Leads</h6>
                        <h3 class="text-white fw-bold mb-0">{{ number_format($stats['total']) }}</h3>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="bi bi-people text-primary fs-4"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dark-card p-4 d-flex align-items-center justify-content-between h-100"
                    style="background: #1a1f2e; border: 1px solid rgba(255,255,255,0.05);">
                    <div>
                        <h6 class="text-secondary small text-uppercase fw-bold mb-2">High Intent</h6>
                        <h3 class="text-warning fw-bold mb-0">{{ number_format($stats['highIntent']) }}</h3>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="bi bi-star text-warning fs-4"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dark-card p-4 d-flex align-items-center justify-content-between h-100"
                    style="background: #1a1f2e; border: 1px solid rgba(255,255,255,0.05);">
                    <div>
                        <h6 class="text-secondary small text-uppercase fw-bold mb-2">Converted</h6>
                        <h3 class="text-success fw-bold mb-0">{{ number_format($stats['converted']) }}</h3>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="bi bi-check-circle text-success fs-4"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dark-card p-4 d-flex align-items-center justify-content-between h-100"
                    style="background: #1a1f2e; border: 1px solid rgba(255,255,255,0.05);">
                    <div>
                        <h6 class="text-secondary small text-uppercase fw-bold mb-2">Lost Leads</h6>
                        <h3 class="text-danger fw-bold mb-0">{{ number_format($stats['lost']) }}</h3>
                    </div>
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                        <i class="bi bi-x-circle text-danger fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="dark-card p-4 mb-4" style="background: rgba(26, 31, 46, 0.6); border: 1px solid rgba(255,255,255,0.05);">
            <form action="{{ route('admin.leads.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label text-secondary small fw-bold">Status</label>
                    <select name="status" class="form-select bg-dark text-white border-secondary border-opacity-25 py-2">
                        <option value="All" {{ request('status') == 'All' ? 'selected' : '' }}>All Status</option>
                        @foreach (['New', 'Interested', 'Converted', 'Lost'] as $st)
                            <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>
                                {{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-secondary small fw-bold">Source</label>
                    <select name="source" class="form-select bg-dark text-white border-secondary border-opacity-25 py-2">
                        <option value="All" {{ request('source') == 'All' ? 'selected' : '' }}>All Sources</option>
                        @foreach (['Website', 'Referral', 'Social Media', 'Facebook Ad', 'Walk-in'] as $src)
                            <option value="{{ $src }}" {{ request('source') == $src ? 'selected' : '' }}>
                                {{ $src }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-secondary small fw-bold">Counselor</label>
                    <select name="assigned_to"
                        class="form-select bg-dark text-white border-secondary border-opacity-25 py-2">
                        <option value="Any" {{ request('assigned_to') == 'Any' ? 'selected' : '' }}>Any Counselor
                        </option>
                        @foreach ($counselors as $counselor)
                            <option value="{{ $counselor->id }}"
                                {{ request('assigned_to') == $counselor->id ? 'selected' : '' }}>
                                {{ $counselor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Apply Filters</button>
                    <a href="{{ route('admin.leads.index') }}"
                        class="btn btn-outline-secondary w-100 py-2 text-white border-opacity-25">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Leads Table --}}
        <div class="dark-card overflow-hidden"
            style="background: #121826; border: 1px solid rgba(255,255,255,0.05); border-radius: 12px;">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead style="background: rgba(255,255,255,0.02);">
                        <tr class="text-secondary small text-uppercase">
                            <th class="px-4 py-3" style="font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.05);">
                                Lead Profile</th>
                            <th class="py-3" style="font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.05);">Source
                                & Counselor</th>
                            <th class="py-3"
                                style="width: 220px; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.05);">Lead
                                Score</th>
                            <th class="py-3" style="font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.05);">
                                Status</th>
                            <th class="px-4 py-3 text-end"
                                style="font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.05);">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="border-top: none;">
                        @forelse($leads as $lead)
                            <tr class="border-bottom border-white border-opacity-5">
                                <td class="px-4 py-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                            style="width: 48px; height: 48px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; font-size: 0.95rem;">
                                            @php
                                                $initials = collect(explode(' ', $lead->name))
                                                    ->map(fn($n) => strtoupper(substr($n, 0, 1)))
                                                    ->take(2)
                                                    ->join('');
                                            @endphp
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <div class="text-white fw-bold fs-6 d-flex align-items-center gap-2">
                                                <a href="{{ route('admin.leads.show', $lead->id) }}" class="text-white text-decoration-none hover-primary">
                                                    {{ $lead->name }}
                                                </a>
                                                @if($lead->is_registered)
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25" style="font-size: 0.6rem;">Registered</span>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column">
                                                <small class="text-secondary opacity-75">{{ $lead->email }} • {{ $lead->phone }}</small>
                                                @if($lead->is_registered)
                                                    <small class="text-{{ $lead->last_login ? 'info' : 'danger' }} x-small mt-1" style="font-size: 0.7rem;">
                                                        <i class="bi bi-clock-history me-1"></i>
                                                        Last Login: {{ $lead->last_login ? \Carbon\Carbon::parse($lead->last_login)->diffForHumans() : 'Never Logged In' }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="badge rounded-pill bg-white bg-opacity-10 text-white mb-2 px-3 py-1"
                                        style="font-size: 0.7rem; font-weight: 600;">{{ $lead->source }}</div>
                                    <div class="text-secondary small d-flex align-items-center gap-1">
                                        <i class="bi bi-person-fill small"></i>
                                        {{ $lead->assignedTo->name ?? 'Unassigned' }}
                                    </div>
                                </td>
                                <td class="py-4 pe-5">
                                    @php
                                        $scoreColor = 'danger';
                                        $scoreLabel = 'Low';
                                        if ($lead->lead_score >= 80) {
                                            $scoreColor = 'success';
                                            $scoreLabel = 'Hot';
                                        } elseif ($lead->lead_score >= 50) {
                                            $scoreColor = 'warning';
                                            $scoreLabel = 'Moderate';
                                        } elseif ($lead->lead_score >= 30) {
                                            $scoreColor = 'primary';
                                            $scoreLabel = 'Priority';
                                        }
                                    @endphp
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="text-{{ $scoreColor }} fw-bold"
                                            style="letter-spacing: 0.5px;">{{ $scoreLabel }}</small>
                                        <small class="text-secondary small fw-bold">{{ $lead->lead_score }}%</small>
                                    </div>
                                    <div class="progress bg-white bg-opacity-5" style="height: 7px; border-radius: 10px;">
                                        <div class="progress-bar bg-{{ $scoreColor }}" role="progressbar"
                                            style="width: {{ $lead->lead_score }}%" aria-valuenow="{{ $lead->lead_score }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    @php
                                        $statusClass = match ($lead->status) {
                                            'New' => 'status-new',
                                            'Interested' => 'status-interested',
                                            'Converted' => 'status-converted',
                                            'Lost' => 'status-lost',
                                            default => 'status-default',
                                        };
                                    @endphp
                                    <span class="status-pill {{ $statusClass }}">
                                        {{ $lead->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="tel:{{ $lead->phone }}" class="action-btn" title="Call">
                                            <i class="bi bi-telephone"></i>
                                        </a>
                                        <a href="mailto:{{ $lead->email }}" class="action-btn" title="Email">
                                            <i class="bi bi-envelope"></i>
                                        </a>
                                        <button class="action-btn" title="Convert">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-5 text-center text-secondary opacity-50">
                                    <i class="bi bi-search fs-1 mb-3 d-block"></i>
                                    <h5>No leads found matching your filters.</h5>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($leads->hasPages())
                <div class="p-4 border-top border-white border-opacity-5">
                    {{ $leads->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Add Lead Modal --}}
    <div class="modal fade" id="addLeadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-white border-secondary border-opacity-25 rounded-4 shadow-lg">
                <form action="{{ route('admin.leads.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-white border-opacity-5 px-4 py-3">
                        <h5 class="modal-title fw-bold">Add New Lead</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6 text-start">
                                <label class="form-label small text-secondary fw-bold">PROSPECT NAME</label>
                                <input type="text" name="name" class="form-control bg-dark text-white border-white border-opacity-10 py-2" placeholder="Ex: John Doe" required>
                            </div>
                            <div class="col-md-6 text-start">
                                <label class="form-label small text-secondary fw-bold">EMAIL ADDRESS</label>
                                <input type="email" name="email" class="form-control bg-dark text-white border-white border-opacity-10 py-2" placeholder="john@example.com">
                            </div>
                            <div class="col-md-6 text-start">
                                <label class="form-label small text-secondary fw-bold">PHONE NUMBER</label>
                                <input type="text" name="phone" class="form-control bg-dark text-white border-white border-opacity-10 py-2" placeholder="+1 (555) 000-0000" required>
                            </div>
                            <div class="col-md-6 text-start">
                                <label class="form-label small text-secondary fw-bold">SOURCE</label>
                                <select name="source" class="form-select bg-dark text-white border-white border-opacity-10 py-2" required>
                                    <option value="Website">Website</option>
                                    <option value="Referral">Referral</option>
                                    <option value="Social Media">Social Media</option>
                                    <option value="Facebook Ad">Facebook Ad</option>
                                    <option value="Walk-in">Walk-in</option>
                                </select>
                            </div>
                            <div class="col-md-6 text-start">
                                <label class="form-label small text-secondary fw-bold">INTERESTED COURSE</label>
                                <select name="course_interested" class="form-select bg-dark text-white border-white border-opacity-10 py-2" required>
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }} ({{ $course->code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 text-start">
                                <label class="form-label small text-secondary fw-bold">ASSIGN TO COUNSELOR</label>
                                <select name="assigned_to" class="form-select bg-dark text-white border-white border-opacity-10 py-2">
                                    <option value="">Unassigned</option>
                                    @foreach($counselors as $counselor)
                                        <option value="{{ $counselor->id }}">{{ $counselor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 text-start">
                                <label class="form-label small text-secondary fw-bold">INITIAL STATUS</label>
                                <select name="status" class="form-select bg-dark text-white border-white border-opacity-10 py-2" required>
                                    <option value="New">New</option>
                                    <option value="Interested">Interested</option>
                                    <option value="Converted">Converted</option>
                                </select>
                            </div>
                            <div class="col-md-6 text-start">
                                <label class="form-label small text-secondary fw-bold">LEAD SCORE (0-100)</label>
                                <input type="number" name="lead_score" class="form-control bg-dark text-white border-white border-opacity-10 py-2" value="20" min="0" max="100" required>
                            </div>
                            <div class="col-12 text-start">
                                <label class="form-label small text-secondary fw-bold">NOTES (OPTIONAL)</label>
                                <textarea name="notes" class="form-control bg-dark text-white border-white border-opacity-10 py-2" rows="3" placeholder="Any extra info counselor adds..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-white border-opacity-5 p-4">
                        <button type="button" class="btn btn-outline-light px-4 py-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">Save Lead Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .dark-card { transition: transform 0.2s; }
        .table-dark { --bs-table-bg: transparent; }
        .table-hover tbody tr:hover { background: rgba(255,255,255,0.02) !important; }
        
        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.3px;
        }
        .status-pill::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .status-new { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        .status-new::before { background: #3b82f6; }
        
        .status-interested { background: rgba(245, 158, 11, 0.1); color: #fbbf24; }
        .status-interested::before { background: #fbbf24; }

        .status-converted { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .status-converted::before { background: #10b981; }

        .status-lost { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .status-lost::before { background: #ef4444; }

        .status-default { background: rgba(100, 116, 139, 0.1); color: #94a3b8; }
        .status-default::before { background: #94a3b8; }

        .action-btn {
            width: 38px;
            height: 38px;
            background: #1a1f2e;
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s;
        }
        .action-btn:hover {
            background: #2563eb;
            color: #fff;
            border-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .pagination { margin: 0; }
        .page-link { background-color: transparent !important; border: 1px solid rgba(255,255,255,0.05) !important; color: #94a3b8 !important; border-radius: 8px !important; margin: 0 3px; }
        .page-item.active .page-link { background-color: #2563eb !important; border-color: #2563eb !important; color: #fff !important; }
        .page-link:hover { background-color: rgba(255,255,255,0.05) !important; color: #fff !important; }
    </style>
@endsection
