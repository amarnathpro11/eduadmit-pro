@extends('admin.layout.app')

@section('content')

<div class="container-fluid">

    <h2 class="text-white mb-4">Rules & Role Configuration</h2>

    <!-- QUOTA SECTION -->
    <div class="dark-card p-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-white">Admission Rules & Quota Management</h5>

        <button class="btn btn-primary btn-sm">
            + Add Quota Category
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-dark align-middle mb-0">

            <thead>
                <tr class="text-secondary">
                    <th>Name</th>
                    <th>Code</th>
                    <th>Percentage</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($quotaCategories as $quota)
                <tr>
                    <td class="fw-semibold text-white">
                        {{ $quota->name }}
                    </td>

                    <td>
                        <span class="badge bg-secondary">
                            {{ $quota->code }}
                        </span>
                    </td>

                    <td>
                        {{ number_format($quota->percentage,2) }}%
                    </td>

                    <td>
                        <span class="badge 
                            {{ $quota->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $quota->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    <td class="text-end">
                        <button class="btn btn-outline-info btn-sm px-3 rounded-pill">
                            Edit
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div><div class="dark-card p-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-white">Admission Rules & Quota Management</h5>

        <button class="btn btn-primary btn-sm">
            + Add Quota Category
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-dark align-middle mb-0">

            <thead>
                <tr class="text-secondary">
                    <th>Name</th>
                    <th>Code</th>
                    <th>Percentage</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($quotaCategories as $quota)
                <tr>
                    <td class="fw-semibold text-white">
                        {{ $quota->name }}
                    </td>

                    <td>
                        <span class="badge bg-secondary">
                            {{ $quota->code }}
                        </span>
                    </td>

                    <td>
                        {{ number_format($quota->percentage,2) }}%
                    </td>

                    <td>
                        <span class="badge 
                            {{ $quota->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $quota->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    <td class="text-end">
                        <button class="btn btn-outline-info btn-sm px-3 rounded-pill">
                            Edit
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>

    <!-- COURSE CAPACITY -->
    <div class="dark-card p-4 mb-4">
        <h5 class="text-white mb-3">Course Intake Capacities</h5>

        <div class="table-responsive">
            <table class="table table-dark table-borderless align-middle">
                <thead>
                    <tr class="text-secondary">
                        <th>Course</th>
                        <th>Total Seats</th>
                        <th>Reserved</th>
                        <th>General Available</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($courses as $course)
                    @php
                        $reserved = $course->quotas->sum('reserved_seats');
                    @endphp
                    <tr>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->total_seats }}</td>
                        <td>{{ $reserved }}</td>
                        <td>{{ $course->total_seats - $reserved }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ROLES -->
    <div class="row g-4">
        @foreach($roles as $role)
        <div class="col-md-4">
            <div class="dark-card p-4">
                <h5 class="text-white">{{ $role->name }}</h5>

                @foreach($role->permissions as $permission)
                    <div class="d-flex justify-content-between mt-2">
                        <span class="text-secondary">
                            {{ $permission->name }}
                        </span>
                        <span class="badge bg-success">
                            Enabled
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

</div>

@endsection