@extends('admin.layout.app')

@section('content')
    <style>
        .stat-card {
            background: #0f172a;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        .stat-card-title {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .stat-card-value {
            color: white;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .stat-icon {
            position: absolute;
            top: 24px;
            right: 24px;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .nav-tabs-custom {
            display: flex;
            gap: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1.5rem;
        }

        .nav-tabs-custom a {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            padding-bottom: 0.8rem;
            font-weight: 500;
            position: relative;
        }

        .nav-tabs-custom a.active {
            color: #6366f1;
            font-weight: 600;
        }

        .nav-tabs-custom a.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #6366f1;
        }

        .table-dark-custom {
            background-color: transparent;
            --bs-table-bg: transparent;
        }

        .table-dark-custom thead th {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            padding: 1rem 0;
        }

        .table-dark-custom tbody td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 1.25rem 0;
            color: white;
            vertical-align: middle;
        }

        .course-progress {
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            margin-top: 8px;
            margin-bottom: 4px;
        }

        .course-progress-bar {
            height: 100%;
            border-radius: 10px;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h2 class="text-white mb-2 fw-bold">Merit List & Selection</h2>
            <p class="text-secondary mb-0">Manage automation rules, review rankings, and finalize student selections for the
                current academic session.</p>
        </div>
        <div class="d-flex gap-3">
            <form action="{{ route('admin.merit_list.reset') }}" method="POST"
                onsubmit="return confirm('Are you sure you want to reset the merit list? This will return all shortlisted and selected candidates back to Waitlisted/Verified status.')">
                @csrf
                <button type="submit" class="btn btn-outline-danger d-flex align-items-center gap-2"
                    style="border-radius: 12px; padding: 10px 20px;">
                    <i class="fa fa-undo"></i>
                    <span class="fw-semibold">Reset List</span>
                </button>
            </form>

            <form action="{{ route('admin.merit_list.generate') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-dark d-flex align-items-center gap-2"
                    style="border: 1px solid rgba(255,255,255,0.1); background: #0f172a; border-radius: 12px; padding: 10px 20px;">
                    <i class="fa fa-magic text-white"></i>
                    <span class="text-white fw-semibold">Generate Auto-Merit</span>
                </button>
            </form>

            <a href="{{ route('admin.merit_list.mail_preview') }}" target="_blank"
                class="btn btn-outline-info d-flex align-items-center gap-2"
                style="border-radius: 12px; padding: 10px 20px;">
                <i class="fa fa-envelope text-info"></i>
                <span class="fw-semibold">Preview Email</span>
            </a>

            <form action="{{ route('admin.merit_list.publish') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2"
                    style="background: #2563eb; border: none; border-radius: 12px; padding: 10px 20px;">
                    <i class="fa fa-upload"></i>
                    <span class="fw-semibold">Publish List</span>
                </button>
            </form>
        </div>
    </div>



    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card-title">Total Applicants</div>
                <div class="stat-card-value">{{ number_format($stats['total']) }}</div>
                <div class="text-success mt-2" style="font-size: 0.85rem; font-weight: 600;"><i
                        class="fa fa-arrow-up me-1"></i> Ready for evaluation</div>
                <div class="stat-icon" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
                    <i class="fa fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card-title">Shortlisted</div>
                <div class="stat-card-value">{{ number_format($stats['shortlisted']) }}</div>
                <div class="text-danger mt-2" style="font-size: 0.85rem;">Pending final selection</div>
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fa fa-clipboard-list"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card-title">Selected</div>
                <div class="stat-card-value">{{ number_format($stats['selected']) }}</div>
                <div class="text-success mt-2" style="font-size: 0.85rem;">Offers made</div>
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fa fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card-title">Waitlisted</div>
                <div class="stat-card-value">{{ number_format($stats['verified']) }}</div>
                <div class="text-danger mt-2" style="font-size: 0.85rem;">Verified but not shortlisted</div>
                <div class="stat-icon" style="background: rgba(56, 189, 248, 0.1); color: #38bdf8;">
                    <i class="fa fa-hourglass-half"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row gx-4">
        <!-- Main Table Area -->
        <div class="col-lg-8">
            <div class="dark-card p-4">
                <div class="nav-tabs-custom">
                    <a href="{{ route('admin.merit_list.index', ['status' => 'all']) }}"
                        class="{{ $status == 'all' ? 'active' : '' }}">All Applicants</a>
                    <a href="{{ route('admin.merit_list.index', ['status' => 'shortlisted']) }}"
                        class="{{ $status == 'shortlisted' ? 'active' : '' }}">Shortlisted</a>
                    <a href="{{ route('admin.merit_list.index', ['status' => 'selected']) }}"
                        class="{{ $status == 'selected' ? 'active' : '' }}">Selected</a>
                </div>

                <div class="table-responsive" style="overflow: visible; min-height: 300px;">
                    <table class="table table-dark table-dark-custom table-borderless table-hover w-100 mb-0">
                        <thead>
                            <tr>
                                <th style="width: 40px;"></th>
                                <th>RANK</th>
                                <th>CANDIDATE DETAIL</th>
                                <th>CATEGORY</th>
                                <th>MERIT SCORE (%)</th>
                                <th>STATUS</th>
                                <th class="text-end">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $index => $app)
                                <tr>
                                    <td>
                                        <input class="form-check-input bg-transparent border-secondary" type="checkbox"
                                            style="width: 18px; height: 18px;">
                                    </td>
                                    <td class="fw-bold text-white-50">
                                        #{{ str_pad($applications->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div
                                                style="width: 36px; height: 36px; border-radius: 50%; background: #{{ substr(md5($app->id), 0, 6) }}; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 0.9rem;">
                                                {{ substr($app->user->name ?? $app->first_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-white">
                                                    {{ $app->user->name ?? $app->first_name . ' ' . $app->last_name }}
                                                </div>
                                                <div class="text-white-50" style="font-size: 0.75rem;">
                                                    {{ $app->application_no }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span style="font-size: 0.85rem;">General</span></td>
                                    @php
                                        $calculatedScore =
                                            $app->merit_score > 0
                                                ? $app->merit_score
                                                : ($app->tenth_percentage + $app->twelfth_percentage) / 2;
                                    @endphp
                                    <td class="fw-semibold">{{ number_format($calculatedScore, 2) }} <span
                                            class="text-white-50 fw-normal">%</span></td>
                                    <td>
                                        @if ($app->status == 'verified')
                                            <span class="badge d-inline-flex align-items-center"
                                                style="background: rgba(255, 255, 255, 0.1); color: #fff; border-radius: 6px; padding: 6px 10px;">
                                                <div
                                                    style="width: 6px; height: 6px; border-radius: 50%; background: #fff; margin-right: 5px;">
                                                </div> Pending Review
                                            </span>
                                        @elseif($app->status == 'merit')
                                            <span class="badge d-inline-flex align-items-center"
                                                style="background: rgba(56, 189, 248, 0.1); color: #38bdf8; border-radius: 6px; padding: 6px 10px;">
                                                <div
                                                    style="width: 6px; height: 6px; border-radius: 50%; background: #38bdf8; margin-right: 5px;">
                                                </div> Shortlisted
                                            </span>
                                        @elseif(in_array($app->status, ['offer_made', 'confirmed', 'enrolled']))
                                            <span class="badge d-inline-flex align-items-center"
                                                style="background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 6px; padding: 6px 10px;">
                                                <div
                                                    style="width: 6px; height: 6px; border-radius: 50%; background: #10b981; margin-right: 5px;">
                                                </div> Selected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-link text-white-50 text-decoration-none"
                                                data-bs-toggle="dropdown" data-bs-boundary="window">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark"
                                                style="background: #1e293b; border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;">
                                                @if ($app->status == 'verified')
                                                    <li>
                                                        <form action="{{ route('admin.merit_list.shortlist', $app->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button
                                                                class="dropdown-item d-flex align-items-center gap-2"><i
                                                                    class="fa fa-clipboard-list w-15px"></i> Mark
                                                                Shortlisted</button>
                                                        </form>
                                                    </li>
                                                @endif
                                                @if (in_array($app->status, ['verified', 'merit']))
                                                    <li>
                                                        <form action="{{ route('admin.merit_list.select', $app->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button
                                                                class="dropdown-item d-flex align-items-center gap-2 text-success"><i
                                                                    class="fa fa-check w-15px"></i> Final Select</button>
                                                        </form>
                                                    </li>
                                                @endif
                                                <li><a class="dropdown-item d-flex align-items-center gap-2"
                                                        href="#" onclick="viewProfile({{ $app->id }})"><i
                                                            class="fa fa-eye w-15px"></i> View Profile</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fa fa-clipboard-list fs-1 mb-3"></i>
                                        <h5>No applicants found for the current view.</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-between align-items-center">
                    <div class="text-muted" style="font-size: 0.85rem;">
                        Showing {{ $applications->firstItem() ?? 0 }}-{{ $applications->lastItem() ?? 0 }} of
                        {{ $applications->total() }} applicants
                    </div>
                    <div>
                        {{ $applications->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4">
            <div class="dark-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-white mb-0 fw-bold">Course Intake</h5>
                    <i class="fa fa-redo text-primary" style="cursor: pointer;"></i>
                </div>

                @foreach ($courses as $course)
                    @php
                        $filled = $course->applications_count;
                        $total = $course->total_seats;
                        $percent = $total > 0 ? min(100, ($filled / $total) * 100) : 0;

                        $barColor = '#10b981'; // green
                        $statusText = 'Healthy';
                        $statusColor = '#10b981';

                        if ($percent >= 90) {
                            $barColor = '#ef4444'; // red
                            $statusText = 'Critical';
                            $statusColor = '#ef4444';
                        } elseif ($percent >= 75) {
                            $barColor = '#f59e0b'; // orange
                            $statusText = 'Filling Fast';
                            $statusColor = '#f59e0b';
                        } elseif ($percent == 0) {
                            $barColor = '#3b82f6'; // blue
                            $statusText = 'Admission Open';
                            $statusColor = '#3b82f6';
                        }
                    @endphp
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-end">
                            <h6 class="text-white mb-0">{{ $course->name }}</h6>
                            <span class="text-white-50"
                                style="font-size: 0.85rem;">{{ $filled }}/{{ $total }} Seats</span>
                        </div>
                        <div class="course-progress">
                            <div class="course-progress-bar"
                                style="width: {{ $percent }}%; background: {{ $barColor }};"></div>
                        </div>
                        <div style="font-size: 0.75rem; color: rgba(255,255,255,0.5);">
                            {{ $total - $filled }} seats remaining &middot;
                            @if ($statusText != 'Closed')
                                <a href="{{ route('admin.departments.show', $course->department_id) }}#course-{{ $course->id }}"
                                    style="color: {{ $statusColor }}; text-decoration: none;"
                                    onmouseover="this.style.textDecoration='underline'"
                                    onmouseout="this.style.textDecoration='none'">
                                    {{ $statusText }}
                                </a>
                            @else
                                <span style="color: {{ $statusColor }};">{{ $statusText }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="dark-card p-4">
                <h6 class="text-secondary fw-bold mb-3"
                    style="font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase;">Automation Rules</h6>

                <div class="d-flex align-items-center gap-3 mb-3 p-3"
                    style="border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; background: rgba(255,255,255,0.02);">
                    <i class="fa fa-percentage text-primary ms-1"></i>
                    <span class="text-white fw-medium">Average of 10th & 12th Marks</span>
                </div>

                <div class="d-flex align-items-center gap-3 mb-4 p-3"
                    style="border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; background: rgba(255,255,255,0.02);">
                    <i class="fa fa-check-circle text-warning ms-1"></i>
                    <span class="text-white fw-medium">Minimum {{ $meritThreshold ?? 60 }}% Merit Score required</span>
                </div>

                <a href="{{ route('admin.rules.index') }}" class="btn btn-outline-primary w-100 mb-4"
                    style="border-radius: 10px; font-weight: 600;">Modify Criteria</a>

                <div class="p-3"
                    style="background: rgba(56, 189, 248, 0.05); border-radius: 12px; border-left: 3px solid #38bdf8;">
                    <div class="d-flex align-items-center gap-2 mb-2 text-info">
                        <i class="fa fa-info-circle"></i>
                        <span class="fw-bold" style="font-size: 0.85rem;">QUICK TIP</span>
                    </div>
                    <p class="mb-0 text-white-50" style="font-size: 0.8rem; line-height: 1.5;">Publishing the merit list
                        will send automated SMS/Email notifications to all selected candidates. Ensure seat availability is
                        accurate before finalizing.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="background: #1e293b; color: white; border: 1px solid rgba(255,255,255,0.1);">
                <div class="modal-header border-bottom border-secondary border-opacity-25">
                    <h5 class="modal-title fw-bold">Candidate Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div id="modal-avatar"
                            class="mx-auto rounded-circle d-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px; background: #6366f1; font-size: 2.5rem; font-weight: bold;">
                            A
                        </div>
                        <h4 id="modal-name" class="mb-1 fw-bold">Loading...</h4>
                        <p id="modal-app-id" class="text-white-50 mb-0 font-monospace">--</p>
                    </div>

                    <h6 class="text-secondary fw-bold mb-3"
                        style="font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase;">Academic Information
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="p-3 rounded"
                                style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                                <small class="text-white-50 d-block mb-1">10th Percentage</small>
                                <h5 id="modal-10th" class="mb-0 fw-bold">--%</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded"
                                style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                                <small class="text-white-50 d-block mb-1">12th Percentage</small>
                                <h5 id="modal-12th" class="mb-0 fw-bold">--%</h5>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded text-center position-relative overflow-hidden"
                        style="background: rgba(99, 102, 241, 0.1); border: 1px solid rgba(99, 102, 241, 0.2);">
                        <small class="text-white-50 d-block mb-2 text-uppercase fw-semibold"
                            style="letter-spacing: 1px;">Calculated Merit Score</small>
                        <h2 id="modal-merit" class="text-primary mb-0 fw-bold" style="font-size: 2.5rem;">--%</h2>
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary border-opacity-25 p-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="#" id="modal-view-full" class="btn btn-primary">View Full Application</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewProfile(id) {
            let modal = new bootstrap.Modal(document.getElementById('profileModal'));
            modal.show();

            // Reset modal fields
            document.getElementById('modal-name').innerText = 'Loading...';
            document.getElementById('modal-app-id').innerText = '--';
            document.getElementById('modal-10th').innerText = '--%';
            document.getElementById('modal-12th').innerText = '--%';
            document.getElementById('modal-merit').innerText = '--%';
            document.getElementById('modal-view-full').href =
                `/admin/verification?status=verified&app_id=${id}`; // Link to exact app

            // Fetch application details using existing JSON endpoint
            fetch(`/admin/verification/${id}`)
                .then(res => res.json())
                .then(data => {
                    const app = data.application;
                    const name = app.user ? app.user.name : (app.first_name + ' ' + app.last_name);

                    document.getElementById('modal-name').innerText = name;
                    document.getElementById('modal-avatar').innerText = name.charAt(0).toUpperCase();
                    document.getElementById('modal-app-id').innerText = app.application_no;

                    document.getElementById('modal-10th').innerText = (app.tenth_percentage || '0') + '%';
                    document.getElementById('modal-12th').innerText = (app.twelfth_percentage || '0') + '%';

                    // If merit score is calculated, show it, else calculate preview
                    const meritScore = app.merit_score ?
                        parseFloat(app.merit_score).toFixed(2) :
                        ((parseFloat(app.tenth_percentage || 0) + parseFloat(app.twelfth_percentage || 0)) / 2).toFixed(
                            2);

                    document.getElementById('modal-merit').innerText = meritScore + '%';
                })
                .catch(err => {
                    console.error('Error loading profile:', err);
                    document.getElementById('modal-name').innerText = 'Error loading data';
                });
        }
    </script>
@endsection
