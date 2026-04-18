@extends('counselor.layout.app')
@section('page_title', 'Counselor Task Dashboard')
@section('page_subtitle', 'Manage leads, tasks, and communications')

@section('content')
    <style>
        .task-dashboard {
            display: flex;
            gap: 24px;
        }

        /* LEFT COLUMN: Tasks */
        .col-tasks {
            flex: 0 0 320px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .task-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .task-title {
            font-weight: 700;
            font-size: 1.05rem;
            margin: 0;
            color: white;
        }

        .task-tabs {
            display: flex;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 4px;
            border: 1px solid var(--border-color);
        }

        .task-tab {
            flex: 1;
            text-align: center;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 8px 0;
            border-radius: 16px;
            cursor: pointer;
            color: var(--text-muted);
            transition: 0.2s;
        }

        .task-tab:hover {
            color: white;
        }

        .task-tab.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 2px 10px rgba(59, 130, 246, 0.3);
        }

        .task-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px;
            position: relative;
            cursor: pointer;
            transition: 0.2s;
            text-decoration: none;
            display: block;
            color: var(--text-main);
        }

        .task-card:hover {
            border-color: rgba(59, 130, 246, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            color: white;
        }

        .task-card.active {
            border: 1px solid var(--primary);
            border-left: 4px solid var(--primary);
            background: rgba(59, 130, 246, 0.05);
            color: white;
        }

        .task-badge {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            text-transform: uppercase;
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .task-card.active .task-badge {
            background: rgba(59, 130, 246, 0.2);
            color: var(--primary);
        }

        .task-time {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .task-name {
            font-weight: 700;
            margin: 10px 0 4px 0;
            font-size: 0.95rem;
            color: white;
        }

        .task-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin: 0 0 8px 0;
        }

        .priority-badge {
            font-size: 0.75rem;
            font-weight: 600;
        }

        .priority-high {
            color: #f87171;
        }

        .priority-medium {
            color: #fbbf24;
        }

        .priority-low {
            color: #34d399;
        }

        /* Scrollbar for dark mode */
        .task-list::-webkit-scrollbar {
            width: 6px;
        }

        .task-list::-webkit-scrollbar-track {
            background: transparent;
        }

        .task-list::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .task-list::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* MIDDLE COLUMN: Details & Timeline */
        .col-middle {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 24px;
            min-width: 0;
        }

        .profile-card {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            padding: 24px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .profile-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
        }

        .profile-avatar {
            width: 64px;
            height: 64px;
            border-radius: 12px;
            object-fit: cover;
            margin-right: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .profile-info h3 {
            margin: 0 0 4px 0;
            font-weight: 700;
            font-size: 1.4rem;
            color: white;
        }

        .profile-info p {
            margin: 0;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .profile-stats {
            display: flex;
            gap: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .profile-stat-box {
            display: flex;
            flex-direction: column;
        }

        .stat-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
            color: white;
        }

        .timeline-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .timeline {
            position: relative;
            padding-left: 20px;
        }

        .timeline::before {
            content: "";
            position: absolute;
            left: 6px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: rgba(255, 255, 255, 0.05);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 24px;
        }

        .timeline-dot {
            position: absolute;
            left: -22px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 3px solid #0f172a;
            background: var(--text-muted);
            z-index: 2;
        }

        .timeline-dot.phone {
            background: var(--primary);
            box-shadow: 0 0 0 1px var(--primary);
            border-color: #0f172a;
        }

        .timeline-dot.email {
            background: #10b981;
            box-shadow: 0 0 0 1px #10b981;
            border-color: #0f172a;
        }

        .timeline-dot.system {
            background: #f59e0b;
            box-shadow: 0 0 0 1px #f59e0b;
            border-color: #0f172a;
        }

        .timeline-dot.whatsapp {
            background: #22c55e;
            box-shadow: 0 0 0 1px #22c55e;
            border-color: #0f172a;
        }

        .timeline-content {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px;
            margin-left: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            transition: 0.2s;
        }

        .timeline-content:hover {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .timeline-title-text {
            font-weight: 700;
            font-size: 0.95rem;
            margin: 0;
            color: white;
        }

        .timeline-time {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .timeline-body {
            font-size: 0.85rem;
            color: #cbd5e1;
            line-height: 1.5;
            font-style: italic;
            background: rgba(0, 0, 0, 0.2);
            padding: 12px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.02);
        }

        /* RIGHT COLUMN: Notes & Actions */
        .col-right {
            flex: 0 0 300px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .top-stats {
            display: flex;
            gap: 12px;
        }

        .top-stat-box {
            flex: 1;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 12px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .top-stat-box h2 {
            color: var(--primary);
            font-weight: 700;
            margin: 5px 0 0 0;
            font-size: 1.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .notes-box {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex: 1;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .notes-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .notes-header h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            color: white;
        }

        .notes-area {
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 16px;
            font-size: 0.9rem;
            min-height: 250px;
            background: rgba(0, 0, 0, 0.2);
            color: white;
            width: 100%;
            outline: none;
            resize: none;
            margin-bottom: 20px;
            transition: 0.2s;
        }

        .notes-area:focus {
            border-color: var(--primary);
            background: rgba(0, 0, 0, 0.4);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .action-btn {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            margin-bottom: 12px;
            border: none;
            font-size: 0.9rem;
            transition: 0.2s;
        }

        .btn-save-note {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
        }

        .btn-save-note:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-schedule {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .btn-schedule:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.4);
        }

        /* MODAL DARK */
        .modal-content {
            background: #0f172a;
            border: 1px solid var(--border-color);
            color: white;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        .hover-opacity-100:hover {
            opacity: 1 !important;
            color: #ef4444 !important;
        }
    </style>


    <div class="task-dashboard">
        <!-- LEFT: TASKS -->
        <div class="col-tasks">
            <div class="task-header mb-2">
                <h4 class="task-title"><i class="fa fa-list-check me-2 text-primary"></i> My Tasks for Today</h4>
            </div>
            <div class="task-tabs mb-2">
                <div class="task-tab active" id="pendingTab">Scheduled ({{ count($todayFollowUps) }})</div>

                <div class="task-tab" id="completedTab">Completed ({{ count($completedFollowUps) }})</div>
            </div>

            <div class="task-list" id="pendingList"
                style="overflow-y: auto; padding-right: 5px; height: calc(100vh - 200px);">
                @forelse($todayFollowUps as $task)
                    <a href="{{ route('counselor.leads.show', $task->lead_id) }}"
                        class="task-card mb-3 {{ $task->lead_id == $lead->id ? 'active' : '' }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="task-badge">
                                {{ $task->priority == 'high' ? 'NEXT CALL' : 'FOLLOW-UP' }}
                            </span>
                            <div class="d-flex align-items-center gap-2">
                                <span class="task-time"><i class="fa fa-clock fw-normal opacity-75"></i>
                                    {{ \Carbon\Carbon::parse($task->scheduled_at)->format('h:i A') }}</span>
                                <form action="{{ route('counselor.leads.followup.complete', $task->id) }}" method="POST"
                                    class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success p-1 px-2 rounded-circle"
                                        title="Mark as Done" onclick="event.stopPropagation();">
                                        <i class="fa fa-check" style="font-size: 0.6rem;"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <h5 class="task-name">{{ $task->lead->name }}</h5>
                        <p class="task-desc">{{ $task->lead->course->name ?? 'Course Inquiry' }}</p>
                        <div class="priority-badge priority-{{ $task->priority }}">
                            <i class="fa fa-circle" style="font-size:6px; vertical-align:middle; margin-right:3px;"></i>
                            {{ ucfirst($task->priority) }} Priority
                        </div>
                    </a>
                @empty
                    <div class="text-center p-4 text-secondary border rounded-3 border-dashed"
                        style="border-color: rgba(255,255,255,0.1) !important;">
                        <i class="fa fa-coffee fs-3 mb-2 opacity-50"></i>
                        <p class="mb-0 text-secondary small fw-bold">No pending tasks for today.</p>
                    </div>
                @endforelse

                @if (count($todayFollowUps) == 0 && $lead)
                    <div class="mt-4 mb-2">
                        <span class="fs-6 fw-bold text-secondary"
                            style="font-size: 0.75rem !important; text-transform: uppercase;">Current Lead</span>
                    </div>
                    <a href="#" class="task-card mb-3 active">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="task-badge">ACTIVE PROFILE</span>
                        </div>
                        <h5 class="task-name">{{ $lead->name }}</h5>
                        <p class="task-desc">{{ $lead->course->name ?? 'General Inquiry' }}</p>
                    </a>
                @endif
            </div>

            <div class="task-list d-none" id="completedList"
                style="overflow-y: auto; padding-right: 5px; height: calc(100vh - 200px);">
                @forelse($completedFollowUps as $task)
                    <a href="{{ route('counselor.leads.show', $task->lead_id) }}"
                        class="task-card mb-3 opacity-75 {{ $task->lead_id == $lead->id ? 'active' : '' }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="task-badge bg-success text-white border-0">COMPLETED</span>
                            <span class="task-time text-success"><i class="fa fa-check-circle me-1"></i> Done</span>
                        </div>
                        <h5 class="task-name text-muted">{{ $task->lead->name }}</h5>
                        <p class="task-desc">{{ $task->lead->course->name ?? 'General Inquiry' }}</p>
                    </a>
                @empty
                    <div class="text-center p-4 text-secondary border rounded-3 border-dashed"
                        style="border-color: rgba(255,255,255,0.1) !important;">
                        <i class="fa fa-check-double fs-3 mb-2 opacity-50"></i>
                        <p class="mb-0 text-secondary small fw-bold">No tasks completed yet today.</p>
                    </div>
                @endforelse
            </div>

        </div>

        <!-- MIDDLE: PROFILE & TIMELINE -->
        <div class="col-middle">
            <div class="profile-card border-0">
                <div class="profile-top">
                    <div class="d-flex w-100">
                        <div class="profile-avatar text-white d-flex align-items-center justify-content-center fw-bold"
                            style="font-size: 2rem; background: linear-gradient(135deg, var(--primary), #1d4ed8);">
                            {{ substr($lead->name, 0, 1) }}
                        </div>
                        <div style="flex: 1;">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="d-flex align-items-center gap-3">
                                    <h3 class="mb-0">{{ $lead->name }}</h3>
                                    @if ($lead->lead_score >= 80)
                                        <span
                                            class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1"
                                            style="font-size: 0.75rem;" title="High Intent Lead">
                                            <i class="fa fa-fire me-1"></i> HOT
                                        </span>
                                    @endif
                                </div>
                                <span
                                    class="badge bg-{{ $lead->status == 'Converted' ? 'success' : ($lead->status == 'Lost' ? 'secondary' : 'warning') }} text-{{ $lead->status == 'Converted' ? 'success' : ($lead->status == 'Lost' ? 'secondary' : 'warning') }} bg-opacity-10 border border-{{ $lead->status == 'Converted' ? 'success' : ($lead->status == 'Lost' ? 'secondary' : 'warning') }} border-opacity-25 px-2 py-1"><i
                                        class="fa fa-circle me-1" style="font-size: 6px; vertical-align: middle;"></i>
                                    {{ strtoupper($lead->status) }}</span>
                            </div>
                            <div class="d-flex gap-3 align-items-center mt-2" style="flex-wrap: wrap;">
                                <a href="{{ route('counselor.leads.email', $lead->id) }}"
                                    class="badge bg-dark border border-secondary border-opacity-25 text-white text-decoration-none py-2 px-3 fw-normal"
                                    title="Send System Email to Lead">
                                    <i class="fa fa-paper-plane text-primary me-2"></i> {{ $lead->email }}
                                </a>
                                <a href="{{ route('counselor.leads.preview_email', $lead->id) }}" target="_blank"
                                    class="badge bg-dark border border-secondary border-opacity-25 text-white text-decoration-none py-2 px-3 fw-normal"
                                    title="Preview Email Template">
                                    <i class="fa fa-eye text-primary"></i>
                                </a>

                                <a href="tel:{{ $lead->phone }}"
                                    class="badge bg-dark border border-secondary border-opacity-25 text-white text-decoration-none py-2 px-3 fw-normal"
                                    title="Call Contact">
                                    <i class="fa fa-phone text-primary me-2"></i> {{ $lead->phone }}
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" target="_blank"
                                    class="badge bg-success bg-opacity-10 border border-success border-opacity-25 text-success text-decoration-none py-2 px-3 fw-normal"
                                    title="Message on WhatsApp">
                                    <i class="fa fa-whatsapp me-1"></i> WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-stats">
                    <div class="profile-stat-box">
                        <span class="stat-label">Course Interest</span>
                        <span class="stat-value"><span
                                class="badge bg-dark border border-secondary border-opacity-25 text-white p-1 px-2 fw-bold"
                                style="font-size: 0.8rem;">{{ $lead->course->name ?? 'N/A' }}</span></span>
                    </div>
                    <div class="profile-stat-box">
                        <span class="stat-label">Source System</span>
                        <span class="stat-value text-secondary fw-normal"><i class="fa fa-link me-2"></i>
                            {{ $lead->source }}</span>
                    </div>
                    <div class="profile-stat-box flex-grow-1">
                        <span class="stat-label">Lead Engagement Score</span>
                        <div class="d-flex align-items-center gap-3">
                            <div class="progress flex-grow-1" style="height: 6px; background: rgba(255,255,255,0.05);">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-{{ $lead->lead_score > 75 ? 'danger' : ($lead->lead_score > 40 ? 'primary' : 'secondary') }}"
                                    style="width: {{ $lead->lead_score }}%; box-shadow: 0 0 10px {{ $lead->lead_score > 75 ? 'rgba(239, 68, 68, 0.4)' : 'rgba(59, 130, 246, 0.4)' }};">
                                </div>
                            </div>
                            <span class="text-white fw-bold" style="font-size: 1rem;">{{ $lead->lead_score }}%</span>
                        </div>
                        <div class="stat-value text-warning fs-5 align-items-center d-flex gap-2 mt-2">
                            <div style="font-size: 0.9rem;">
                                @for ($i = 0; $i < 5; $i++)
                                    <i
                                        class="fa fa-star {{ $i < round($lead->lead_score / 20) ? '' : 'text-secondary opacity-25' }}"></i>
                                @endfor
                            </div>
                            <a href="{{ route('counselor.leads.history', $lead->id) }}"
                                class="btn btn-sm btn-dark border border-secondary text-primary ms-auto fw-bold"
                                style="font-size: 0.7rem;"><i class="fa fa-list me-1"></i> Engagement Logs</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="timeline-container mt-2">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="timeline-title mb-0"><i class="fa fa-history text-muted me-2"></i> Communication History
                    </h6>

                    <!-- Activity Filters -->
                    <div class="d-flex gap-2" id="activityFilters">
                        <button class="badge bg-primary border-0 px-3 py-2 filter-btn active"
                            data-filter="all">All</button>
                        <button class="badge bg-dark border border-secondary border-opacity-25 px-3 py-2 filter-btn"
                            data-filter="phone">Calls</button>
                        <button class="badge bg-dark border border-secondary border-opacity-25 px-3 py-2 filter-btn"
                            data-filter="email">Emails</button>
                        <button class="badge bg-dark border border-secondary border-opacity-25 px-3 py-2 filter-btn"
                            data-filter="whatsapp">WhatsApp</button>
                    </div>
                </div>

                <div class="timeline">


                    @forelse($communications as $comm)
                        @php
                            // Determine visual style based on type
                            $typeClass = 'phone';
                            $icon = 'fa-phone';
                            if (stripos($comm->type, 'email') !== false) {
                                $typeClass = 'email';
                                $icon = 'fa-envelope';
                            }
                            if (stripos($comm->type, 'system') !== false || stripos($comm->type, 'note') !== false) {
                                $typeClass = 'system';
                                $icon = 'fa-sticky-note';
                            }
                            if (stripos($comm->type, 'whatsapp') !== false) {
                                $typeClass = 'whatsapp';
                                $icon = 'fa-whatsapp';
                            }
                        @endphp
                        <div class="timeline-item">
                            <div class="timeline-dot {{ $typeClass }} text-white d-flex align-items-center justify-content-center"
                                style="width:24px; height:24px; left: -27px; font-size: 0.7rem; top: 0;">
                                <i class="fa {{ $icon }}"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <h4 class="timeline-title-text">{{ $comm->type }}</h4>
                                    <span class="timeline-time"><i class="fa fa-clock opacity-50 me-1"></i>
                                        {{ $comm->communicated_at->isToday() ? 'Today at ' . $comm->communicated_at->format('h:i A') : $comm->communicated_at->format('M d, Y h:i A') }}</span>
                                </div>
                                <div class="timeline-body">
                                    "{{ $comm->message }}"
                                </div>
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <small class="text-muted fw-semibold"
                                        style="font-size: 0.7rem; text-transform: uppercase; color: #000000 !important;">COUNSELOR:
                                        <span class="text-white">{{ $comm->user->name ?? 'System' }}</span></small>
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="{{ route('counselor.leads.communications.destroy', $comm->id) }}"
                                            method="POST" onsubmit="return confirm('Delete this log permanently?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-link p-0 text-secondary text-decoration-none opacity-50 hover-opacity-100"
                                                style="font-size: 0.8rem;" title="Delete Log">
                                                <i class="fa fa-trash-can"></i>
                                            </button>
                                        </form>
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25"
                                            style="font-size: 0.7rem;"><i class="fa fa-check"></i> Logged</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-secondary fst-italic small">No interactions logged yet. Break the ice!</div>
                    @endforelse

                    <!-- System initial entry hook for UI aesthetic -->
                    <div class="timeline-item mt-4">
                        <div class="timeline-dot system text-white d-flex align-items-center justify-content-center"
                            style="width:24px; height:24px; left: -27px; font-size: 0.7rem; top: 0;"><i
                                class="fa fa-bolt"></i></div>
                        <div class="timeline-content" style="background: rgba(255,255,255,0.01); opacity: 0.6;">
                            <div class="timeline-header">
                                <h4 class="timeline-title-text text-white">Initial Inquiry Received</h4>
                                <span class="timeline-time">{{ $lead->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            <div class="text-secondary small mt-2">
                                <div><strong style="color: #000000 !important;">Source:</strong> {{ $lead->source }}</div>
                                @if ($lead->notes)
                                    <div
                                        class="mt-2 p-2 rounded bg-dark bg-opacity-25 border border-secondary border-opacity-10 text-white">
                                        <em>"{{ $lead->notes }}"</em>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- RIGHT: NOTES & STATUS UPDATE -->
        <div class="col-right">
            <div class="top-stats">
                <div class="top-stat-box border-0">
                    <div class="stat-label mb-1">TOTAL NOTES</div>
                    <h2 class="text-primary">{{ count($communications) }}</h2>
                </div>
                <div class="top-stat-box border-0">
                    <div class="stat-label mb-1">CONVERSION</div>
                    <h2 class="text-white">{{ $lead->status == 'Converted' ? '100%' : '0%' }}</h2>
                </div>
            </div>

            <div class="notes-box border-0">
                <div class="notes-header">
                    <h5><i class="fa fa-pen-nib me-2 text-primary"></i> Counseling Notes</h5>
                    <span class="text-success small fw-bold"><i class="fa fa-circle text-success"
                            style="font-size: 0.5rem; vertical-align: middle; animation: pulse 2s infinite;"></i>
                        Live</span>
                </div>

                <form action="{{ route('counselor.leads.communications.store', $lead->id) }}" method="POST">
                    @csrf
                    <textarea name="message" class="notes-area" placeholder="Type your interaction notes here" required></textarea>

                    <div class="mb-3">
                        <label class="stat-label">INTERACTION TYPE</label>
                        <select class="form-select bg-dark border-0 fw-semibold text-white shadow-sm"
                            style="font-size: 0.9rem; border-color: rgba(255,255,255,0.1) !important;" name="type"
                            required>
                            <option value="Phone Call">Phone Call</option>
                            <option value="WhatsApp Message">WhatsApp Message</option>
                            <option value="Email Sent">Email Sent</option>
                            <option value="In-Person Info">In-Person Info</option>
                            <option value="Internal Note">Internal Note</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="stat-label">UPDATE LEAD STATUS</label>
                        <select class="form-select bg-dark border-0 fw-semibold text-white shadow-sm"
                            style="font-size: 0.9rem; border-color: rgba(255,255,255,0.1) !important;"
                            name="status_update">

                            <option value="">-- Don't change status --</option>
                            @foreach (['New', 'Interacted', 'Interested', 'Lost', 'Converted'] as $st)
                                <option value="{{ $st }}" {{ $lead->status == $st ? 'selected' : '' }}>
                                    {{ $st }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="action-btn btn-save-note"><i class="fa fa-save me-2"></i> Save Note &
                        Next Task</button>
                </form>

                <button type="button" class="action-btn btn-schedule shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#followupModal"><i class="fa fa-calendar-plus me-2"></i> Schedule Follow-up</button>

                @if ($lead->status != 'Converted')
                    <form action="{{ route('counselor.leads.convert', $lead->id) }}" method="POST"
                        class="mt-auto pt-4 border-top" style="border-color: rgba(255,255,255,0.1) !important;">
                        @csrf
                        <button type="submit" class="action-btn m-0 shadow"
                            style="background: linear-gradient(135deg, #16a34a, #22c55e); color:white; border:none;"><i
                                class="fa fa-wand-magic-sparkles me-2"></i> Convert to Applicant</button>
                    </form>
                @else
                    <form action="{{ route('counselor.leads.resend_welcome', $lead->id) }}" method="POST"
                        class="mt-auto pt-4 border-top" style="border-color: rgba(255,255,255,0.1) !important;">
                        @csrf
                        <button type="submit" class="action-btn m-0 shadow"
                            style="background: rgba(255,255,255,0.1); color:#34d399; border:1px solid rgba(52, 211, 153, 0.2);"><i
                                class="fa fa-paper-plane me-2"></i> Resend Welcome Email</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Hidden form for status updates -->
    <form id="statusForm" action="{{ route('counselor.leads.status.update', $lead->id) }}" method="POST"
        style="display:none;">
        @csrf @method('PATCH')
        <input type="hidden" name="status" id="statusHiddenInput">
    </form>


    <!-- Modal -->
    <div class="modal fade" id="followupModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <form action="{{ route('counselor.leads.followup.store', $lead->id) }}" method="POST">
                    @csrf
                    <div class="modal-header border-bottom border-secondary border-opacity-25 pb-3">
                        <h5 class="modal-title fw-bold text-white"><i class="fa fa-clock text-primary me-2"></i> Schedule
                            Follow-up</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Date & Time</label>
                            <input type="datetime-local" name="scheduled_at" class="form-control" required
                                style="color-scheme: dark;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Priority Level</label>
                            <select name="priority" class="form-select">
                                <option value="high">High Priority</option>
                                <option value="medium" selected>Medium Priority</option>
                                <option value="low">Low Priority</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label text-muted small fw-bold text-uppercase">Reminder Note</label>
                            <input type="text" name="note" class="form-control" placeholder="Optional context">
                        </div>
                    </div>
                    <div class="modal-footer border-top border-secondary border-opacity-25 pt-3">
                        <button type="button" class="btn btn-dark text-white fw-bold"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary fw-bold rounded-3 px-4">Schedule Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Sidebar Task Tabs (Pending/Completed)
            const pendingTab = document.getElementById('pendingTab');
            const completedTab = document.getElementById('completedTab');
            const pendingList = document.getElementById('pendingList');
            const completedList = document.getElementById('completedList');

            if (pendingTab && completedTab) {
                pendingTab.addEventListener('click', () => {
                    pendingTab.classList.add('active');
                    completedTab.classList.remove('active');
                    pendingList.classList.remove('d-none');
                    completedList.classList.add('d-none');
                });

                completedTab.addEventListener('click', () => {
                    completedTab.classList.add('active');
                    pendingTab.classList.remove('active');
                    completedList.classList.remove('d-none');
                    pendingList.classList.add('d-none');
                });
            }


            // 2. Timeline Activity Filters
            const filterBtns = document.querySelectorAll('.filter-btn');
            const timelineItems = document.querySelectorAll('.timeline-item');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // UI Update
                    filterBtns.forEach(b => {
                        b.classList.remove('active', 'bg-primary');
                        b.classList.add('bg-dark');
                    });
                    btn.classList.add('active', 'bg-primary');
                    btn.classList.remove('bg-dark');

                    const filter = btn.getAttribute('data-filter');

                    timelineItems.forEach(item => {
                        const dot = item.querySelector('.timeline-dot');
                        if (!dot)
                            return; // Skip initial inquiry item if needed or handle it

                        if (filter === 'all') {
                            item.style.display = 'block';
                        } else {
                            if (dot.classList.contains(filter)) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        }
                    });
                });
            });
        });
    </script>
@endsection
