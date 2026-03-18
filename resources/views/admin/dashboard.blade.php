@extends('admin.layout.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-white fw-bold">Admin Dashboard</h3>
        <a href="{{ route('admin.dashboard.download') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-download me-2"></i> Download Summary
        </a>
    </div>

    {{-- ===================== TOP CARDS ===================== --}}
    <div class="row g-3 mb-3">

        <div class="col-md-3">
            <div class="dashboard-card d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="card-title">Total Leads</h6>
                    <h3 class="fw-bold text-primary">{{ $totalLeads }}</h3>
                </div>
                <div class="card-icon bg-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="card-title">Applications</h6>
                    <h3 class="fw-bold text-success">{{ $totalApplications }}</h3>
                </div>
                <div class="card-icon bg-success">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="card-title">Enrollments</h6>
                    <h3 class="fw-bold text-warning">{{ $totalEnrollments }}</h3>
                </div>
                <div class="card-icon bg-warning">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="card-title">REVENUE</h6>
                    <h3 class="fw-bold text-danger">
                        ₹ {{ number_format($totalPayments, 2) }}
                    </h3>
                </div>
                <div class="card-icon bg-danger">
                    <i class="bi bi-currency-rupee"></i>
                </div>
            </div>
        </div>

    </div>


    {{-- ===================== CHART SECTION ===================== --}}
    <div class="row g-3 mb-3">
        <div class="col-lg-8">
            <div class="dashboard-card p-4 border-Glow">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="text-white mb-1"><i class="fa fa-chart-line text-primary me-2"></i>Applications Trend
                        </h5>
                        <p class="text-white-50 small mb-0">Volume of applications from Jan to current month</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <form action="{{ route('admin.dashboard') }}" method="GET" id="filterForm">
                            <select name="year" class="form-select form-select-sm bg-dark text-white border-0 px-3 py-1"
                                style="border-radius: 8px; font-size: 0.8rem; background-color: rgba(255,255,255,0.05) !important;"
                                onchange="document.getElementById('filterForm').submit()">
                                @foreach ($availableYears as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>Year:
                                        {{ $year }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <div style="position: relative; height: 260px;">
                    <canvas id="applicationsChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="dashboard-card p-4 text-center h-100 border-Glow">
                <h5 class="text-white mb-4"><i class="fa fa-pie-chart text-success me-2"></i>Lead Sources</h5>
                <div style="position: relative; height: 210px;">
                    <canvas id="leadSourceChart"></canvas>
                </div>
            </div>
        </div>
    </div>


    {{-- ===================== TABLE + PERFORMANCE ===================== --}}
    <div class="row g-4">

        <div class="col-lg-7">
            <div class="dashboard-card p-4">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="text-white">Recent Applications</h5>
                    <a href="{{ route('admin.verification.index', ['status' => 'all']) }}"
                        class="text-primary small text-decoration-none">View All</a>
                </div>

                <table class="table table-dark table-borderless align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th>Name</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentApplications as $app)
                            <tr>
                                <td>{{ $app->first_name }} {{ $app->last_name }}</td>
                                <td>{{ $app->course ? $app->course->name : 'N/A' }}</td>
                                <td>
                                    @php
                                        $badgeClass = match (strtolower($app->status)) {
                                            'approved',
                                            'verified',
                                            'selected',
                                            'offer made',
                                            'enrolled'
                                                => 'bg-success',
                                            'pending' => 'bg-warning text-dark',
                                            'rejected' => 'bg-danger',
                                            default => 'bg-primary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($app->status) }}</span>
                                </td>
                                <td>{{ $app->created_at->format('M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No recent applications found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="dashboard-card p-4">
                <h5 class="text-white mb-4">Counselor Performance</h5>

                @foreach ([['name' => 'Riya Verma', 'percent' => 92, 'color' => 'success'], ['name' => 'Amit Joshi', 'percent' => 87, 'color' => 'info'], ['name' => 'Pooja Nair', 'percent' => 79, 'color' => 'warning']] as $counselor)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ $counselor['name'] }}</span>
                            <span class="text-{{ $counselor['color'] }}">
                                {{ $counselor['percent'] }}%
                            </span>
                        </div>
                        <div class="progress bg-dark">
                            <div class="progress-bar bg-{{ $counselor['color'] }}"
                                style="width: {{ $counselor['percent'] }}%">
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Applications Line Chart
            const ctx = document.getElementById("applicationsChart").getContext("2d");
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, "rgba(99, 102, 241, 0.4)");
            gradient.addColorStop(1, "rgba(99, 102, 241, 0)");

            new Chart(ctx, {
                type: "line",
                data: {
                    labels: {!! json_encode($months) !!},
                    datasets: [{
                        label: "Applications",
                        data: {!! json_encode($appData) !!},
                        borderColor: "#6366f1",
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.45,
                        pointBackgroundColor: "#fff",
                        pointBorderColor: "#6366f1",
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: "#6366f1",
                        pointHoverBorderColor: "#fff",
                        pointHoverBorderWidth: 3
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#fff',
                            bodyColor: '#cbd5e1',
                            borderColor: 'rgba(0, 0, 0, 0.1)',
                            borderWidth: 2,
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.parsed.y + ' Applications';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: "rgba(255,255,255,0.8)",
                                font: {
                                    size: 11,
                                    weight: '600'
                                },
                                padding: 10
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: "rgba(255,255,255,0.8)",
                                font: {
                                    size: 11,
                                    weight: '600'
                                },
                                padding: 10,
                                callback: function(value) {
                                    if (value % 1 === 0) return value;
                                }
                            },
                            grid: {
                                color: "rgba(255,255,255,0.03)",
                                drawBorder: false
                            }
                        }
                    }
                }
            });

            // Lead Source Doughnut Chart
            new Chart(document.getElementById("leadSourceChart"), {
                type: "doughnut",
                data: {
                    labels: {!! json_encode($sourceLabels) !!},
                    datasets: [{
                        data: {!! json_encode($sourceCounts) !!},
                        backgroundColor: ["#6366f1", "#10b981", "#f59e0b", "#3b82f6", "#ec4899"],
                        hoverOffset: 12,
                        borderWidth: 0
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: "rgba(255,255,255,0.7)",
                                padding: 15,
                                font: {
                                    size: 11,
                                    weight: '500'
                                },
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            borderColor: 'rgba(255,255,255,0.1)',
                            borderWidth: 1
                        }
                    }
                }
            });

        });
    </script>
@endsection
