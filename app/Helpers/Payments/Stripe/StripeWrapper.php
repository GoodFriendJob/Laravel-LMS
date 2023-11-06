<?php


namespace App\Helpers\Payments\Stripe;


use Stripe\StripeClient;

class StripeWrapper
{
    /**
     * @var StripeClient
     */
    private $stripe;
    /**
     * StripePlanWrapper constructor.
     */
    public function __construct()
    {
        $this->stripe = $this->init();
    }


    public function init()
    {
        if(config('services.stripe.secret')) {
            return new StripeClient(config('services.stripe.secret'));
        }
        return ;
    }

    /**
     * @return \Stripe\Collection
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function listProduct()
    {
        return $this->stripe->products->all();
    }

    /**
     * @param $request
     * @return \Stripe\Product
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createProduct($request)
    {
        return $this->stripe->products->create($request);
    }


    /**
     * @param $id
     * @return \Stripe\Product
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function editProduct($id)
    {
        return $this->stripe->products->retrieve($id);
    }


    /**
     * @param $id
     * @param $request
     * @return \Stripe\Product
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function updateProduct($id, $request)
    {
        return $this->stripe->products->update($id,$request);
    }


    /**
     * @param $id
     * @return \Stripe\Product
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function deleteProduct($id)
    {
        return $this->stripe->products->delete($id,[]);
    }

    public function listPlan()
    {
        return $this->stripe->plans->all();
    }

    /**
     * @param $request
     * @return \Stripe\Plan
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createPlan($request)
    {
        $request['amount'] = $this->amountFix($request['amount'], $request['currency']);
        return $this->stripe->plans->create($request);
    }

    /**
     * @param $id
     * @return \Stripe\Plan
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function editPlan($id)
    {
        return $this->stripe->plans->retrieve($id);
    }

    /**
     * @param $id
     * @param $request
     * @return \Stripe\Plan
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function updatePlan($id, $request)
    {
        return $this->stripe->plans->update($id,$request);
    }

    /**
     * @param $id
     * @return \Stripe\Plan
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function deletePlan($id)
    {
        return $this->stripe->plans->delete($id,[]);
    }


    private function amountFix($amount, $currency)
    {
        if(in_array($currency,['bif','clp','djf','gnf','jpy','kmf','krw','mga','pyg','rwf','ugx','vnd','vuv','xaf','xof','xpf']))
        {
            $amount = number_format(ceil($amount) , 0, '', '');
        }
        else
        {
            $amount = number_format(($amount*100) , 0, '', '');
        }

        return $amount;
    }
}
