@extends('admin.layout.app')

@section('content')
    <div class="container-fluid">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="text-white fw-bold mb-1">Academic Departments</h2>
                <div class="text-secondary small mt-1">
                    Manage your institution's faculties, departments, and course offerings
                </div>
            </div>
            <button class="btn btn-primary px-4 shadow" onclick="openDeptModal()">
                <i class="fa fa-plus me-2"></i> New Department
            </button>
        </div>

        <!-- STYLES -->
        <style>
            .dept-card-wrapper {
                transition: all 0.3s ease;
                text-decoration: none;
                display: block;
                border-radius: 16px;
                background: #1a1d24;
                /* Match dark theme */
                border: 1px solid rgba(255, 255, 255, 0.05);
                overflow: hidden;
                position: relative;
            }

            .dept-card-wrapper:hover {
                transform: translateY(-8px);
                border-color: rgba(255, 255, 255, 0.15);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
                text-decoration: none;
            }

            .dept-card-wrapper::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, transparent 100%);
                pointer-events: none;
            }

            .dept-card-wrapper i.arrow-icon {
                transform: translateX(0);
                transition: transform 0.3s ease;
            }

            .dept-card-wrapper:hover i.arrow-icon {
                transform: translateX(5px);
                color: #fff !important;
                opacity: 1 !important;
            }

            .dept-icon-box {
                width: 56px;
                height: 56px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                margin-bottom: 20px;
            }

            .course-count-badge {
                background: rgba(255, 255, 255, 0.05);
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 0.85rem;
                color: #adb5bd;
                display: inline-flex;
                align-items: center;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
        </style>

        <!-- GRID -->
        <div class="row g-4">
            @foreach ($departments as $index => $dept)
                @php
                    $colors = [
                        ['text' => 'text-primary', 'bg' => 'bg-primary'],
                        ['text' => 'text-success', 'bg' => 'bg-success'],
                        ['text' => 'text-warning', 'bg' => 'bg-warning'],
                        ['text' => 'text-info', 'bg' => 'bg-info'],
                        ['text' => 'text-danger', 'bg' => 'bg-danger'],
                        ['text' => 'text-secondary', 'bg' => 'bg-secondary'],
                    ];
                    $color = $colors[$index % count($colors)];

                    $icons = [
                        'fa-laptop-code',
                        'fa-atom',
                        'fa-palette',
                        'fa-chart-pie',
                        'fa-book-open',
                        'fa-building',
                        'fa-microscope',
                        'fa-globe',
                    ];
                    $iconClass = $icons[$index % count($icons)];
                @endphp

                <div class="col-md-4 col-sm-6" id="dept-card-{{ $dept->id }}" style="transition: all 0.3s ease;">
                    <a href="{{ route('admin.departments.show', $dept->id) }}" class="dept-card-wrapper p-4 h-100">

                        <div class="d-flex justify-content-between align-items-start">
                            <div class="dept-icon-box {{ $color['text'] }} {{ $color['bg'] }} bg-opacity-10">
                                <i class="fa {{ $iconClass }}"></i>
                            </div>
                            <div style="z-index: 2; position: relative;" onclick="event.preventDefault();">
                                <i class="fa fa-edit text-info cursor-pointer me-3"
                                    style="font-size: 1.1rem; transition: color 0.2s;"
                                    onclick="openEditDeptModal({{ json_encode($dept) }})"></i>
                                <i class="fa fa-trash text-danger cursor-pointer"
                                    style="font-size: 1.1rem; transition: color 0.2s;"
                                    onclick="deleteDept({{ $dept->id }})"></i>
                            </div>
                        </div>

                        <h4 class="text-white fw-bold mb-2">{{ $dept->name }}</h4>

                        <div class="text-secondary small mb-4">
                            @if ($dept->hod_name)
                                <i class="fa fa-user-circle me-1 opacity-75"></i> HOD: {{ $dept->hod_name }}
                            @else
                                <i class="fa fa-user-circle me-1 opacity-75"></i> HOD: Not Assigned
                            @endif
                        </div>

                        <div class="course-count-badge">
                            <i class="fa fa-book me-2 opacity-75"></i>
                            {{ $dept->courses_count }} {{ Str::plural('Course', $dept->courses_count) }}
                        </div>

                    </a>
                </div>
            @endforeach
        </div>

    </div>

    <!-- OVERLAY for Modal -->
    <div id="deptOverlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark"
        style="opacity: 0; visibility: hidden; z-index: 1040; transition: all 0.3s ease; background: rgba(0,0,0,0.7) !important;">
    </div>

    <!-- ADD DEPARTMENT MODAL -->
    <div id="deptModal" class="position-fixed top-50 start-50 translate-middle rounded shadow-lg p-4"
        style="background: #1a1d24; width: 90%; max-width: 500px; z-index: 1050; opacity: 0; visibility: hidden; transition: all 0.3s ease; transform: translate(-50%, -60%); border: 1px solid rgba(255,255,255,0.1);">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-white mb-0">Add New Department</h4>
            <i class="fa fa-times text-secondary cursor-pointer" onclick="closeDeptModal()"
                style="font-size: 1.2rem; cursor: pointer;"></i>
        </div>

        <form method="POST" action="{{ route('admin.departments.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label text-secondary small">Department Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control bg-dark text-white border-secondary"
                    placeholder="e.g. Computer Science" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary small">Department Code <span class="text-danger">*</span></label>
                <input type="text" name="code" class="form-control bg-dark text-white border-secondary"
                    placeholder="e.g. CS" required>
            </div>

            <div class="mb-4">
                <label class="form-label text-secondary small">HOD Name</label>
                <input type="text" name="hod_name" class="form-control bg-dark text-white border-secondary"
                    placeholder="e.g. Dr. John Doe">
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">
                Save Department
            </button>
        </form>
    </div>

    <!-- EDIT DEPARTMENT MODAL -->
    <div id="editDeptModal" class="position-fixed top-50 start-50 translate-middle rounded shadow-lg p-4"
        style="background: #1a1d24; width: 90%; max-width: 500px; z-index: 1050; opacity: 0; visibility: hidden; transition: all 0.3s ease; transform: translate(-50%, -60%); border: 1px solid rgba(255,255,255,0.1);">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-white mb-0">Edit Department</h4>
            <i class="fa fa-times text-secondary cursor-pointer" onclick="closeEditDeptModal()"
                style="font-size: 1.2rem; cursor: pointer;"></i>
        </div>

        <form method="POST" id="editDeptForm">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label text-secondary small">Department Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="edit_dept_name"
                    class="form-control bg-dark text-white border-secondary" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary small">Department Code <span class="text-danger">*</span></label>
                <input type="text" name="code" id="edit_dept_code"
                    class="form-control bg-dark text-white border-secondary" required>
            </div>

            <div class="mb-4">
                <label class="form-label text-secondary small">HOD Name</label>
                <input type="text" name="hod_name" id="edit_dept_hod"
                    class="form-control bg-dark text-white border-secondary">
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">
                Save Changes
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function openDeptModal() {
            const overlay = document.getElementById('deptOverlay');
            const modal = document.getElementById('deptModal');

            overlay.style.visibility = 'visible';
            overlay.style.opacity = '1';

            modal.style.visibility = 'visible';
            modal.style.opacity = '1';
            modal.style.transform = 'translate(-50%, -50%)';
        }

        function closeDeptModal() {
            const overlay = document.getElementById('deptOverlay');
            const modal = document.getElementById('deptModal');

            overlay.style.opacity = '0';
            setTimeout(() => overlay.style.visibility = 'hidden', 300);

            modal.style.opacity = '0';
            modal.style.transform = 'translate(-50%, -60%)';
            setTimeout(() => modal.style.visibility = 'hidden', 300);
        }

        function openEditDeptModal(dept) {
            const overlay = document.getElementById('deptOverlay');
            const modal = document.getElementById('editDeptModal');

            document.getElementById('edit_dept_name').value = dept.name;
            document.getElementById('edit_dept_code').value = dept.code;
            document.getElementById('edit_dept_hod').value = dept.hod_name || '';
            document.getElementById('editDeptForm').action = `/admin/departments/${dept.id}`;

            overlay.style.visibility = 'visible';
            overlay.style.opacity = '1';

            modal.style.visibility = 'visible';
            modal.style.opacity = '1';
            modal.style.transform = 'translate(-50%, -50%)';
        }

        function closeEditDeptModal() {
            const overlay = document.getElementById('deptOverlay');
            const modal = document.getElementById('editDeptModal');

            overlay.style.opacity = '0';
            setTimeout(() => overlay.style.visibility = 'hidden', 300);

            modal.style.opacity = '0';
            modal.style.transform = 'translate(-50%, -60%)';
            setTimeout(() => modal.style.visibility = 'hidden', 300);
        }

        function deleteDept(deptId) {
            if (confirm('Are you sure you want to delete this department? All associated courses will also be deleted.')) {
                let card = document.getElementById('dept-card-' + deptId);

                axios.delete(`/admin/departments/${deptId}`, {
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.data.success) {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.9)';
                        setTimeout(() => {
                            card.remove();
                        }, 300);
                    }
                }).catch(error => {
                    alert('Error deleting department.');
                });
            }
        }

        // Close when clicking overlay
        document.getElementById('deptOverlay').addEventListener('click', function() {
            closeDeptModal();
            closeEditDeptModal();
        });
    </script>
@endsection
