@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="text-white fw-bold">Admission Rules & Quota Management</h2>
            <button class="btn btn-primary" onclick="showAddQuotaModal()">
                <i class="fa fa-plus me-2"></i>Add Quota Category
            </button>
        </div>
    </div>



    <div class="row mb-4">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="dashboard-card bg-dark bg-opacity-50 p-4 rounded" style="border: 1px solid rgba(255,255,255,0.05);">
                <h5 class="text-white mb-3 fw-bold"><i class="fa fa-medal text-warning me-2"></i> Minimum Merit Score Requirement</h5>
                <p class="text-white-50 small mb-3">Set the minimum calculated score (average of 10th & 12th) required for a verified application to be automatically shortlised.</p>
                <form action="{{ route('admin.rules.threshold.update') }}" method="POST">
                    @csrf
                    <div class="d-flex gap-3">
                        <div class="flex-grow-1 position-relative">
                            <input type="number" step="0.01" min="0" max="100" class="form-control bg-transparent text-white border-secondary" name="merit_threshold" value="{{ $meritThreshold }}" required>
                            <span class="position-absolute text-white-50" style="right: 15px; top: 8px;">%</span>
                        </div>
                        <button type="submit" class="btn btn-warning px-4 fw-bold">Update Rule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="dashboard-card bg-dark bg-opacity-50">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Percentage</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($quotas as $quota)
                            <tr>
                                <td>{{ $quota->name }}</td>
                                <td><span class="badge bg-secondary">{{ $quota->code }}</span></td>
                                <td>{{ $quota->percentage }}%</td>
                                <td>
                                    @if($quota->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info rounded-pill px-3">Edit</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">No quota categories found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Placeholder for Modal --}}
<div class="course-overlay" id="quotaOverlay" onclick="hideQuotaModal()"></div>
<div class="course-modal" id="quotaModal">
    <div class="course-modal-content">
        <h4 class="text-white mb-4">Add Quota Category</h4>
        <form>
            <input type="text" placeholder="Quota Name (e.g. Schedule Caste)" required>
            <input type="text" placeholder="Quota Code (e.g. SC)" required>
            <input type="number" step="0.01" placeholder="Percentage (%)" required>
            <label class="text-white-50 mb-2">Category Status</label>
            <select>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            <button type="submit" class="btn-save-course mt-3">Create Category</button>
        </form>
    </div>
</div>

<script>
    function showAddQuotaModal() {
        document.getElementById('quotaOverlay').classList.add('active');
        document.getElementById('quotaModal').classList.add('active');
    }

    function hideQuotaModal() {
        document.getElementById('quotaOverlay').classList.remove('active');
        document.getElementById('quotaModal').classList.remove('active');
    }
</script>
@endsection
