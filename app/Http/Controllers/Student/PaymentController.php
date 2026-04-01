<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
  private $api;

  public function __construct()
  {
    $this->api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
  }

  public function receipts()
  {
    $payments = Payment::where('user_id', Auth::guard('student')->id())->get();
    return view('student.receipts', compact('payments'));
  }

  public function payment(Request $request)
  {
    $user = Auth::guard('student')->user();
    $application = Application::where('user_id', $user->id)->with('course')->first();

    $query = Payment::where('user_id', $user->id);

    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    if ($request->filled('search')) {
      $query->where('transaction_id', 'like', '%' . $request->search . '%');
    }

    $payments = $query->latest()->get();

    return view('student.payment', compact('application', 'payments'));
  }

  public function processPayment(Request $request)
  {
    $input = $request->all();

    // Create Order
    $orderData = [
      'receipt'         => 'rcpt_' . time(),
      'amount'          => $input['amount'] * 100, // in paise
      'currency'        => 'INR',
      'payment_capture' => 1 // auto capture
    ];

    $razorpayOrder = $this->api->order->create($orderData);

    Session::put('razorpay_order_id', $razorpayOrder['id']);

    $user = Auth::guard('student')->user();

    return view('student.checkout', [
      'order_id' => $razorpayOrder['id'],
      'amount'   => $input['amount'],
      'key'      => config('services.razorpay.key'),
      'name'     => $user ? $user->name : 'Student',
      'email'    => $user ? $user->email : 'student@example.com',
    ]);
  }

  public function verifyPayment(Request $request)
  {
    $success = true;
    $error = "Payment Failed";

    if (empty($request->razorpay_payment_id) === false) {
      try {
        $attributes = [
          'razorpay_order_id' => Session::get('razorpay_order_id'),
          'razorpay_payment_id' => $request->razorpay_payment_id,
          'razorpay_signature' => $request->razorpay_signature
        ];

        $this->api->utility->verifyPaymentSignature($attributes);
      } catch (\Exception $e) {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
      }
    }

    if ($success === true) {
      Payment::create([
        'user_id' => Auth::guard('student')->id(),
        'transaction_id' => $request->razorpay_payment_id,
        'amount' => $request->amount / 100,
        'status' => 'success',
      ]);

      // Update application status to confirmed
      $app = Application::where('user_id', Auth::guard('student')->id())->first();
      if ($app) {
          $app->update(['status' => 'confirmed']);
      }

      return redirect()->route('student.receipts')->with('success', 'Payment successful.');
    } else {
      return redirect()->route('student.payment')->with('error', $error);
    }
  }

  public function downloadReceipt($id)
  {
    $payment = Payment::where('id', $id)
      ->where('user_id', Auth::guard('student')->id())
      ->firstOrFail();

    $user = Auth::guard('student')->user();
    $application = Application::where('user_id', $user->id)->with('course')->first();

    $pdf = Pdf::loadView('student.receipt-pdf', compact('payment', 'user', 'application'));

    return $pdf->download('Receipt_REC-' . str_pad($payment->id, 5, '0', STR_PAD_LEFT) . '.pdf');
  }
}
