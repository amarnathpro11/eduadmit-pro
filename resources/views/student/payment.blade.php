@extends('student.layout')

@section('page_title', 'Fee Payment')

@section('content')
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="section-header mb-1">Fee Payment & Receipts</h2>
            <p class="text-secondary mb-0">Securely manage your academic financial obligations and download official
                documentation.</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-7">
            <div class="premium-card h-100">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        @php
                            $admissionFee = $application->course->admission_fee ?? 45000;
                            $labFee = 100;
                            $baseTotal = $admissionFee + $labFee;
                            $isPaid = false;
                            if (isset($payments)) {
                                $isPaid = $payments->where('status', 'success')->sum('amount') >= $baseTotal;
                            }
                            $totalBalance = $isPaid ? 0 : $baseTotal;

                            $offerDate = $application->updated_at ?? now();
                            $dueDate = \Carbon\Carbon::parse($offerDate)->addDays(7);
                            $daysRemaining = max(0, ceil(now()->diffInDays($dueDate, false)));
                        @endphp
                        <p class="text-black fw-bold mb-1"
                            style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Total Outstanding
                            Balance</p>
                        <h2 class="fw-bold" style="font-family: 'Outfit'; font-size: 2.5rem; color: #ffffff;">
                            ₹{{ number_format($totalBalance, 2) }}</h2>
                    </div>
                    @if ($isPaid)
                        <div class="badge bg-success bg-opacity-10 text-success px-3 py-2"
                            style="border-radius: 8px; font-weight: 700;">
                            <i data-lucide="check-circle" class="me-1" style="width: 14px;"></i> Paid Successfully
                        </div>
                    @else
                        <div class="badge bg-warning bg-opacity-10 text-warning px-3 py-2"
                            style="border-radius: 8px; font-weight: 700;">
                            <i data-lucide="clock" class="me-1" style="width: 14px;"></i> Due in {{ $daysRemaining }} Days
                        </div>
                    @endif
                </div>


                <h6 class="fw-bold mb-3 text-white">Fee Breakdown
                    ({{ $application->course->name ?? 'Course Not Selected' }})</h6>
                <div class="list-group list-group-flush mb-4">
                    <div class="list-group-item px-0 py-3 d-flex justify-content-between border-bottom border-light"
                        style="background: transparent;">
                        <span class="text-white fw-medium">Admission Fee (Fall 2026)</span>
                        <span class="fw-bold text-white">₹{{ number_format($admissionFee, 2) }}</span>
                    </div>
                    <div class="list-group-item px-0 py-3 d-flex justify-content-between border-0"
                        style="background: transparent;">
                        <span class="text-white fw-medium">Lab & Library Maintenance</span>
                        <span class="fw-bold text-white">₹{{ number_format($labFee, 2) }}</span>
                    </div>
                </div>

                <div
                    class="p-3 bg-success bg-opacity-5 border border-success border-opacity-10 rounded-4 d-flex align-items-center gap-3">
                    <div
                        style="width: 24px; height: 24px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                        <i data-lucide="shield-check" style="width: 14px;"></i>
                    </div>
                    <p class="mb-0 text-dark fw-semibold" style="font-size: 0.8rem;">Payments are encrypted</p>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="premium-card h-100">
                @if ($isPaid)
                    <div class="d-flex flex-column justify-content-center align-items-center h-100 text-center p-4">
                        <div class="mb-4"
                            style="width: 80px; height: 80px; background: rgba(16, 185, 129, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i data-lucide="check-circle" style="width: 40px; height: 40px; color: #10b981;"></i>
                        </div>
                        <h4 class="fw-bold text-white mb-2" style="font-family: 'Outfit';">Payment Complete</h4>
                        <p class="text-white-50 mb-4" style="font-size: 0.95rem;">You have successfully cleared your
                            admission fees. Your enrollment is being finalized.</p>
                        <a href="{{ route('student.receipts') }}" class="btn-premium-outline">
                            View Receipts
                        </a>
                    </div>
                @else
                    <h5 class="fw-bold mb-4 text-white" style="font-family: 'Outfit';">Select Payment Method</h5>
                    <form action="{{ route('student.payment.process') }}" method="POST" id="payment-form">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $totalBalance }}">
                        <input type="hidden" name="payment_method" id="selected_payment_method" value="upi">

                        <div class="payment-group mb-3">
                            <div class="payment-method-card p-3 d-flex align-items-center gap-3 selected"
                                onclick="selectMethod(this, 'upi')"
                                style="border: 2px solid #6366f1; border-radius: 16px; background: rgba(99, 102, 241, 0.05); cursor: pointer;">
                                <div class="icon-box"
                                    style="width: 44px; height: 44px; background: rgba(255,255,255,0.05); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #6366f1; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                    <i data-lucide="qr-code" style="width: 20px;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold text-white">UPI Payment</h6>
                                    <p class="mb-0 text-white-50" style="font-size: 0.75rem;">GPay, PhonePe, Paytm</p>
                                </div>
                                <div class="check-box"
                                    style="width: 20px; height: 20px; background: #6366f1; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                    <i data-lucide="check" style="width: 12px;"></i>
                                </div>
                            </div>
                            <div class="payment-details p-3 mt-2" id="details-upi"
                                style="background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                                <label class="text-white-50 mb-2" style="font-size: 0.8rem;">Enter UPI ID</label>
                                <input type="text" name="upi_id" class="form-control" placeholder="username@bank"
                                    style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: white;">
                            </div>
                        </div>

                        <div class="payment-group mb-3">
                            <div class="payment-method-card p-3 d-flex align-items-center gap-3"
                                onclick="selectMethod(this, 'card')"
                                style="border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; transition: all 0.2s; cursor: pointer;">
                                <div class="icon-box"
                                    style="width: 44px; height: 44px; background: rgba(255,255,255,0.05); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.6); box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                    <i data-lucide="credit-card" style="width: 20px;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold text-white">Credit / Debit Card</h6>
                                    <p class="mb-0 text-white-50" style="font-size: 0.75rem;">Visa, Mastercard, RuPay</p>
                                </div>
                                <div class="check-box d-none"
                                    style="width: 20px; height: 20px; background: #6366f1; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                    <i data-lucide="check" style="width: 12px;"></i>
                                </div>
                            </div>
                            <div class="payment-details p-3 mt-2 d-none" id="details-card"
                                style="background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                                <div class="mb-3">
                                    <label class="text-white-50 mb-2" style="font-size: 0.8rem;">Card Number</label>
                                    <input type="text" name="card_number" class="form-control"
                                        placeholder="0000 0000 0000 0000"
                                        style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: white;">
                                </div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="text-white-50 mb-2" style="font-size: 0.8rem;">Expiry Date</label>
                                        <input type="text" name="card_expiry" class="form-control"
                                            placeholder="MM/YY"
                                            style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: white;">
                                    </div>
                                    <div class="col-6">
                                        <label class="text-white-50 mb-2" style="font-size: 0.8rem;">CVV</label>
                                        <input type="text" name="card_cvv" class="form-control" placeholder="123"
                                            style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: white;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="payment-group mb-4">
                            <div class="payment-method-card p-3 d-flex align-items-center gap-3"
                                onclick="selectMethod(this, 'netbanking')"
                                style="border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; transition: all 0.2s; cursor: pointer;">
                                <div class="icon-box"
                                    style="width: 44px; height: 44px; background: rgba(255,255,255,0.05); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.6); box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                    <i data-lucide="building" style="width: 20px;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold text-white">Net Banking</h6>
                                    <p class="mb-0 text-white-50" style="font-size: 0.75rem;">All major banks supported
                                    </p>
                                </div>
                                <div class="check-box d-none"
                                    style="width: 20px; height: 20px; background: #6366f1; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                    <i data-lucide="check" style="width: 12px;"></i>
                                </div>
                            </div>
                            <div class="payment-details p-3 mt-2 d-none" id="details-netbanking"
                                style="background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                                <label class="text-white-50 mb-2" style="font-size: 0.8rem;">Select Bank</label>
                                <select class="form-select" name="bank_name"
                                    style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: white;">
                                    <option value="" style="color: #000;">Choose your bank...</option>
                                    <option value="sbi" style="color: #000;">State Bank of India</option>
                                    <option value="hdfc" style="color: #000;">HDFC Bank</option>
                                    <option value="icici" style="color: #000;">ICICI Bank</option>
                                    <option value="axis" style="color: #000;">Axis Bank</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit"
                            class="btn-premium-primary w-100 py-3 d-flex align-items-center justify-content-center gap-2"
                            style="font-size: 1.1rem; border: none; transition: 0.3s; box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);">
                            <i data-lucide="shield" style="width: 20px;"></i>
                            PROCEED TO PAY ₹{{ number_format($totalBalance, 2) }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-end mb-4">
        <h3 class="fw-bold text-white" style="font-family: 'Outfit';">Payment History</h3>
        <button class="btn-premium-outline py-2 {{ request()->hasAny(['search', 'status']) ? 'border-primary' : '' }}" 
                style="font-size: 0.85rem;" onclick="toggleFilters()">
            <i data-lucide="filter" class="me-2" style="width: 16px;"></i> Filter
            @if(request()->hasAny(['search', 'status']))
                <span class="ms-1 badge bg-primary" style="font-size: 0.6rem;">Active</span>
            @endif
        </button>
    </div>

    <div id="filter-section" class="premium-card mb-4 {{ request()->hasAny(['search', 'status']) ? '' : 'd-none' }}" 
         style="padding: 1.5rem; background: rgba(255, 255, 255, 0.05); border: 1px dashed rgba(99, 102, 241, 0.3);">
        <form action="{{ route('student.payment') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label-custom mb-2">SEARCH TRANSACTION</label>
                <div class="position-relative">
                    <i data-lucide="search" class="position-absolute translate-middle-y top-50 ms-3 text-muted" style="width: 16px;"></i>
                    <input type="text" name="search" class="form-control-premium ps-5" placeholder="Enter transaction ID..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label-custom mb-2">STATUS</label>
                <select name="status" class="form-control-premium">
                    <option value="">All Transactions</option>
                    <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success Only</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed Only</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Only</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn-premium-primary flex-grow-1 py-2" style="font-size: 0.85rem; height: 48px;">
                    Apply Filter
                </button>
                <a href="{{ route('student.payment') }}" class="btn-premium-outline d-flex align-items-center justify-content-center" 
                   style="width: 48px; height: 48px;" title="Reset Filters">
                    <i data-lucide="rotate-ccw" style="width: 18px;"></i>
                </a>
            </div>
        </form>
    </div>

    <div class="premium-card p-0 overflow-hidden">
        <table class="table table-dark table-hover mb-0">
            <thead style="background-color: rgba(255, 255, 255, 0.05);">
                <tr>
                    <th class="ps-4 py-3 text-muted fw-bold"
                        style="font-size: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.1);">DATE</th>
                    <th class="py-3 text-muted fw-bold"
                        style="font-size: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.1);">RECEIPT NO.</th>
                    <th class="py-3 text-muted fw-bold"
                        style="font-size: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.1);">DESCRIPTION</th>
                    <th class="py-3 text-muted fw-bold"
                        style="font-size: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.1);">AMOUNT</th>
                    <th class="py-3 text-muted fw-bold"
                        style="font-size: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.1);">STATUS</th>
                    <th class="pe-4 py-3 text-muted fw-bold"
                        style="font-size: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.1);">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td class="ps-4 py-4 fw-medium text-white-50">{{ $payment->created_at->format('M d, Y') }}</td>
                        <td class="py-4 fw-bold text-white">#TID-{{ $payment->transaction_id }}</td>
                        <td class="py-4 text-white">Course Fee Payment</td>
                        <td class="py-4 fw-bold text-white">₹{{ number_format($payment->amount, 2) }}</td>
                        <td class="py-4">
                            <div class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill"
                                style="font-size: 0.7rem;">
                                <i data-lucide="check-circle" class="me-1"
                                    style="width: 12px; vertical-align: middle;"></i>
                                {{ strtoupper($payment->status) }}
                            </div>
                        </td>
                        <td class="pe-4 py-4 text-end">
                            <button onclick="window.print()" class="btn btn-sm btn-outline-success border-0 fw-bold"
                                style="font-size: 0.8rem;">
                                <i data-lucide="download" class="me-1" style="width: 14px;"></i> PDF
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i data-lucide="database" class="mb-2"
                                style="width: 32px; height: 32px; color: #6366f1;"></i>
                            <p class="mb-0 text-dark">No payment records found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5 text-center text-muted" style="font-size: 0.8rem;">
        <div class="d-flex align-items-center justify-content-center gap-2 mb-2 text-secondary">
            <i data-lucide="lock" style="width: 14px;"></i>
            <span>Secure SSL Encrypted Payment Portal</span>
        </div>
        <p class="mb-0 text-secondary">© 2026 EduAdmit Pro | All rights reserved.</p>
    </div>

    <style>
        .payment-method-card:hover {
            border-color: #6366f1 !important;
            background: rgba(99, 102, 241, 0.08) !important;
            transform: scale(1.02);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.02) !important;
        }
    </style>

    <script>
        function toggleFilters() {
            const filterSection = document.getElementById('filter-section');
            if (filterSection.classList.contains('d-none')) {
                filterSection.classList.remove('d-none');
                filterSection.style.animation = 'fadeInDown 0.3s ease-out';
            } else {
                filterSection.classList.add('d-none');
            }
        }

        function selectMethod(element, type) {
            // Reset all method cards
            document.querySelectorAll('.payment-method-card').forEach(card => {
                card.style.border = '1px solid rgba(255,255,255,0.1)';
                card.style.background = 'transparent';
                card.querySelector('.icon-box').style.color = 'rgba(255,255,255,0.6)';
                const check = card.querySelector('.check-box');
                if (check) check.classList.add('d-none');
            });

            // Hide all details (inputs)
            document.querySelectorAll('.payment-details').forEach(detail => {
                detail.classList.add('d-none');
            });

            // Highlight selected method card
            element.style.border = '2px solid #6366f1';
            element.style.background = 'rgba(99, 102, 241, 0.05)';
            element.querySelector('.icon-box').style.color = '#6366f1';
            const check = element.querySelector('.check-box');
            if (check) check.classList.remove('d-none');

            // Show relevant details
            const targetDetails = document.getElementById('details-' + type);
            if (targetDetails) {
                targetDetails.classList.remove('d-none');
            }

            // Set the hidden input value
            document.getElementById('selected_payment_method').value = type;
        }

        document.getElementById('payment-form').addEventListener('submit', function(e) {
            const method = document.getElementById('selected_payment_method').value;
            let isValid = true;
            let errorMessage = '';

            if (method === 'upi') {
                const upiInput = document.querySelector('input[name="upi_id"]').value;
                if (!upiInput) {
                    isValid = false;
                    errorMessage = 'Please enter a valid UPI ID to proceed.';
                }
            } else if (method === 'card') {
                const cardNum = document.querySelector('input[name="card_number"]').value;
                const cardExp = document.querySelector('input[name="card_expiry"]').value;
                const cardCvv = document.querySelector('input[name="card_cvv"]').value;
                if (!cardNum || !cardExp || !cardCvv) {
                    isValid = false;
                    errorMessage = 'Please fill out all Credit/Debit Card details.';
                }
            } else if (method === 'netbanking') {
                const bank = document.querySelector('select[name="bank_name"]').value;
                if (!bank) {
                    isValid = false;
                    errorMessage = 'Please select your bank for Net Banking.';
                }
            }

            if (!isValid) {
                e.preventDefault();
                alert(errorMessage);
            }
        });
    </script>
@endsection
