@extends('student.layout')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="text-center">
        <h4 class="mb-4">Redirecting to Secure Payment Gateway...</h4>
        <div class="spinner-border text-info" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        
        <form action="{{ route('student.payment.verify') }}" method="POST" id="razorpay-form">
            @csrf
            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
            <input type="hidden" name="razorpay_signature" id="razorpay_signature">
            <input type="hidden" name="amount" value="{{ $amount * 100 }}">
        </form>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{ $key }}",
        "amount": "{{ $amount * 100 }}",
        "currency": "INR",
        "name": "EduAdmit Pro",
        "description": "Admission Fee Payment",
        "image": "https://cdn-icons-png.flaticon.com/512/2991/2991148.png", // Placeholder logo
        "order_id": "{{ $order_id }}",
        "handler": function (response){
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('razorpay-form').submit();
        },
        "prefill": {
            "name": "{{ $name }}",
            "email": "{{ $email }}"
        },
        "theme": {
            "color": "#ec4899" // Matching the pink accent
        }
    };
    var rzp1 = new Razorpay(options);
    window.onload = function(){
        rzp1.open();
    };
</script>
@endsection
