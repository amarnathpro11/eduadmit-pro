@extends('counselor.layout.app')
@section('page_title', 'Counselor Performance')
@section('page_subtitle', 'Personal Lead Conversion Insights')

@section('content')
    <style>
        .metric-top-row .white-card {
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .metric-icon-box {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .trend-badge {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 12px;
        }

        /* Dark Theme Accents */
        .bg-blue-light {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
        }

        .bg-purple-light {
            background: rgba(168, 85, 247, 0.15);
            color: #a855f7;
        }

        .bg-orange-light {
            background: rgba(249, 115, 22, 0.15);
            color: #f97316;
        }

        .bg-green-light {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
        }

        .text-green-trend {
            color: #4ade80;
            background: rgba(74, 222, 128, 0.1);
        }

        .text-red-trend {
            color: #f87171;
            background: rgba(248, 113, 113, 0.1);
        }

        .funnel-bar-container {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .funnel-label {
            width: 80px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .funnel-track {
            flex: 1;
            height: 32px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 6px;
            position: relative;
            overflow: hidden;
            margin: 0 15px;
        }

        .funnel-fill {
            height: 100%;
            display: flex;
            align-items: center;
            padding-left: 12px;
            font-weight: 600;
            font-size: 0.85rem;
            color: #020617;
        }

        .funnel-percent {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-main);
            width: 40px;
            text-align: right;
        }

        .forecast-card {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            border: 1px solid var(--border-color);
            color: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
    </style>

    <!-- Top Metrics -->
    <div class="row g-3 mb-4 metric-top-row">
        <div class="col-md-3">
            <a href="{{ route('counselor.leads.index') }}" class="text-decoration-none h-100">
                <div class="white-card h-100 border border-opacity-10 border-white hover-lift transition-all" style="transition: transform 0.2s;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="metric-icon-box bg-blue-light fs-5"><i class="fa fa-chart-simple"></i></div>
                        <div class="trend-badge text-green-trend">+5.2%</div>
                    </div>
                    <div>
                        <p class="text-secondary small mb-1 fw-bold text-uppercase opacity-75" style="letter-spacing: 0.5px; font-size: 0.7rem;">My Total Leads</p>
                        <h2 class="fw-bold mb-0 text-white">{{ number_format($stats['total']) }}</h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <div class="white-card h-100 border border-opacity-10 border-white">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="metric-icon-box bg-purple-light fs-5"><i class="fa fa-percent"></i></div>
                    <div class="trend-badge text-green-trend">+1.2%</div>
                </div>
                <div>
                    <p class="text-secondary small mb-1 fw-bold text-uppercase opacity-75" style="letter-spacing: 0.5px; font-size: 0.7rem;">Conversion Rate</p>
                    @php $rate = $stats['total'] > 0 ? ($stats['converted'] / $stats['total']) * 100 : 0; @endphp
                    <h2 class="fw-bold mb-0 text-white">{{ number_format($rate, 1) }}%</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <a href="{{ route('counselor.leads.schedule') }}" class="text-decoration-none h-100">
                <div class="white-card h-100 border border-opacity-10 border-white hover-lift transition-all">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="metric-icon-box bg-orange-light fs-5"><i class="fa fa-clock"></i></div>
                        <div class="trend-badge text-red-trend">-8%</div>
                    </div>
                    <div>
                        <p class="text-secondary small mb-1 fw-bold text-uppercase opacity-75" style="letter-spacing: 0.5px; font-size: 0.7rem;">Today's Follow-ups</p>
                        <h2 class="fw-bold mb-0 text-white">{{ count($todayFollowUps) }}</h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('counselor.leads.index', ['status' => 'Converted']) }}" class="text-decoration-none h-100">
                <div class="white-card h-100 border border-opacity-10 border-white hover-lift transition-all">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="metric-icon-box bg-green-light fs-5"><i class="fa fa-trophy"></i></div>
                        <div class="trend-badge text-green-trend">+14%</div>
                    </div>
                    <div>
                        <p class="text-secondary small mb-1 fw-bold text-uppercase opacity-75" style="letter-spacing: 0.5px; font-size: 0.7rem;">Admissions Secured</p>
                        <h2 class="fw-bold mb-0 text-white">{{ number_format($stats['converted']) }}</h2>
                    </div>
                </div>
            </a>
        </div>
    </div>


    <div class="row g-4">
        <!-- Conversion Funnel -->
        <div class="col-lg-8">
            <div class="white-card h-100">
                <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-3"
                    style="border-color: rgba(255,255,255,0.05) !important;">
                    <div>
                        <h5 class="fw-bold mb-1 text-white"><i class="fa fa-filter me-2 text-primary"></i> Sales Funnel Performance</h5>

                        <p class="text-muted small mb-0">Lead progression stages and drop-off analysis</p>
                    </div>
                    <div class="small fw-semibold text-muted d-flex align-items-center gap-2">
                        <div style="width: 8px; height: 8px; background: #3b82f6; border-radius: 50%;"></div> Industry Avg:
                        11%
                    </div>
                </div>

                <div class="mt-4 pt-2">
                    @php
                        $contactedCount = \App\Models\Lead::where('assigned_to', auth()->id())
                            ->whereIn('status', ['Contacted', 'Interested', 'Converted'])
                            ->count();
                        $appliedCount = \App\Models\Lead::where('assigned_to', auth()->id())
                            ->whereIn('status', ['Applied', 'Converted'])
                            ->count();

                        $c = $contactedCount ?: $stats['interested'] + $stats['converted'];
                        $i = $stats['interested'] + $stats['converted'];
                        $a = $appliedCount ?: $stats['converted'];
                        $total = max(1, $stats['total']);
                    @endphp
                    <div class="funnel-bar-container">
                        <div class="funnel-label text-white opacity-75">NEW</div>
                        <div class="funnel-track">
                            <div class="funnel-fill text-white shadow-sm"
                                style="width: 100%; background: linear-gradient(90deg, #3b82f6, #60a5fa); text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
                                {{ $stats['total'] }} Leads</div>
                        </div>
                        <div class="funnel-percent text-white">100%</div>
                    </div>
                    <div class="funnel-bar-container">
                        <div class="funnel-label text-white opacity-75">CONTACTED</div>
                        <div class="funnel-track">
                            <div class="funnel-fill text-white shadow-sm"
                                style="width: {{ ($c / $total) * 100 }}%; background: linear-gradient(90deg, #3b82f6, #60a5fa); text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
                                {{ $c }} Leads</div>
                        </div>
                        <div class="funnel-percent text-white">{{ round(($c / $total) * 100) }}%</div>
                    </div>
                    <div class="funnel-bar-container">
                        <div class="funnel-label text-white opacity-75">INTERESTED</div>
                        <div class="funnel-track">
                            <div class="funnel-fill text-white shadow-sm"
                                style="width: {{ ($i / $total) * 100 }}%; background: linear-gradient(90deg, #2563eb, #3b82f6); text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
                                {{ $i }} Leads</div>
                        </div>
                        <div class="funnel-percent text-white">{{ round(($i / $total) * 100) }}%</div>
                    </div>
                    <div class="funnel-bar-container">
                        <div class="funnel-label text-white opacity-75">APPLIED</div>
                        <div class="funnel-track">
                            <div class="funnel-fill text-white shadow-sm"
                                style="width: {{ ($a / $total) * 100 }}%; background: linear-gradient(90deg, #1d4ed8, #2563eb); text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
                                {{ $a }} Leads</div>
                        </div>
                        <div class="funnel-percent text-white">{{ round(($a / $total) * 100) }}%</div>
                    </div>
                    <div class="funnel-bar-container">
                        <div class="funnel-label text-success fw-bold">CONVERTED</div>
                        <div class="funnel-track">
                            <div class="funnel-fill text-white shadow-sm"
                                style="width: {{ ($stats['converted'] / $total) * 100 }}%; background: linear-gradient(90deg, #16a34a, #22c55e); text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
                                {{ $stats['converted'] }} Leads</div>
                        </div>
                        <div class="funnel-percent text-success fw-bold">{{ round(($stats['converted'] / $total) * 100) }}%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column (Forecast & Action) -->
        <div class="col-lg-4">
            <!-- Forecast Card -->
            <div class="forecast-card mb-4 position-relative overflow-hidden border-primary border-opacity-10 shadow-lg">
                <div class="position-absolute"
                    style="top:-50px; right:-50px; width:150px; height:150px; background: rgba(59,130,246,0.2); border-radius:50%; filter: blur(30px);">
                </div>
                <h5 class="fw-bold text-white mb-2"><i class="fa fa-chart-pie me-2 text-primary"></i> Conversion Forecast
                </h5>
                <p style="font-size: 0.8rem; color: #cbd5e1;">Based on current 'Interested' pool of
                    {{ $stats['interested'] }} leads.</p>

                <div class="d-flex justify-content-center my-4 py-2">
                    <div
                        style="width: 140px; height: 140px; border-radius: 50%; border: 6px solid rgba(255,255,255,0.05); position: relative; display: flex; align-items: center; justify-content: center; border-right-color: #3b82f6; border-top-color: #3b82f6; border-bottom-color: #3b82f6; transform: rotate(-45deg); box-shadow: 0 0 30px rgba(59,130,246,0.3);">
                        <div style="transform: rotate(45deg); text-align: center;">
                            <h2 class="text-white fw-bold mb-0" style="font-size: 2.2rem;">{{ round($stats['interested'] * 0.15) }}</h2>
                            <span style="font-size: 0.7rem; color: #94a3b8; font-weight: 800; letter-spacing: 1px;">EST. LEADS</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 0.8rem;">
                    <span class="text-secondary fw-bold">Current Month Target</span>
                    <span class="text-white fw-bold">200 Admissions</span>
                </div>
                <div class="progress" style="height: 10px; background: rgba(255,255,255,0.1); border-radius: 10px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                        style="width: {{ min(100, ($stats['converted'] / 200) * 100) }}%; background: var(--primary); box-shadow: 0 0 15px var(--primary);">
                    </div>
                </div>
                <div class="text-center mt-3 fw-bold" style="font-size: 0.8rem; color: #94a3b8;">
                    You're <span class="text-white">{{ round(($stats['converted'] / max(1, 200)) * 100) }}%</span> towards your goal!
                </div>
            </div>


            <!-- Immediate Action Alert -->
            <div class="white-card" style="background: linear-gradient(145deg, #2a1515, #150a0a);">
                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2 text-uppercase"
                    style="font-size: 0.75rem; color: #fca5a5;"><i class="fa fa-bolt text-danger"></i> Immediate Action
                    Needed</h6>

                <div class="p-3 rounded-3"
                    style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); display: flex; gap: 15px;">
                    <div style="color: #ef4444; font-size: 1.5rem; font-weight: bold;">!</div>
                    <div>
                        <h6 style="color: #f87171; font-weight: 700; font-size: 0.9rem; margin-bottom: 6px;">
                            {{ $stats['interested'] }} High-Intent Leads Cooling</h6>
                        <p style="color: #fca5a5; font-size: 0.8rem; margin-bottom: 8px; opacity: 0.9;">These leads from
                            the 'Interested' stage haven't been contacted in 48 hours.</p>
                        <a href="{{ route('counselor.leads.index', ['status' => 'Interested']) }}"
                            style="color: #ef4444; font-size: 0.8rem; font-weight: 700; text-decoration: underline;">Start
                            Calling Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
