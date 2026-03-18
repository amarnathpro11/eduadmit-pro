@extends('admin.layout.app')

@section('content')
    <div class="container-fluid">

        <h2 class="text-white mb-4">Reports & Audit Logs</h2>

        <!-- REPORT GENERATOR -->
        <div class="dark-card p-4 mb-4">

            <h5 class="text-white mb-3">Report Generator</h5>

            <form class="row g-3" action="{{ route('admin.reports.generate') }}" method="GET" target="_blank">

                <div class="col-md-3">
                    <label class="text-secondary small">Report Type</label>
                    <select name="report_type" class="form-control dark-input">
                        <option value="Conversion Report">Conversion Report</option>
                        <option value="Admissions Report">Admissions Report</option>
                        <option value="Revenue Report">Revenue Report</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="text-secondary small">Date Range</label>
                    <div class="d-flex gap-2">
                        <input type="date" name="start_date" class="form-control dark-input">
                        <input type="date" name="end_date" class="form-control dark-input">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="text-secondary small">Department</label>
                    <select name="department" class="form-control dark-input">
                        <option value="all">All Departments</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-play me-2"></i> Generate
                    </button>
                </div>

            </form>

        </div>


        <!-- AUDIT LOG TABLE -->
        <div class="dark-card p-4 mb-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-white mb-0">System Audit Log</h5>
                <div class="btn-group">
                    <a href="{{ route('admin.reports.export.excel', request()->all()) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Excel
                    </a>
                    <a href="{{ route('admin.reports.export.pdf', request()->all()) }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-dark align-middle">

                    <thead>
                        <tr class="text-secondary small">
                            <th>Timestamp</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Resource</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td class="text-nowrap" style="font-size: 0.85rem; color: #a1a1aa;">
                                    {{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Kolkata')->format('d M Y, h:i A') }}
                                </td>

                                <td>
                                    <div class="d-flex flex-column align-items-start">
                                        <span class="fw-bold text-white mb-1">{{ $log->user->name ?? 'System User' }}</span>
                                        @if (isset($log->user) && $log->user->role)
                                            <span
                                                class="badge {{ $log->user->role->name === 'admin' ? 'bg-primary' : 'bg-info' }} bg-opacity-10 text-{{ $log->user->role->name === 'admin' ? 'primary' : 'info' }} p-1 text-uppercase"
                                                style="font-size: 0.65rem;">
                                                <i
                                                    class="fas fa-{{ $log->user->role->name === 'admin' ? 'shield-alt' : 'user-graduate' }} me-1 d-none"></i>{{ $log->user->role->name }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td>{{ $log->action }}</td>

                                <td>{{ $log->resource }}</td>

                                <td>
                                    <span
                                        class="badge 
                            {{ $log->status == 'success' ? 'bg-success' : ($log->status == 'failed' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            {{ $logs->links() }}

        </div>


        <!-- STATS -->
        <div class="row g-4">

            <div class="col-md-3">
                <div class="dark-card p-3 text-center">
                    <small class="text-secondary">Reports Generated</small>
                    <h4 class="text-white">{{ $reportsCount }}</h4>
                </div>
            </div>

            <div class="col-md-3">
                <div class="dark-card p-3 text-center">
                    <small class="text-secondary">Failed Attempts</small>
                    <h4 class="text-danger">{{ $failedAttempts }}</h4>
                </div>
            </div>

            <div class="col-md-3">
                <div class="dark-card p-3 text-center">
                    <small class="text-secondary">Active Admins</small>
                    <h4 class="text-info">{{ $activeAdmins }}</h4>
                </div>
            </div>

            <div class="col-md-3">
                <div class="dark-card p-3 text-center">
                    <small class="text-secondary">Storage Usage</small>
                    <h4 class="text-warning">{{ $storageUsage }}</h4>
                </div>
            </div>

        </div>

    </div>
@endsection
