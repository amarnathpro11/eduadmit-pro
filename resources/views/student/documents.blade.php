@extends('student.layout')

@section('page_title', 'Upload Documents')

@section('content')
    <div class="row align-items-center mb-3">
        <div class="col">
            <p class="mb-0" style="color: rgba(255, 255, 255, 0.65); font-weight: 500;">Please upload clear, scanned copies
                of the following documents for verification.</p>
        </div>
        <div class="col-auto">
            <div class="p-2 px-3 bg-dark bg-opacity-25 border border-white border-opacity-10 rounded-pill d-flex align-items-center gap-2"
                style="font-size: 0.85rem; font-weight: 600; color: rgba(255,255,255,0.7);">
                <i data-lucide="info" style="width: 16px; color: #6366f1;"></i>
                Max File Size: 5MB (PDF, JPG, PNG)
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-10 text-success p-3 mb-4 d-flex align-items-center gap-3"
            style="border-radius: 16px;">
            <div
                style="width: 32px; height: 32px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <i data-lucide="check" style="width: 16px;"></i>
            </div>
            <span class="fw-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error') || $errors->any())
        <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-10 text-danger p-3 mb-4"
            style="border-radius: 16px;">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div
                    style="width: 32px; height: 32px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <i data-lucide="x-circle" style="width: 16px;"></i>
                </div>
                <span class="fw-bold">{{ session('error') ?? 'Action Required:' }}</span>
            </div>
            @if ($errors->any())
                <ul class="mb-0 ps-5" style="font-size: 0.9rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

    <div class="row g-4">
        @foreach ($documentTypes as $doc)
            @php
                $uploadedDoc = $documents[$doc['id']] ?? null;
                $colors = [
                    '10th' => '#3b82f6',
                    '12th' => '#f59e0b',
                    'tc' => '#ef4444',
                    'id' => '#8b5cf6',
                    'photo' => '#06b6d4',
                    'income' => '#ec4899',
                ];
                $color = $colors[$doc['id']] ?? '#64748b';
            @endphp
            <div class="col-xl-6">
                <div class="premium-card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                style="width: 48px; height: 48px; background-color: {{ $color }}10; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: {{ $color }};">
                                <i data-lucide="{{ $uploadedDoc ? 'file-check' : 'file-up' }}" style="width: 24px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold text-white" style="font-family: 'Outfit';">{{ $doc['name'] }}</h5>
                                <p class="mb-0"
                                    style="font-size: 0.75rem; font-weight: 700; color: rgba(255, 255, 255, 0.5);">
                                    {{ $uploadedDoc ? 'STAMPED & FILED' : 'ACTION REQUIRED' }}</p>
                            </div>
                        </div>
                        <div class="badge {{ $uploadedDoc ? 'bg-success text-success' : 'bg-warning text-warning' }} bg-opacity-10 px-3 py-2"
                            style="border-radius: 10px; font-weight: 700; font-size: 0.7rem; letter-spacing: 0.5px;">
                            {{ $uploadedDoc ? ($uploadedDoc->status == 'pending' ? 'SUBMITTED' : strtoupper($uploadedDoc->status)) : 'PENDING' }}
                        </div>
                    </div>

                    @if ($uploadedDoc)
                        <div class="position-relative">
                            <!-- Loading Overlay for Edit -->
                            <div id="loader-{{ $doc['id'] }}" class="loading-overlay d-none">
                                <div class="spinner-border text-indigo" role="status" style="width: 2rem; height: 2rem;">
                                </div>
                                <p class="mt-2 fw-bold text-white mb-0" style="font-size: 0.9rem;">Updating...</p>
                            </div>

                            <div id="content-{{ $doc['id'] }}" class="p-3 mb-2"
                                style="background-color: rgba(255,255,255,0.02); border: 1px dashed rgba(255,255,255,0.1); border-radius: 16px;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3 overflow-hidden">
                                        <div
                                            style="width: 32px; height: 32px; background-color: rgba(255,255,255,0.05); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6366f1; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <i data-lucide="paperclip" style="width: 14px;"></i>
                                        </div>
                                        <span style="font-size: 0.85rem; color: #ffffff; font-weight: 600;"
                                            class="text-truncate">
                                            {{ basename($uploadedDoc->file_path) }}
                                        </span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ Storage::url($uploadedDoc->file_path) }}" target="_blank"
                                            class="icon-btn"
                                            style="width: 34px; height: 34px; background: rgba(255,255,255,0.05);">
                                            <i data-lucide="eye" style="width: 16px;"></i>
                                        </a>
                                        <button class="icon-btn"
                                            style="width: 34px; height: 34px; background: rgba(255,255,255,0.05);"
                                            onclick="document.getElementById('file-{{ $doc['id'] }}').click()">
                                            <i data-lucide="edit-3" style="width: 16px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Hidden form for re-upload -->
                        <form id="form-{{ $doc['id'] }}" action="{{ url('/student/documents/upload') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="type" value="{{ $doc['id'] }}">
                            <input type="file" name="document" class="d-none" id="file-{{ $doc['id'] }}"
                                accept=".pdf,.jpg,.jpeg,.png" onchange="handleUpload('{{ $doc['id'] }}')">
                        </form>
                    @else
                        <form id="form-{{ $doc['id'] }}" action="{{ url('/student/documents/upload') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="type" value="{{ $doc['id'] }}">
                            <input type="file" name="document" class="d-none" id="file-{{ $doc['id'] }}"
                                accept=".pdf,.jpg,.jpeg,.png" onchange="handleUpload('{{ $doc['id'] }}')">
                            <div class="upload-zone text-center p-5 mt-2 position-relative"
                                style="border: 2px dashed rgba(255,255,255,0.1); border-radius: 20px; background-color: rgba(255,255,255,0.02); cursor: pointer; transition: all 0.2s;"
                                onclick="document.getElementById('file-{{ $doc['id'] }}').click()">
                                <!-- Loading Overlay -->
                                <div id="loader-{{ $doc['id'] }}" class="loading-overlay d-none">
                                    <div class="spinner-border text-indigo" role="status"
                                        style="width: 2rem; height: 2rem;"></div>
                                    <p class="mt-2 fw-bold text-white mb-0" style="font-size: 0.9rem;">Uploading...</p>
                                </div>

                                <div id="content-{{ $doc['id'] }}">
                                    <div
                                        style="width: 54px; height: 54px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                                        <i data-lucide="plus" style="width: 24px; color: #6366f1;"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1 text-white">Click to Upload Document</h6>
                                    <p class="mb-0"
                                        style="font-size: 0.8rem; color: rgba(255, 255, 255, 0.45); font-weight: 500;">Drag
                                        & drop your file here or <span
                                            style="color: #6366f1; font-weight: 700;">browse</span></p>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-5 text-center">
        <form action="{{ route('student.submit_verification') }}" method="POST">
            @csrf
            <button type="submit" class="btn-premium-primary px-5 py-3" style="font-size: 1rem; width: 300px;">
                Submit for Verification
            </button>
        </form>
    </div>

    <style>
        .upload-zone:hover {
            border-color: #6366f1 !important;
            background-color: rgba(255, 255, 255, 0.05) !important;
            transform: translateY(-2px);
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.8);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10;
            border-radius: 20px;
            backdrop-filter: blur(4px);
        }
    </style>
    <script>
        function handleUpload(id) {
            const fileInput = document.getElementById('file-' + id);
            const file = fileInput.files[0];

            if (!file) return;

            // Validate size (2MB limit to match PHP default)
            const maxSize = 2 * 1024 * 1024; // 2MB
            if (file.size > maxSize) {
                alert(
                'File is too large (Maximum 2MB allowed on current server). Please compress your file and try again.');
                fileInput.value = ''; // Reset input
                return;
            }

            // Validate type
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert('Format not supported. Please use PDF, JPG, or PNG.');
                fileInput.value = ''; // Reset input
                return;
            }

            // All good, show loader and submit
            showLoader(id);
            document.getElementById('form-' + id).submit();
        }

        function showLoader(id) {
            document.getElementById('loader-' + id).classList.remove('d-none');
            document.getElementById('content-' + id).classList.add('opacity-25');
        }
    </script>
@endsection
