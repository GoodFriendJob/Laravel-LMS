<?php


namespace App\Helpers\Payments;

use Illuminate\Support\Str;
use Razorpay\Api\Api;

class RazorpayWrapper
{
    private $razorPay;
    public function __construct()
    {
        $this->razorPay = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
    }

    public function order($currency, $amount)
    {
        $receiptId = Str::random(16);
        $order = $this->razorPay->order->create(array('receipt' => $receiptId, 'amount' => $amount, 'currency' => $currency));
        return $order['id'];
    }

    public function verifySignature($attributes)
    {
        try {
            $status = $this->razorPay->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (\Exception $e) {
            \Log::info($e->getMessage() . ' for id = ' . auth()->user()->id);
            return false;
        }
    }
}
