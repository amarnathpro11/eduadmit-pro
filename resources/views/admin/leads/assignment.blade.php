@extends('admin.layout.app')

@section('content')
    <style>
        /* Premium Color Palette & Transitions */
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);
            --success-soft: rgba(16, 185, 129, 0.1);
            --warning-soft: rgba(245, 158, 11, 0.1);
            --danger-soft: rgba(239, 68, 68, 0.1);
            --accent-blue: #38bdf8;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .header-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.25rem;
        }

        .header-subtitle {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.95rem;
        }

        /* Stat Cards */
        .stat-card-assignment {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            transition: all 0.3s ease;
        }

        .stat-card-assignment:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-2px);
        }

        .stat-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.5);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
        }

        /* Main Container Grid */
        .assignment-grid {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        /* Section Headers */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
        }

        /* Lead Cards (Left Column) */
        .leads-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            max-height: calc(100vh - 250px);
            overflow-y: auto;
            padding-right: 5px;
        }

        .leads-list::-webkit-scrollbar {
            width: 4px;
        }

        .leads-list::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .lead-card-assignment {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 14px;
            padding: 1.25rem;
            cursor: grab;
            transition: all 0.2s ease;
            position: relative;
        }

        .lead-card-assignment:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .lead-card-assignment:active {
            cursor: grabbing;
        }

        .lead-name {
            font-weight: 700;
            color: #fff;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .lead-source {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .lead-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .lead-tag {
            font-size: 0.7rem;
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.7);
            padding: 2px 8px;
            border-radius: 6px;
            font-weight: 600;
        }

        .lead-priority {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .lead-time {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 1rem;
        }

        /* Counselor Cards (Right Column) */
        .counselors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .counselor-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .counselor-card.drag-over {
            background: rgba(99, 102, 241, 0.1);
            border: 2px dashed #6366f1;
            transform: scale(1.02);
        }

        .counselor-header {
            display: flex;
            gap: 1.25rem;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .counselor-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.25rem;
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .counselor-info h6 {
            margin: 0;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .counselor-status {
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            margin-top: 0.25rem;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .workload-section {
            margin-bottom: 1.5rem;
        }

        .workload-header {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .workload-bar-bg {
            height: 6px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }

        .workload-bar-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 0.5s ease;
        }

        .counselor-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .success-rate {
            display: flex;
            flex-direction: column;
        }

        .success-label {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            font-weight: 700;
        }

        .success-value {
            font-size: 1.25rem;
            font-weight: 800;
            color: #fff;
        }

        .btn-assign-small {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 6px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-assign-small:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Floating Tooltip/Toast */
        .assignment-toast {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: #0f172a;
            color: #fff;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 2000;
            transform: translateY(150%);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .assignment-toast.show {
            transform: translateY(0);
        }

        /* Filters Bar */
        .filters-row {
            background: rgba(255, 255, 255, 0.02);
            padding: 0.75rem 1rem;
            border-radius: 12px;
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .filter-select {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            outline: none;
        }

        .btn-bulk-auto {
            background: #2563eb;
            border: none;
            color: #fff;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
    </style>

    <div class="page-header d-flex justify-content-between align-items-end">
        <div>
            <h2 class="header-title">Lead Assignment & Allocation</h2>
            <p class="header-subtitle">Distribute prospective student leads to specialized counselors based on expertise and
                capacity.</p>
        </div>
        <div class="d-flex gap-3">
            <div class="stat-card-assignment">
                <div class="stat-icon-box" style="background: var(--warning-soft); color: #f59e0b;">
                    <i class="fa fa-user-clock"></i>
                </div>
                <div>
                    <div class="stat-label">Unassigned</div>
                    <div class="stat-value">{{ $stats['unassigned'] }}</div>
                </div>
            </div>
            <div class="stat-card-assignment">
                <div class="stat-icon-box" style="background: var(--success-soft); color: #10b981;">
                    <i class="fa fa-user-check"></i>
                </div>
                <div>
                    <div class="stat-label">Available</div>
                    <div class="stat-value">{{ $stats['available_counselors'] }}</div>
                </div>
            </div>
            <form action="{{ route('admin.leads.auto_assign') }}" method="POST">
                @csrf
                <button type="submit" class="btn-bulk-auto">
                    <i class="fa fa-wand-magic-sparkles"></i>
                    Bulk Auto-Assign
                </button>
            </form>
        </div>
    </div>

    <div class="assignment-grid">
        <!-- Unassigned Leads List -->
        <div class="leads-sidebar">
            <div class="section-header">
                <h5 class="section-title">Unassigned Leads <span class="badge rounded-pill bg-primary ms-2"
                        style="font-size: 0.65rem; background: #6366f1 !important;">{{ count($unassignedLeads) }}
                        TOTAL</span></h5>
                <div class="text-white-50" style="cursor: pointer;">
                    <i class="fa fa-sliders me-3"></i>
                    <i class="fa fa-arrow-down-short-wide"></i>
                </div>
            </div>

            <div class="leads-list">
                @forelse($unassignedLeads as $lead)
                    <div class="lead-card-assignment" draggable="true" data-lead-id="{{ $lead->id }}">
                        @php
                            $priority = $lead->score >= 80 ? 'HOT' : ($lead->score >= 50 ? 'WARM' : 'COLD');
                            $priorityColor =
                                $priority == 'HOT' ? '#ef4444' : ($priority == 'WARM' ? '#f59e0b' : '#3b82f6');
                        @endphp
                        <span class="lead-priority" style="color: {{ $priorityColor }};">{{ $priority }}</span>
                        <div class="lead-name">{{ $lead->name }}</div>
                        <div class="lead-source">
                            @if (stripos($lead->source, 'Website') !== false)
                                <i class="fa fa-globe"></i>
                            @elseif(stripos($lead->source, 'Google') !== false)
                                <i class="fa fa-google"></i>
                            @elseif(stripos($lead->source, 'Referral') !== false)
                                <i class="fa fa-share-nodes"></i>
                            @else
                                <i class="fa fa-bullhorn"></i>
                            @endif
                            {{ $lead->source }}
                        </div>

                        <div class="lead-tags">
                            <span class="lead-tag">{{ $lead->course->code ?? 'N/A' }}</span>
                            @if ($lead->course && $lead->course->department)
                                <span class="lead-tag">{{ $lead->course->department->name }}</span>
                            @endif
                        </div>

                        <div class="lead-time">
                            {{ $lead->created_at->diffForHumans() }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-white-50">
                        <i class="fa fa-check-circle fs-1 mb-3 opacity-25"></i>
                        <p>All leads are currently assigned.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Counselors Area -->
        <div class="counselors-main">
            <div class="section-header">
                <h5 class="section-title">Counselor Availability</h5>
                <div class="d-flex gap-3">
                    <select class="filter-select">
                        <option>All Expertise</option>
                        <option>Engineering</option>
                        <option>Business</option>
                    </select>
                    <select class="filter-select">
                        <option>High Success Rate</option>
                        <option>Most Available</option>
                    </select>
                </div>
            </div>

            <div class="counselors-grid">
                @foreach ($counselors as $counselor)
                    @php
                        $maxWorkload = 20;
                        $currentWorkload = $counselor->leads_count;
                        $workloadPercent = ($currentWorkload / $maxWorkload) * 100;
                        $barColor =
                            $workloadPercent >= 90 ? '#ef4444' : ($workloadPercent >= 70 ? '#f59e0b' : '#6366f1');
                        $isAtCapacity = $currentWorkload >= $maxWorkload;

                        // Mock success rates for design fidelity
                        $successRates = [92, 84, 78, 88, 75, 90];
                        $successRate = $successRates[$loop->index % 6];
                    @endphp
                    <div class="counselor-card" data-counselor-id="{{ $counselor->id }}">
                        <div class="counselor-header">
                            <div class="counselor-avatar">
                                {{ strtoupper(substr($counselor->name, 0, 1)) }}
                            </div>
                            <div class="counselor-info">
                                <h6 style="color: #fff;">{{ $counselor->name }}</h6>
                                <div class="lead-tags mt-1 mb-2">
                                    <span class="lead-tag" style="background: rgba(99, 102, 241, 0.15); color: #818cf8;">
                                        @if ($counselor->department)
                                            {{ $counselor->department->name }}
                                        @else
                                            General
                                        @endif
                                    </span>
                                </div>
                                <div class="counselor-status">
                                    <span class="status-dot"
                                        style="background: {{ $isAtCapacity ? '#f59e0b' : '#10b981' }};"></span>
                                    <span
                                        style="color: {{ $isAtCapacity ? '#f59e0b' : '#10b981' }}; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                        {{ $isAtCapacity ? 'At Capacity' : 'Available' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="workload-section">
                            <div class="workload-header">
                                <span>Current Workload</span>
                                <span class="fw-bold text-white">{{ $currentWorkload }}/{{ $maxWorkload }}</span>
                            </div>
                            <div class="workload-bar-bg">
                                <div class="workload-bar-fill"
                                    style="width: {{ $workloadPercent }}%; background: {{ $barColor }};"></div>
                            </div>
                        </div>

                        <div class="counselor-footer">
                            <div class="success-rate">
                                <span class="success-label">Success Rate</span>
                                <span class="success-value">{{ $successRate }}%</span>
                            </div>
                            @if ($isAtCapacity)
                                <button class="btn-assign-small opacity-50" disabled>Full</button>
                            @else
                                <button class="btn-assign-small" onclick="assignTo('{{ $counselor->id }}')">Assign</button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Drag & Drop Interface Interaction Toast -->
    <div class="assignment-toast" id="assignmentToast">
        <div
            style="background: #10b981; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <i class="fa fa-check" style="font-size: 0.75rem;"></i>
        </div>
        <div>
            <div class="fw-bold" style="font-size: 0.9rem;">Drag to assign</div>
            <div style="font-size: 0.75rem; color: rgba(255,255,255,0.6);">Pick a lead and drop on a counselor card.</div>
        </div>
        <i class="fa fa-xmark ms-auto opacity-50" style="cursor: pointer;"
            onclick="document.getElementById('assignmentToast').classList.remove('show')"></i>
    </div>

    <div class="footer-actions mt-5 p-3 dashboard-card d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex -space-x-2">
                @foreach ($counselors->take(3) as $c)
                    <div class="avatar-placeholder rounded-circle border border-dark"
                        style="width: 32px; height: 32px; background: var(--primary-gradient); display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 800; margin-right: -10px;">
                        {{ substr($c->name, 0, 1) }}</div>
                @endforeach
                <div class="avatar-placeholder rounded-circle border border-dark bg-secondary d-flex align-items-center justify-content-center"
                    style="width: 32px; height: 32px; font-size: 0.7rem; font-weight: 800;">+{{ count($unassignedLeads) }}
                </div>
            </div>
            <span class="text-white-50 small"><strong class="text-white">{{ count($unassignedLeads) }} leads</strong> are
                waiting for assignment.</span>
        </div>
        <div class="d-flex gap-3">
            <button class="btn-bulk-auto" style="background: #2563eb; color: #fff; box-shadow: none; padding: 8px 20px;">
                <i class="fa fa-bolt"></i>
                Smart Match All
            </button>
            <button class="btn btn-outline-light border-0"
                style="background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.7); font-weight: 700; border-radius: 12px; font-size: 0.9rem; padding: 8px 20px;">View
                History</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show initial hint
            setTimeout(() => {
                document.getElementById('assignmentToast').classList.add('show');
            }, 1000);

            const leadCards = document.querySelectorAll('.lead-card-assignment');
            const counselorCards = document.querySelectorAll('.counselor-card');

            let draggedLeadId = null;

            leadCards.forEach(card => {
                card.addEventListener('dragstart', function() {
                    draggedLeadId = this.dataset.leadId;
                    this.style.opacity = '0.4';
                });

                card.addEventListener('dragend', function() {
                    this.style.opacity = '1';
                    counselorCards.forEach(c => c.classList.remove('drag-over'));
                });
            });

            counselorCards.forEach(card => {
                card.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('drag-over');
                });

                card.addEventListener('dragleave', function() {
                    this.classList.remove('drag-over');
                });

                card.addEventListener('drop', function() {
                    const counselorId = this.dataset.counselorId;
                    performAssignment(draggedLeadId, counselorId);
                });
            });

            function performAssignment(leadId, counselorId) {
                fetch('{{ route('admin.leads.assign') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            lead_id: leadId,
                            user_id: counselorId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Quick refresh to update counts
                        }
                    });
            }
        });
    </script>
@endsection
