@extends('admin.layout.app')

@section('content')
    <style>
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

        .student-row {
            cursor: pointer;
            transition: 0.2s;
        }

        .student-row:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .student-row.selected {
            background: rgba(99, 102, 241, 0.1);
            border-left: 3px solid #6366f1;
        }

        .preview-pane {
            background: #0f172a;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            position: sticky;
            top: 20px;
        }

        .doc-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: 0.2s;
        }

        .doc-item:hover,
        .doc-item.active {
            border-color: #6366f1;
            background: rgba(99, 102, 241, 0.05);
        }

        .doc-preview-area {
            height: 400px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .doc-preview-area img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .doc-preview-area iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-white mb-1 fw-bold">Application & Document Verification</h2>
            <p class="text-secondary mb-0">Review submitted applications to verify eligibility and documents.</p>
        </div>
    </div>



    <div class="dark-card p-4">
        <div class="nav-tabs-custom">
            <a href="{{ route('admin.verification.index', ['status' => 'all']) }}"
                class="{{ $status == 'all' ? 'active' : '' }}">
                All ({{ $counts['all'] }})
            </a>
            <a href="{{ route('admin.verification.index', ['status' => 'pending']) }}"
                class="{{ in_array($status, ['pending', 'submitted_documents']) ? 'active' : '' }}">
                Pending Review ({{ $counts['pending'] }})
            </a>
            <a href="{{ route('admin.verification.index', ['status' => 'verified']) }}"
                class="{{ $status == 'verified' ? 'active' : '' }}">
                Verified ({{ $counts['verified'] }})
            </a>
            <a href="{{ route('admin.verification.index', ['status' => 'rejected']) }}"
                class="{{ $status == 'rejected' ? 'active' : '' }}">
                Rejected ({{ $counts['rejected'] }})
            </a>
        </div>

        <div class="row gx-4">
            <!-- Left Pane: List of Students -->
            <div class="col-lg-7 border-end border-secondary border-opacity-25"
                style="max-height: 700px; overflow-y: auto;">
                <div class="table-responsive">
                    <table class="table table-dark table-borderless align-middle mb-0">
                        <thead style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                            <tr class="text-secondary" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">
                                <th class="py-3">STUDENT NAME</th>
                                <th class="py-3">APP ID</th>
                                <th class="py-3">PROGRAM</th>
                                <th class="py-3">DATE</th>
                                <th class="py-3">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $app)
                                <tr class="student-row border-bottom border-light border-opacity-10"
                                    data-id="{{ $app->id }}" onclick="loadApplication({{ $app->id }}, this)">
                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div
                                                style="width: 36px; height: 36px; border-radius: 50%; background: #{{ substr(md5($app->id), 0, 6) }}; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 0.9rem;">
                                                {{ substr($app->user->name ?? $app->first_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-white">
                                                    {{ $app->user->name ?? $app->first_name . ' ' . $app->last_name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 text-white-50 script-font">{{ $app->application_no }}</td>
                                    <td class="py-3 text-white-50"><small>{{ $app->course->code ?? 'N/A' }}</small></td>
                                    <td class="py-3 text-white-50">
                                        <small>{{ \Carbon\Carbon::parse($app->updated_at)->format('M d, Y') }}</small>
                                    </td>
                                    <td class="py-3">
                                        @if ($app->status == 'pending' || $app->status == 'submitted_documents')
                                            <span
                                                class="badge bg-warning bg-opacity-10 text-warning px-2 py-1">Pending</span>
                                        @elseif(in_array($app->status, ['verified', 'merit', 'offer_made', 'confirmed', 'enrolled']))
                                            <span
                                                class="badge bg-success bg-opacity-10 text-success px-2 py-1">Verified</span>
                                        @elseif($app->status == 'rejected')
                                            <span
                                                class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa fa-folder-open fs-1 mb-3"></i>
                                        <h5>No {{ str_replace('_', ' ', $status) }} applications found</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Pane: Verification Detail -->
            <div class="col-lg-5 ps-4">
                <div id="empty-preview"
                    class="d-flex flex-column align-items-center justify-content-center h-100 text-muted"
                    style="min-height: 400px;">
                    <i class="fa fa-file-invoice fs-1 mb-3" style="opacity: 0.5;"></i>
                    <p>Select an application to begin verification</p>
                </div>

                <div id="active-preview" class="preview-pane p-4 d-none">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <div id="preview-avatar"
                                style="width: 48px; height: 48px; border-radius: 12px; background: #6366f1; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.2rem;">
                                A
                            </div>
                            <div>
                                <h5 id="preview-name" class="text-white mb-0 fw-bold">Student Name</h5>
                                <small id="preview-id" class="text-secondary">APP-ID</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <small class="text-secondary fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">MERIT
                                SCORE</small>
                            <h4 id="preview-merit" class="text-primary fw-bold mb-0">--%</h4>
                        </div>
                    </div>

                    <h6 class="text-secondary fw-bold"
                        style="font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1rem;">
                        Document Checklist</h6>

                    <div id="document-list" class="mb-4">
                        <!-- Documents populated via JS -->
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 id="preview-title" class="text-secondary fw-bold mb-0"
                            style="font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase;">Preview</h6>
                        <a id="preview-download" href="#" target="_blank" class="text-primary text-decoration-none"
                            style="font-size: 0.8rem;"><i class="fa fa-external-link-alt me-1"></i> Open</a>
                    </div>

                    <div class="doc-preview-area" id="doc-viewer-container">
                        <div class="text-muted"><i class="fa fa-eye-slash mb-2 fs-3"></i><br>Select a document</div>
                    </div>

                    <div class="actions mt-4 d-flex gap-2">
                        <form id="reject-form" method="POST" action="" class="w-50">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 py-2 fw-bold"
                                style="border-radius: 10px;">
                                <i class="fa fa-times me-2"></i> Reject
                            </button>
                        </form>
                        <form id="approve-form" method="POST" action="" class="w-50">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold"
                                style="border-radius: 10px; background: #2563eb; border: none;">
                                <i class="fa fa-check me-2"></i> Approve
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentDocuments = [];

        function loadApplication(id, rowElement) {
            // Handle row highlight
            document.querySelectorAll('.student-row').forEach(row => row.classList.remove('selected'));
            rowElement.classList.add('selected');

            // Show loading state
            document.getElementById('empty-preview').classList.add('d-none');
            document.getElementById('active-preview').classList.remove('d-none');
            document.getElementById('document-list').innerHTML =
                '<div class="text-center py-3 text-muted"><i class="fa fa-spinner fa-spin"></i> Loading documents...</div>';

            // Forms are updated when a document is clicked


            fetch(`/admin/verification/${id}`)
                .then(res => res.json())
                .then(data => {
                    const app = data.application;
                    const docs = data.documents;
                    currentDocuments = docs;

                    const name = app.user ? app.user.name : (app.first_name + ' ' + app.last_name);
                    document.getElementById('preview-name').innerText = name;
                    document.getElementById('preview-avatar').innerText = name.charAt(0).toUpperCase();
                    document.getElementById('preview-id').innerText = app.application_no;

                    const meritScore = app.merit_score ?
                        parseFloat(app.merit_score).toFixed(2) :
                        ((parseFloat(app.tenth_percentage || 0) + parseFloat(app.twelfth_percentage || 0)) / 2).toFixed(
                            2);
                    document.getElementById('preview-merit').innerText = meritScore + '%';

                    let docHtml = '';
                    if (docs.length === 0) {
                        docHtml =
                            '<div class="text-muted text-center py-2"><small>No documents uploaded yet.</small></div>';
                    } else {
                        docs.forEach((doc, index) => {
                            const typeNames = {
                                '10th': '10th Marksheet',
                                '12th': '12th Certificate',
                                'tc': 'Transfer Certificate',
                                'id': 'ID Proof (Aadhaar)',
                                'photo': 'Passport Photo',
                                'income': 'Income Certificate'
                            };
                            const label = typeNames[doc.document_type] || doc.document_type || 'Unknown';

                            let statusIcon = 'fa-clock text-warning';
                            let statusBg = 'rgba(245, 158, 11, 0.1)';
                            if (doc.status === 'verified') {
                                statusIcon = 'fa-check text-success';
                                statusBg = 'rgba(16, 185, 129, 0.1)';
                            } else if (doc.status === 'rejected') {
                                statusIcon = 'fa-times text-danger';
                                statusBg = 'rgba(239, 68, 68, 0.1)';
                            }

                            docHtml += `
                            <div class="doc-item" onclick="viewDocument(${index}, this)">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="background: ${statusBg}; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-file-invoice ${statusIcon.split(' ')[1]}"></i>
                                    </div>
                                    <span class="text-white fw-medium" style="font-size: 0.9rem;">${label}</span>
                                </div>
                                <i class="fa ${statusIcon}"></i>
                            </div>
                        `;
                        });
                    }
                    document.getElementById('document-list').innerHTML = docHtml;

                    // Load first doc by default if exists
                    if (docs.length > 0) {
                        setTimeout(() => {
                            const firstDoc = document.querySelector('.doc-item');
                            if (firstDoc) viewDocument(0, firstDoc);
                        }, 50);
                    } else {
                        document.getElementById('doc-viewer-container').innerHTML =
                            '<div class="text-muted"><i class="fa fa-eye-slash mb-2 fs-3"></i><br>No document available</div>';
                        document.getElementById('approve-form').classList.add('d-none');
                        document.getElementById('reject-form').classList.add('d-none');
                    }
                })
                .catch(err => {
                    console.error('Error fetching application data:', err);
                    document.getElementById('document-list').innerHTML =
                        '<div class="text-danger py-2">Failed to load data.</div>';
                });
        }

        function viewDocument(docIndex, element) {
            document.querySelectorAll('.doc-item').forEach(item => item.classList.remove('active'));
            element.classList.add('active');

            const doc = currentDocuments[docIndex];
            const publicPath = '{{ asset('storage') }}/' + doc
                .file_path; // Adjusted assuming moving to public storage mapping

            // Update forms for this specific document
            document.getElementById('approve-form').action = `/admin/verification/document/${doc.id}/approve`;
            document.getElementById('reject-form').action = `/admin/verification/document/${doc.id}/reject`;
            document.getElementById('approve-form').classList.remove('d-none');
            document.getElementById('reject-form').classList.remove('d-none');

            const typeNames = {
                '10th': '10th Marksheet',
                '12th': '12th Certificate',
                'tc': 'Transfer Certificate',
                'id': 'ID Proof (Aadhaar)',
                'photo': 'Passport Photo',
                'income': 'Income Certificate'
            };
            document.getElementById('preview-title').innerText = 'Preview: ' + (typeNames[doc.document_type] || doc
                .document_type || 'Unknown');
            document.getElementById('preview-download').href = publicPath;

            const container = document.getElementById('doc-viewer-container');

            // Simple logic for image vs pdf based on path ending (assuming mostly pdf or image)
            const filePath = doc.file_path || '';
            if (filePath.toLowerCase().endsWith('.pdf')) {
                container.innerHTML = `<iframe src="${publicPath}#toolbar=0" width="100%" height="100%"></iframe>`;
            } else if (filePath) {
                container.innerHTML = `<img src="${publicPath}" alt="Document Preview">`;
            } else {
                container.innerHTML =
                    `<div class="text-muted"><i class="fa fa-eye-slash mb-2 fs-3"></i><br>File not provided</div>`;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const appId = urlParams.get('app_id');
            if (appId) {
                const row = document.querySelector(`tr[data-id="${appId}"]`);
                if (row) {
                    row.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    row.click();
                }
            }
        });
    </script>
@endsection
