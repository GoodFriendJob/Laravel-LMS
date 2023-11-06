<?php


namespace App\Helpers\Payments;




use Illuminate\Support\Facades\Redirect;

class InstamojoWrapper
{
    const API_VERSION         = '1.1';
    const TEST_BASE_URL       = 'https://test.instamojo.com/api/'.self::API_VERSION;
    const PRODUCTION_BASE_URL = 'https://www.instamojo.com/api/'.self::API_VERSION;
    private $url;
    private $http_code;
    private $error_message;

    /**
     * InstamojoWrapper constructor.
     */
    public function __construct()
    {
        $this->url = (config('services.instamojo.mode') == 'sandbox')? self::TEST_BASE_URL: self::PRODUCTION_BASE_URL;
    }

    public function pay($cartdata)
    {
        try {
            $response = $this->api_request($cartdata);
            if($response->success == true){
                return Redirect::away($response->payment_request->longurl);
            }else{
                \Log::info(json_encode($this->error_message, true) . ' for id = ' . auth()->user()->id);
                \Session::put('failure', trans('labels.frontend.cart.unknown_error'));
                return Redirect::route('cart.instamojo.status');
            }
        }
        catch (\Exception $e) {
            \Log::info($e->getMessage() . ' for id = ' . auth()->user()->id);
        }
    }


    private function api_request($payload)
    {
        $headers = array("X-Api-Key:".config('services.instamojo.key'),
            "X-Auth-Token:".config('services.instamojo.secret'));

        $request_url = $this->url.'/payment-requests/';
        $options = array();
        $options[CURLOPT_URL] = $request_url;
        $options[CURLOPT_HEADER] = false;
        $options[CURLOPT_RETURNTRANSFER] = true;
        $options[CURLOPT_FOLLOWLOCATION] = true;
        $options[CURLOPT_HTTPHEADER] = $headers;
        $options[CURLOPT_POST] = true;
        $options[CURLOPT_POSTFIELDS] = http_build_query($payload);
        $options[CURLOPT_SSL_VERIFYPEER] = false;
        $curl_request = curl_init();
        $setopt = curl_setopt_array($curl_request, $options);
        $response = curl_exec($curl_request);

        $this->http_code = curl_getinfo($curl_request, CURLINFO_HTTP_CODE);

        $this->error_message = curl_error($curl_request);
        return json_decode($response);
    }


}
