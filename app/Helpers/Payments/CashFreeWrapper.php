<?php


namespace App\Helpers\Payments;


class CashFreeWrapper
{
    protected $parameters = array();
    protected $signature = '';
    protected $testMode = false;
    protected $appID = '';
    protected $sectetKey = '';
    protected $liveEndPoint = 'https://www.cashfree.com/checkout/post/submit';
    protected $testEndPoint = 'https://test.cashfree.com/billpay/checkout/post/submit';
    public $response = '';


    public function __construct()
    {
        $this->appID = config('services.cashfree.app_id');
        $this->sectetKey = config('services.cashfree.secret');
        $this->testMode = (config('services.cashfree.mode') == 'sandbox' ? true : false);

        $this->parameters['appId'] = $this->appID;
        $this->parameters['orderId'] = $this->generateTransactionID();
        $this->parameters['returnUrl'] = route('cart.cashfree.status');
        $this->parameters['notifyUrl'] = "";
    }

    public function getEndPoint()
    {
        return $this->testMode?$this->testEndPoint:$this->liveEndPoint;
    }

    public function request($parameters)
    {
        $this->parameters = array_merge($this->parameters,$parameters);

        $this->encrypt();

        return $this->send();

    }

    public function send()
    {
        return view('includes.cashfreeForm')
            ->with('parameters',$this->parameters)
            ->with('signature',$this->signature)
            ->with('endPoint',$this->getEndPoint());
    }

    /**
     * Encrypt Function
     *
     */
    protected function encrypt()
    {
        $signatureData = "";
        ksort($this->parameters);
        foreach($this->parameters as $key => $value) {
            $signatureData .= $key.$value;
        }

        $this->signature = hash_hmac('sha256', $signatureData, $this->sectetKey,true);
        $this->signature = base64_encode($this->signature);
    }

    public function generateTransactionID()
    {
        return substr(hash('sha256', mt_rand() . microtime()), 0, 10);
    }

    public function signatureVerification($parameter , $signature)
    {
        $signatureData = '';
        foreach($parameter as $key => $value) {
            $signatureData .= $value;
        }
        $computedSignature = hash_hmac('sha256', $signatureData, $this->sectetKey,true);
        $computedSignature = base64_encode($computedSignature);

        if ($signature == $computedSignature) {
            return true;
        }
        return false;
    }
}
