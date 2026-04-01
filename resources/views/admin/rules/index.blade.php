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
                    <div class="d-flex flex-column gap-3">
                        <div class="mb-2">
                            <label class="text-white-50 small mb-2">Select Category to Adjust:</label>
                            <select name="quota_id" id="threshold_category_selector" class="form-select bg-dark border-secondary text-white" onchange="updateSliderFromCategory()">
                                @foreach($quotas as $quota)
                                    <option value="{{ $quota->id }}" data-threshold="{{ $quota->merit_threshold }}">{{ $quota->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="text-white-50 small">Adjust Threshold:</label>
                        <div class="d-flex align-items-center gap-4">
                            <input type="range" step="0.5" min="0" max="100" 
                                class="form-range flex-grow-1" 
                                id="merit_slider"
                                style="height: 6px; background: rgba(255,255,255,0.1); border-radius: 10px; cursor: pointer; accent-color: #f59e0b;"
                                name="merit_threshold" 
                                value="{{ $quotas->first()->merit_threshold ?? 60 }}" 
                                oninput="document.getElementById('slider_value').innerText = this.value + '%'">
                            <span id="slider_value" class="text-warning fw-bold fs-4" style="min-width: 80px; text-align: right;">{{ $quotas->first()->merit_threshold ?? 60 }}%</span>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 py-2 fw-bold mt-2" style="border-radius: 10px;">
                            <i class="fa fa-save me-2"></i>Update Category Rule
                        </button>
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
                                <th>Quota %</th>
                                <th>Min. Merit %</th>
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
                                <td><span class="text-warning fw-bold">{{ $quota->merit_threshold }}%</span></td>
                                <td>
                                    @if($quota->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-info rounded-pill px-3" 
                                            onclick="showEditQuotaModal({{ json_encode($quota) }})">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.rules.quotas.destroy', $quota->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
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

{{-- Add Quota Modal --}}
<div class="course-overlay" id="quotaOverlay" onclick="hideQuotaModal()"></div>
<div class="course-modal" id="quotaModal">
    <div class="course-modal-content">
        <h4 class="text-white mb-4">Add Quota Category</h4>
        <form action="{{ route('admin.rules.quotas.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" name="name" placeholder="Quota Name (e.g. Schedule Caste)" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="text" name="code" placeholder="Quota Code (e.g. SC)" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="number" step="0.01" name="percentage" placeholder="Quota Percentage (%)" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="text-white-50 mb-1 small">Min. Merit Score (%)</label>
                <input type="number" step="0.01" name="merit_threshold" placeholder="Merit Threshold (%)" class="form-control" value="60.00" required>
            </div>
            <div class="mb-3">
                <label class="text-white-50 mb-2 small d-block">Category Status</label>
                <select name="is_active" class="form-select">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn-save-course mt-3 w-100">Create Category</button>
            <button type="button" class="btn btn-outline-light w-100 mt-2" onclick="hideQuotaModal()">Cancel</button>
        </form>
    </div>
</div>

{{-- Edit Quota Modal --}}
<div class="course-modal" id="editQuotaModal">
    <div class="course-modal-content">
        <h4 class="text-white mb-4">Edit Quota Category</h4>
        <form id="editQuotaForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <input type="text" name="name" id="edit_quota_name" placeholder="Quota Name" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="text" name="code" id="edit_quota_code" placeholder="Quota Code" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="number" step="0.01" name="percentage" id="edit_quota_percentage" placeholder="Percentage (%)" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="text-white-50 mb-1 small">Min. Merit Score (%)</label>
                <input type="number" step="0.01" name="merit_threshold" id="edit_quota_merit_threshold" placeholder="Merit Threshold (%)" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="text-white-50 mb-2 small d-block">Category Status</label>
                <select name="is_active" id="edit_quota_is_active" class="form-select">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn-save-course mt-3 w-100">Update Category</button>
            <button type="button" class="btn btn-outline-light w-100 mt-2" onclick="hideEditQuotaModal()">Cancel</button>
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

    function showEditQuotaModal(quota) {
        document.getElementById('edit_quota_name').value = quota.name;
        document.getElementById('edit_quota_code').value = quota.code;
        document.getElementById('edit_quota_percentage').value = quota.percentage;
        document.getElementById('edit_quota_merit_threshold').value = quota.merit_threshold;
        document.getElementById('edit_quota_is_active').value = quota.is_active;
        
        const form = document.getElementById('editQuotaForm');
        form.action = `/admin/rules/quotas/${quota.id}`;
        
        document.getElementById('quotaOverlay').classList.add('active');
        document.getElementById('editQuotaModal').classList.add('active');
    }

    function hideEditQuotaModal() {
        document.getElementById('quotaOverlay').classList.remove('active');
        document.getElementById('editQuotaModal').classList.remove('active');
    }

    function updateSliderFromCategory() {
        const selector = document.getElementById('threshold_category_selector');
        const selectedOption = selector.options[selector.selectedIndex];
        const threshold = selectedOption.getAttribute('data-threshold');
        
        const slider = document.getElementById('merit_slider');
        const sliderValue = document.getElementById('slider_value');
        
        slider.value = threshold;
        sliderValue.innerText = threshold + '%';
    }
</script>
@endsection
