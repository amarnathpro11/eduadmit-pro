@extends('counselor.layout.app')
@section('page_title', 'My Lead Pool')
@section('page_subtitle', 'View all your assigned opportunities')

@section('content')
    <div class="white-card mb-4" style="padding: 16px 24px;">
        <form action="{{ route('counselor.leads.index') }}" method="GET" class="d-flex gap-3 align-items-center">
            <div style="flex: 1;">
                <div class="position-relative">
                    <i class="fa fa-search text-muted position-absolute" style="left: 15px; top: 12px;"></i>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Search by name, email or phone..." style="padding-left: 40px;">
                </div>
            </div>
            <div style="width: 200px;">
                <select name="status" class="form-select shadow-sm">
                    <option value="All" {{ request('status') == 'All' ? 'selected' : '' }}>All Status</option>
                    @foreach (['New', 'Interested', 'Converted', 'Lost'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>
                            {{ $st }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary px-4 fw-bold shadow-sm" style="border-radius: 8px;" type="submit">Filter
                Leads</button>
            <a href="{{ route('counselor.leads.index') }}"
                class="btn btn-dark px-4 fw-bold text-muted shadow-sm border border-secondary border-opacity-25"
                style="border-radius: 8px;">Clear</a>
        </form>
    </div>

    <div class="white-card p-0 shadow-sm border-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0"
                style="--bs-table-bg: transparent; --bs-table-hover-bg: rgba(255,255,255,0.02)">
                <thead style="background: rgba(255,255,255,0.02);">
                    <tr>
                        <th class="px-4 py-3 border-bottom border-secondary border-opacity-25 text-white"
                            style="font-weight: 600; font-size: 0.8rem; text-transform: uppercase;">Lead Details</th>
                        <th class="py-3 border-bottom border-secondary border-opacity-25 text-white"
                            style="font-weight: 600; font-size: 0.8rem; text-transform: uppercase;">Contact Info</th>
                        <th class="py-3 border-bottom border-secondary border-opacity-25 text-white"
                            style="font-weight: 600; font-size: 0.8rem; text-transform: uppercase;">Course Interest</th>
                        <th class="py-3 border-bottom border-secondary border-opacity-25 text-white"
                            style="font-weight: 600; font-size: 0.8rem; text-transform: uppercase;">Pipeline Status</th>
                        <th class="px-4 py-3 text-end border-bottom border-secondary border-opacity-25 text-white"
                            style="font-weight: 600; font-size: 0.8rem; text-transform: uppercase;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $l)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); cursor: pointer;" 
                            onclick="if(!event.target.closest('a')) window.location='{{ route('counselor.leads.show', $l->id) }}'">
                            <td class="px-4 py-3 border-0">
                                <div class="d-flex align-items-center text-white">
                                    <div class="text-white d-flex align-items-center justify-content-center fw-bold rounded-circle me-3"
                                        style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), #1d4ed8);">
                                        {{ substr($l->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0 fs-6">{{ $l->name }}</h6>
                                        <small class="text-muted fw-semibold">Added
                                            {{ $l->created_at->format('M d, Y') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 border-0">
                                <a href="mailto:{{ $l->email }}" class="text-white text-decoration-none fw-medium d-block mb-1 hover-primary" style="font-size: 0.85rem;" onclick="event.stopPropagation()">
                                    <i class="fa fa-envelope text-muted opacity-50 me-2"></i>{{ $l->email }}
                                </a>
                                <a href="tel:{{ $l->phone }}" class="text-white text-decoration-none fw-medium d-block hover-primary" style="font-size: 0.85rem;" onclick="event.stopPropagation()">
                                    <i class="fa fa-phone text-muted opacity-50 me-2"></i>{{ $l->phone }}
                                </a>
                            </td>
                            <td class="py-3 border-0">
                                <span
                                    class="badge bg-dark border border-secondary border-opacity-25 text-white px-2 py-1 fw-bold">{{ $l->course->name ?? 'Any Course' }}</span>
                            </td>
                            <td class="py-3 border-0">
                                @php
                                    $statusColors = [
                                        'New' => 'primary',
                                        'Interested' => 'warning',
                                        'Converted' => 'success',
                                        'Lost' => 'danger',
                                    ];
                                    $color = $statusColors[$l->status] ?? 'secondary';
                                @endphp
                                <span
                                    class="badge bg-{{ $color }} bg-opacity-10 border border-{{ $color }} border-opacity-25 text-{{ $color }} px-3 py-2 fw-bold"
                                    style="border-radius: 6px;">
                                    <i class="fa fa-circle"
                                        style="font-size: 6px; vertical-align: middle; margin-right: 4px;"></i>
                                    {{ strtoupper($l->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-end border-0">
                                <a href="{{ route('counselor.leads.show', $l->id) }}"
                                    class="btn btn-sm btn-dark border border-secondary border-opacity-50 fw-bold text-light rounded-3 px-3">
                                    View Profile
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-5 text-center text-muted fw-semibold border-0"><i
                                    class="fa fa-box-open fs-2 mb-3 opacity-25 d-block"></i> No leads matched your filter
                                criteria in the pool.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($leads->hasPages())
            <div class="p-3 border-top border-secondary border-opacity-25" style="background: rgba(255,255,255,0.01);">
                {{ $leads->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
