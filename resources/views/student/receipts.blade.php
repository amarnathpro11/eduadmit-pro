@extends('student.layout')

@section('page_title', 'Download Receipts')

@section('content')
    <h2 class="section-header">My Receipts</h2>

    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="premium-card">
                @forelse($payments as $payment)
                    <div class="receipt-item p-4 mb-3"
                        style="background-color: #1a2234; border-radius: 16px; display: flex; align-items: center; justify-content: space-between; border: 1px solid var(--border-color); transition: transform 0.2s;">
                        <div class="d-flex align-items-center gap-4">
                            <div
                                style="width: 48px; height: 48px; background-color: rgba(255, 255, 255, 0.05); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i data-lucide="file-text" style="width: 24px; color: var(--text-muted);"></i>
                            </div>
                            <div>
                                <h6 class="mb-1"
                                    style="font-family: 'Outfit'; font-weight: 700; font-size: 1.1rem; color: #3b82f6;">
                                    REC-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</h6>
                                <p class="mb-1" style="font-weight: 500; font-size: 0.95rem;">Admission / Course Fee</p>
                                <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                                    {{ $payment->created_at->format('M d, Y') }} • Online</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-5">
                            <h4 class="mb-0" style="font-family: 'Outfit'; font-weight: 700; color: #10b981;">
                                ₹{{ number_format($payment->amount, 2) }}</h4>

                            <a href="{{ route('student.receipt.download', $payment->id) }}" target="_blank"
                                class="btn-pdf-download d-flex align-items-center gap-2"
                                style="background: rgba(255,255,255,0.05); border: 1px solid var(--border-color); color: var(--text-muted); padding: 0.6rem 1.2rem; border-radius: 10px; font-size: 0.9rem; font-weight: 600; text-decoration: none;">
                                <span style="opacity: 0.3;">|</span> PDF
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i data-lucide="info" class="mb-3" style="width: 48px; height: 48px;"></i>
                        <h5>No Receipts Available</h5>
                        <p>You haven't made any payments yet. Completed transactions will appear here.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .receipt-item:hover {
            transform: translateY(-3px) scale(1.01);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-pdf-download:hover {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
    </style>
@endsection
