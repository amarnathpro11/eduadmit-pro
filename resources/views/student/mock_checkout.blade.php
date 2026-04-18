@extends('student.layout')

@section('page_title', 'Mock Payment Gateway')

@section('content')
<style>
    .mock-payment-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        padding: 3rem;
        max-width: 500px;
        margin: 4rem auto;
        text-align: center;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
    .payment-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        font-size: 2rem;
        color: white;
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
    }
    .amount-display {
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
        margin-bottom: 0.5rem;
        font-family: 'Outfit';
    }
    .order-id {
        font-family: monospace;
        background: rgba(255, 255, 255, 0.05);
        padding: 4px 12px;
        border-radius: 8px;
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.8rem;
    }
    .btn-mock {
        padding: 1rem 2rem;
        border-radius: 14px;
        font-weight: 700;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 100%;
        margin-bottom: 1rem;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }
    .btn-mock-success {
        background: #10b981;
        color: white;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
    }
    .btn-mock-success:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }
    .btn-mock-fail {
        background: rgba(255, 255, 255, 0.05);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }
    .btn-mock-fail:hover {
        background: rgba(239, 68, 68, 0.1);
        border-color: #ef4444;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 2rem;
    }
    .error-alert {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #fca5a5;
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        font-size: 0.85rem;
        text-align: left;
    }
</style>

<div class="mock-payment-card">
    <div class="status-badge">
        <span style="width: 8px; height: 8px; border-radius: 50%; background: #f59e0b; animation: pulse 2s infinite;"></span>
        Environment: Development (Mock Mode)
    </div>

    @if(isset($error))
    <div class="error-alert">
        <div class="fw-bold mb-1"><i class="fa fa-triangle-exclamation me-2"></i> Razorpay Connection Blocked</div>
        {{ $error }}
        <div class="mt-2 text-muted" style="font-size: 0.75rem;">Seamlessly switched to Mock Mode to keep your workflow uninterrupted.</div>
    </div>
    @endif

    <div class="payment-icon">
        <i class="fa fa-shield-halved"></i>
    </div>

    <div class="amount-display">₹{{ number_format($amount, 2) }}</div>
    <div class="order-id mb-5">{{ $order_id }}</div>

    <div class="text-start mb-4">
        <div class="text-muted small fw-bold text-uppercase mb-3">Choose Outcome</div>
        
        <form action="{{ route('student.payment.verify') }}" method="POST">
            @csrf
            <input type="hidden" name="amount" value="{{ $amount * 100 }}">
            <input type="hidden" name="razorpay_order_id" value="{{ $order_id }}">
            <input type="hidden" name="razorpay_payment_id" value="mock_pay_success">
            <input type="hidden" name="razorpay_signature" value="mock_sig_123">
            <button type="submit" class="btn-mock btn-mock-success">
                <i class="fa fa-check-circle"></i> Complete Payment (Success)
            </button>
        </form>

        <form action="{{ route('student.payment.verify') }}" method="POST">
            @csrf
            <input type="hidden" name="amount" value="{{ $amount * 100 }}">
            <input type="hidden" name="razorpay_order_id" value="{{ $order_id }}">
            <input type="hidden" name="razorpay_payment_id" value="mock_pay_fail">
            <button type="submit" class="btn-mock btn-mock-fail">
                <i class="fa fa-times-circle"></i> Cancel Payment (Failure)
            </button>
        </form>
    </div>

    <p class="text-muted mb-0" style="font-size: 0.75rem;">
        This mock gateway allows testing the end-to-end admission workflow when external APIs are unconfigured or blocked by domain security.
    </p>
</div>
@endsection
