@extends('admin.layout.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-white mb-1 fw-bold">Final Admissions</h2>
            <p class="text-secondary mb-0">Select candidates to process final enrollment.</p>
        </div>
    </div>



    <div class="dark-card p-4">
        <div class="table-responsive">
            <table class="table table-dark table-borderless align-middle mb-0">
                <thead style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <tr class="text-secondary" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">
                        <th class="py-3">STUDENT NAME</th>
                        <th class="py-3">APP ID</th>
                        <th class="py-3">PROGRAM</th>
                        <th class="py-3">STATUS</th>
                        <th class="py-3 text-end">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                        <tr class="border-bottom border-light border-opacity-10">
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div
                                        style="width: 36px; height: 36px; border-radius: 50%; background: #{{ substr(md5($app->id), 0, 6) }}; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 0.9rem;">
                                        {{ substr($app->user->name ?? $app->first_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-white">
                                            {{ $app->user->name ?? $app->first_name . ' ' . $app->last_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-white-50 script-font">{{ $app->application_no }}</td>
                            <td class="py-3 text-white-50"><small>{{ $app->course->code ?? 'N/A' }}</small></td>
                            <td class="py-3">
                                @php
                                    $isPaid = false;
                                    if ($app->payments) {
                                        $isPaid = $app->payments->where('status', 'success')->count() > 0;
                                    }
                                @endphp
                                @if ($app->status == 'enrolled')
                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">Enrolled</span>
                                    @if($app->enrollment && $app->enrollment->student_id)
                                        <div class="mt-1"><small class="text-white-50"><i class="fa fa-id-card me-1"></i>{{ $app->enrollment->student_id }}</small></div>
                                    @endif
                                @elseif($isPaid)
                                    <span class="badge bg-info bg-opacity-10 text-info px-2 py-1">Fee Paid / Ready</span>
                                @else
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">Awaiting
                                        Final</span>
                                @endif
                            </td>
                            <td class="py-3 text-end">
                                <a href="{{ route('admin.final_admission.show', $app->id) }}"
                                    class="btn btn-sm btn-outline-primary" style="border-radius: 8px;">Process Admission</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa fa-graduation-cap fs-1 mb-3"></i>
                                <h5>No applications ready for final admission</h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $applications->links() }}
        </div>
    </div>
@endsection
