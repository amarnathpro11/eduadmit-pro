@extends('admin.layout.app')

@section('content')
    <div class="container-fluid">

        <!-- BACK BUTTON -->
        <div class="mb-3">
            <a href="{{ route('admin.departments.index') }}" class="text-secondary text-decoration-none small transition">
                <i class="fa fa-arrow-left me-1"></i> Back to Departments
            </a>
        </div>

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="text-white fw-bold mb-1 d-flex align-items-center">
                    {{ $department->name }}
                    <i class="fa fa-edit ms-3 cursor-pointer text-info" style="font-size: 1.25rem;"
                        onclick="openDepartmentModal()"></i>
                </h2>
                <div class="text-secondary small mt-1">
                    {{ $department->courses->count() }} Active Courses
                    @if ($department->hod_name)
                        <span class="mx-2">|</span> <span class="text-white fw-semibold">HOD:
                            {{ $department->hod_name }}</span>
                    @endif
                </div>
            </div>

            <button class="btn btn-primary px-4 shadow" onclick="openCourseModal()">
                <i class="fa fa-plus me-2"></i> New Course
            </button>
        </div>


        <!-- STATS CARDS -->
        <div class="row g-4 mb-4">

            <div class="col-md-4">
                <div class="dark-stat-card p-4 d-flex align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary d-flex justify-content-center align-items-center rounded-circle me-3"
                        style="width: 50px; height: 50px; font-size: 1.2rem;">
                        <i class="fa fa-users"></i>
                    </div>
                    <div>
                        <small class="text-secondary">Total Intake</small>
                        <h4 class="fw-bold text-white mb-0">
                            {{ $department->courses->sum('total_seats') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dark-stat-card p-4 d-flex align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success d-flex justify-content-center align-items-center rounded-circle me-3"
                        style="width: 50px; height: 50px; font-size: 1.2rem;">
                        <i class="fa fa-book"></i>
                    </div>
                    <div>
                        <small class="text-secondary">Open Admissions</small>
                        <h4 class="fw-bold text-white mb-0">
                            {{ $department->courses->where('is_active', 1)->count() }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dark-stat-card p-4 d-flex align-items-center">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning d-flex justify-content-center align-items-center rounded-circle me-3"
                        style="width: 50px; height: 50px; font-size: 1.2rem;">
                        <i class="fa fa-rupee-sign"></i>
                    </div>
                    <div>
                        <small class="text-secondary">Avg. Fee</small>
                        <h4 class="fw-bold text-white mb-0">
                            ₹ {{ number_format($department->courses->avg('admission_fee'), 0) }}
                        </h4>
                    </div>
                </div>
            </div>

        </div>


        <!-- COURSE CARDS -->
        <style>
            .course-item-wrap {
                transition: opacity 0.4s ease, transform 0.4s ease;
            }

            .course-faded {
                opacity: 0.5;
            }

            .course-deleted {
                opacity: 0;
                transform: scale(0.95);
            }

            .dark-stat-card,
            .dark-course-card {
                background: #1a1d24;
                /* Elegant dark card background */
                border: 1px solid rgba(255, 255, 255, 0.05);
                /* Subtle rim light */
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
                /* Premium soft shadow */
                transition: all 0.3s ease;
            }

            .dark-course-card:hover {
                transform: translateY(-6px);
                border-color: rgba(255, 255, 255, 0.15);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            }

            hr.card-divider {
                border-color: rgba(255, 255, 255, 0.1);
                margin: 1.25rem 0;
            }
        </style>

        <div class="row g-4">

            @foreach ($department->courses as $course)
                <div class="col-md-6 course-item-wrap {{ !$course->is_active ? 'course-faded' : '' }}"
                    id="course-{{ $course->id }}">

                    <div class="dark-course-card p-4 h-100">

                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="course-code text-info">
                                    {{ $course->code }}
                                </span>
                                <h5 class="text-white fw-semibold mt-2">
                                    {{ $course->name }}
                                </h5>
                            </div>

                            <div>
                                <i class="fa fa-edit text-info me-3 cursor-pointer"
                                    onclick="openEditCourseModal({{ json_encode($course) }})"></i>
                                <i class="fa fa-trash text-danger cursor-pointer"
                                    onclick="deleteCourse({{ $course->id }})"></i>
                            </div>
                        </div>


                        <div class="row mb-3">

                            <div class="col-4">
                                <small class="text-secondary">Intake</small>
                                <div class="text-white fw-semibold">
                                    {{ $course->total_seats }}
                                </div>
                            </div>

                            <div class="col-4">
                                <small class="text-secondary">Duration</small>
                                <div class="text-white fw-semibold">
                                    {{ $course->duration_years }} Years
                                </div>
                            </div>

                            <div class="col-4">
                                <small class="text-secondary">Fees</small>
                                <div class="text-success fw-semibold">
                                    ₹ {{ number_format($course->admission_fee, 0) }}
                                </div>
                            </div>

                        </div>

                        <hr class="card-divider">

                        <div class="d-flex justify-content-between align-items-center mt-3">

                            <span id="status-text-{{ $course->id }}"
                                class="status-badge  
                        {{ $course->is_active ? 'open text-success' : 'closed text-secondary' }}">
                                {{ $course->is_active ? 'Open for Admission' : 'Closed' }}
                            </span>

                            <div class="form-check form-switch cursor-pointer"
                                style="transform: scale(1.3); transform-origin: right;">
                                <input class="form-check-input cursor-pointer" type="checkbox"
                                    onchange="toggleCourse({{ $course->id }}, this)"
                                    {{ $course->is_active ? 'checked' : '' }}>
                            </div>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>
    <!-- OVERLAY -->
    <div id="courseOverlay" class="course-overlay"></div>

    <div id="courseModal" class="course-modal">
        <div class="course-modal-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-white" id="courseModalTitle">Add New Course</h4>
                <i class="fa fa-times text-white cursor-pointer" onclick="closeCourseModal()"></i>
            </div>
            <form id="courseForm" method="POST" action="{{ route('admin.courses.store') }}">
                @csrf
                <input type="hidden" name="_method" id="courseFormMethod" value="POST">

                <input type="hidden" name="department_id" value="{{ $department->id }}">

                <input type="text" name="name" id="course_name" placeholder="Course Name" required>
                <input type="text" name="code" id="course_code" placeholder="Course Code" required>
                <input type="number" name="duration_years" id="course_duration_years" placeholder="Duration (Years)"
                    required>
                <input type="number" name="total_seats" id="course_total_seats" placeholder="Total Seats" required>
                <input type="number" name="application_fee" id="course_application_fee" placeholder="Application Fee"
                    required>
                <input type="number" name="admission_fee" id="course_admission_fee" placeholder="Admission Fee"
                    required>

                <select name="level" id="course_level">
                    <option value="">Level</option>
                    <option value="UG">UG</option>
                    <option value="PG">PG</option>
                    <option value="PhD">PhD</option>
                </select>

                <button type="submit" class="btn-save-course">
                    Save Course
                </button>
            </form>
        </div>
    </div>

    <!-- DEPARTMENT EDIT MODAL -->
    <div id="departmentModal" class="course-modal">
        <div class="course-modal-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-white">Edit Department</h4>
                <i class="fa fa-times text-white cursor-pointer" onclick="closeDepartmentModal()"></i>
            </div>
            <form method="POST" action="{{ route('admin.departments.update', $department->id) }}">
                @csrf
                @method('PUT')
                <input type="text" name="name" value="{{ $department->name }}" placeholder="Department Name"
                    required>
                <input type="text" name="code" value="{{ $department->code }}" placeholder="Department Code"
                    required>
                <input type="text" name="hod_name" value="{{ $department->hod_name }}" placeholder="HOD Name">
                <button type="submit" class="btn-save-course">
                    Save Changes
                </button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function openCourseModal() {
            document.getElementById('courseModalTitle').innerText = 'Add New Course';
            document.getElementById('courseForm').action = "{{ route('admin.courses.store') }}";
            document.getElementById('courseFormMethod').value = 'POST';

            // Reset fields
            document.getElementById('course_name').value = '';
            document.getElementById('course_code').value = '';
            document.getElementById('course_duration_years').value = '';
            document.getElementById('course_total_seats').value = '';
            document.getElementById('course_application_fee').value = '';
            document.getElementById('course_admission_fee').value = '';
            document.getElementById('course_level').value = '';

            document.getElementById('courseOverlay').classList.add('active');
            document.getElementById('courseModal').classList.add('active');
        }

        function openEditCourseModal(course) {
            document.getElementById('courseModalTitle').innerText = 'Edit Course';
            document.getElementById('courseForm').action = `/admin/courses/${course.id}`;
            document.getElementById('courseFormMethod').value = 'PUT';

            // Prefill course details
            document.getElementById('course_name').value = course.name;
            document.getElementById('course_code').value = course.code;
            document.getElementById('course_duration_years').value = course.duration_years;
            document.getElementById('course_total_seats').value = course.total_seats;
            document.getElementById('course_application_fee').value = course.application_fee;
            document.getElementById('course_admission_fee').value = course.admission_fee;
            document.getElementById('course_level').value = course.level || '';

            document.getElementById('courseOverlay').classList.add('active');
            document.getElementById('courseModal').classList.add('active');
        }

        function closeCourseModal() {
            document.getElementById('courseOverlay').classList.remove('active');
            document.getElementById('courseModal').classList.remove('active');
            document.getElementById('departmentModal').classList.remove('active');
        }

        function openDepartmentModal() {
            document.getElementById('courseOverlay').classList.add('active');
            document.getElementById('departmentModal').classList.add('active');
        }

        function closeDepartmentModal() {
            closeCourseModal();
        }

        // Close when clicking overlay
        document.getElementById('courseOverlay').addEventListener('click', closeCourseModal);

        function toggleCourse(courseId, el) {
            let wrap = document.getElementById('course-' + courseId);
            let statusText = document.getElementById('status-text-' + courseId);
            let originalState = !el.checked;

            // Optimistic update UI
            if (el.checked) {
                wrap.classList.remove('course-faded');
                statusText.innerText = 'Open for Admission';
                statusText.className = 'status-badge open text-success';
            } else {
                wrap.classList.add('course-faded');
                statusText.innerText = 'Closed';
                statusText.className = 'status-badge closed text-secondary';
            }

            axios.post(`/admin/courses/${courseId}/toggle`, {
                _token: '{{ csrf_token() }}'
            }).then(response => {
                // If needed, handle server response
            }).catch(error => {
                alert('An error occurred. Reverting status.');
                el.checked = originalState; // revert visually
                if (originalState) {
                    wrap.classList.remove('course-faded');
                    statusText.innerText = 'Open for Admission';
                    statusText.className = 'status-badge open text-success';
                } else {
                    wrap.classList.add('course-faded');
                    statusText.innerText = 'Closed';
                    statusText.className = 'status-badge closed text-secondary';
                }
            });
        }

        function deleteCourse(courseId) {
            if (confirm('Are you sure you want to delete this course?')) {
                let wrap = document.getElementById('course-' + courseId);

                axios.delete(`/admin/courses/${courseId}`, {
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.data.success) {
                        wrap.classList.add('course-deleted');
                        setTimeout(() => {
                            wrap.remove();
                        }, 400);
                    }
                }).catch(error => {
                    alert('Error deleting course.');
                });
            }
        }
    </script>
@endsection
