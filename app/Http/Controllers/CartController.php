<?php

namespace App\Http\Controllers;

use App\Helpers\General\EarningHelper;
use App\Helpers\Payments\CashFreeWrapper;
use App\Helpers\Payments\InstamojoWrapper;
use App\Helpers\Payments\PayuMoneyWrapper;
use App\Helpers\Payments\RazorpayWrapper;
use App\Mail\Frontend\AdminOrederMail;
use App\Mail\OfflineOrderMail;
use App\Models\Auth\User;
use App\Models\Bundle;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Time_limit;
use App\Models\Tax;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use KingFlamez\Rave\Facades\Rave;
use Omnipay\Omnipay;

class CartController extends Controller
{

    private $path;
    private $currency;

    public function __construct()
    {
        $path = 'frontend';
        if (session()->has('display_type')) {
            if (session('display_type') == 'rtl') {
                $path = 'frontend-rtl';
            } else {
                $path = 'frontend';
            }
        } else if (config('app.display_type') == 'rtl') {
            $path = 'frontend-rtl';
        }
        $this->path = $path;
        $this->currency = getCurrency(config('app.currency'));


    }

    public function index(Request $request)
    {
        $ids = Cart::session(auth()->user()->id)->getContent()->keys();
        $course_ids = [];
        $bundle_ids = [];
        foreach (Cart::session(auth()->user()->id)->getContent() as $item) {
            if ($item->attributes->type == 'bundle') {
                $bundle_ids[] = $item->id;
            } else {
                $course_ids[] = $item->id;
            }
        }
        $courses = new Collection(Course::find($course_ids));
        $bundles = Bundle::find($bundle_ids);
        $courses = $bundles->merge($courses);

        $total = $courses->sum('price');
        //Apply Tax
        $taxData = $this->applyTax('total');


        return view($this->path . '.cart.checkout', compact('courses', 'bundles', 'total', 'taxData'));
    }

    public function addToCart(Request $request)
    {
        $product = "";
        $teachers = "";
        $type = "";
        if ($request->has('course_id')) {
            $product = Course::findOrFail($request->get('course_id'));
            $teachers = $product->teachers->pluck('id', 'name');
            $type = 'course';

        } elseif ($request->has('bundle_id')) {
            $product = Bundle::findOrFail($request->get('bundle_id'));
            $teachers = $product->user->name;
            $type = 'bundle';
        }

        $cart_items = Cart::session(auth()->user()->id)->getContent()->keys()->toArray();
        if (!in_array($product->id, $cart_items)) {
            Cart::session(auth()->user()->id)
                ->add($product->id, $product->title, $product->price, 1,
                    [
                        'user_id' => auth()->user()->id,
                        'description' => $product->description,
                        'image' => $product->course_image,
                        'type' => $type,
                        'teachers' => $teachers
                    ]);
        }


        Session::flash('success', trans('labels.frontend.cart.product_added'));
        return back();
    }

    public function checkout(Request $request)
    {
        $product = "";
        $teachers = "";
        $type = "";
        $bundle_ids = [];
        $course_ids = [];
        if ($request->has('course_id')) {
            $product = Course::findOrFail($request->get('course_id'));
            $teachers = $product->teachers->pluck('id', 'name');
            $type = 'course';

        } elseif ($request->has('bundle_id')) {
            $product = Bundle::findOrFail($request->get('bundle_id'));
            $teachers = $product->user->name;
            $type = 'bundle';
        }

        $cart_items = Cart::session(auth()->user()->id)->getContent()->keys()->toArray();
        if (!in_array($product->id, $cart_items)) {

            Cart::session(auth()->user()->id)
                ->add($product->id, $product->title, $product->price, 1,
                    [
                        'user_id' => auth()->user()->id,
                        'description' => $product->description,
                        'image' => $product->course_image,
                        'type' => $type,
                        'teachers' => $teachers
                    ]);
        }
        foreach (Cart::session(auth()->user()->id)->getContent() as $item) {
            if ($item->attributes->type == 'bundle') {
                $bundle_ids[] = $item->id;
            } else {
                $course_ids[] = $item->id;
            }
        }
        $courses = new Collection(Course::find($course_ids));
        $bundles = Bundle::find($bundle_ids);
        $courses = $bundles->merge($courses);

        $total = $courses->sum('price');

        //Apply Tax
        $taxData = $this->applyTax('total');

        return redirect(route('cart.index'));
//        return view($this->path . '.cart.checkout', compact('courses', 'total', 'taxData'));
    }

    public function clear(Request $request)
    {
        Cart::session(auth()->user()->id)->clear();
        return back();
    }

    public function remove(Request $request)
    {
        Cart::session(auth()->user()->id)->removeConditionsByType('coupon');


        if (Cart::session(auth()->user()->id)->getContent()->count() < 2) {
            Cart::session(auth()->user()->id)->clearCartConditions();
            Cart::session(auth()->user()->id)->removeConditionsByType('tax');
            Cart::session(auth()->user()->id)->removeConditionsByType('coupon');
            Cart::session(auth()->user()->id)->clear();
        }
        Cart::session(auth()->user()->id)->remove($request->course);
        return redirect(route('cart.index'));
    }

    public function stripePayment(Request $request)
    {
        if ($this->checkDuplicate()) {
            return $this->checkDuplicate();
        }
        //Making Order
        $order = $this->makeOrder();

        $gateway = Omnipay::create('Stripe');
        $gateway->setApiKey(config('services.stripe.secret'));
        $token = $request->reservation['stripe_token'];

        $amount = Cart::session(auth()->user()->id)->getTotal();
        $currency = $this->currency['short_code'];
        $response = $gateway->purchase([
            'amount' => $amount,
            'currency' => $currency,
            'token' => $token,
            'confirm' => true,
            'description' => auth()->user()->name
        ])->send();

        if ($response->isSuccessful()) {
            $order->status = 1;
            $order->payment_type = 1;
            $order->save();
            (new EarningHelper)->insert($order);
            foreach ($order->items as $orderItem) {
                //Bundle Entries
                if ($orderItem->item_type == Bundle::class) {
                    foreach ($orderItem->item->courses as $course) {
                        $course->students()->attach($order->user_id);
                    }
                }
                $orderItem->item->students()->attach($order->user_id);
            }

            //Generating Invoice
            generateInvoice($order);
            $this->adminOrderMail($order);

            Cart::session(auth()->user()->id)->clear();
            Session::flash('success', trans('labels.frontend.cart.payment_done'));
            return redirect()->route('status');

        } else {
            $order->status = 2;
            $order->save();
            \Log::info($response->getMessage() . ' for id = ' . auth()->user()->id);
            Session::flash('failure', trans('labels.frontend.cart.try_again'));
            return redirect()->route('cart.index');
        }
    }

    public function paypalPayment(Request $request)
    {
        if ($this->checkDuplicate()) {
            return $this->checkDuplicate();
        }

        $gateway = Omnipay::create('PayPal_Rest');
        $gateway->setClientId(config('paypal.client_id'));
        $gateway->setSecret(config('paypal.secret'));
        $mode = config('paypal.settings.mode') == 'sandbox' ? true : false;
        $gateway->setTestMode($mode);

        $cartTotal = number_format(Cart::session(auth()->user()->id)->getTotal());
        $currency = $this->currency['short_code'];
        try {
            $response = $gateway->purchase([
                'amount' => $cartTotal,
                'currency' => $currency,
                'description' => auth()->user()->name,
                'cancelUrl' => route('cart.paypal.status', ['status' => 0]),
                'returnUrl' => route('cart.paypal.status', ['status' => 1]),

            ])->send();
            if ($response->isRedirect()) {
                return Redirect::away($response->getRedirectUrl());
            }
        } catch (\Exception $e) {
            \Session::put('failure', trans('labels.frontend.cart.unknown_error'));
            return Redirect::route('cart.paypal.status');
        }

        \Session::put('failure', trans('labels.frontend.cart.unknown_error'));
        return Redirect::route('cart.paypal.status');
    }

    public function offlinePayment(Request $request)
    {
        if ($this->checkDuplicate()) {
            return $this->checkDuplicate();
        }
        //Making Order
        $order = $this->makeOrder();
        $order->payment_type = 3;
        $order->status = 0;
        $order->save();
        $content = [];
        $items = [];
        $counter = 0;
        foreach (Cart::session(auth()->user()->id)->getContent() as $key => $cartItem) {
            $counter++;
            array_push($items, ['number' => $counter, 'name' => $cartItem->name, 'price' => $cartItem->price]);
        }

        $content['items'] = $items;
        $content['total'] =  number_format(Cart::session(auth()->user()->id)->getTotal(),2);
        $content['reference_no'] = $order->reference_no;

        try {
            \Mail::to(auth()->user()->email)->send(new OfflineOrderMail($content));
            $this->adminOrderMail($order);
        } catch (\Exception $e) {
            \Log::info($e->getMessage() . ' for order ' . $order->id);
        }

        Cart::session(auth()->user()->id)->clear();
        \Session::flash('success', trans('labels.frontend.cart.offline_request'));
        return redirect()->route('courses.all');
    }

    public function getPaymentStatus()
    {
        \Session::forget('failure');
        if (request()->get('status')) {
            if (empty(request()->get('PayerID')) || empty(request()->get('token'))) {
                \Session::put('failure', trans('labels.frontend.cart.payment_failed'));
                return Redirect::route('status');
            }
            $order = $this->makeOrder();
            $order->payment_type = 2;
            $order->transaction_id = request()->get('paymentId');
            $order->save();
            \Session::flash('success', trans('labels.frontend.cart.payment_done'));
            $order->status = 1;
            $order->save();
            (new EarningHelper)->insert($order);
            foreach ($order->items as $orderItem) {
                //Bundle Entries
                if ($orderItem->item_type == Bundle::class) {
                    foreach ($orderItem->item->courses as $course) {
                        $course->students()->attach($order->user_id);
                    }
                }
                $orderItem->item->students()->attach($order->user_id);
            }

            //Generating Invoice
            generateInvoice($order);
            $this->adminOrderMail($order);
            Cart::session(auth()->user()->id)->clear();
            return Redirect::route('status');
        }
        else {
            \Session::flash('failure', trans('labels.frontend.cart.payment_failed'));
            return Redirect::route('status');
        }

    }

    public function getNow(Request $request)
    {   
        $timeLimit = Time_limit::all();
        
        $duration = $timeLimit[0]->time_limit; 
        // return $duration;
        $currentDate = Carbon::now();
        $current_date = $currentDate->year .'-' .$currentDate->month .'-'.$currentDate->day .' '.$currentDate->hour .':'.$currentDate->minute;
        $datetomarow = Carbon::now()->addDay($duration);
        $tomorrow = $datetomarow->year .'-' .$datetomarow->month .'-'.$datetomarow->day.' '.$datetomarow->hour .':'.$datetomarow->minute;
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->reference_no = str_random(8);
        $order->amount = 0;
        $order->status = 1;
        $order->payment_type = 0;
       
        $order->plan_date = $tomorrow;
        $order->save();
        //Getting and Adding items
        if ($request->course_id) {
            $type = Course::class;
            $id = $request->course_id;
        } else {
            $type = Bundle::class;
            $id = $request->bundle_id;

        }
        $order->items()->create([
            'item_id' => $id,
            'item_type' => $type,
            'price' => 0
        ]);

        foreach ($order->items as $orderItem) {
            //Bundle Entries
            if ($orderItem->item_type == Bundle::class) {
                foreach ($orderItem->item->courses as $course) {
                    $course->students()->attach($order->user_id);
                }
            }
            $orderItem->item->students()->attach($order->user_id);
        }
        Session::flash('success', trans('labels.frontend.cart.purchase_successful'));
        return back();

    }

    public function getOffers()
    {
        $coupons = Coupon::where('status', '=', 1)->get();
        return view('frontend.cart.offers', compact('coupons'));
    }

    public function applyCoupon(Request $request)
    {
        Cart::session(auth()->user()->id)->removeConditionsByType('coupon');

        $coupon = $request->coupon;
        $coupon = Coupon::where('code', '=', $coupon)
            ->where('status', '=', 1)
            ->first();

        if ($coupon != null) {
            Cart::session(auth()->user()->id)->clearCartConditions();
            Cart::session(auth()->user()->id)->removeConditionsByType('coupon');
            Cart::session(auth()->user()->id)->removeConditionsByType('tax');

            $ids = Cart::session(auth()->user()->id)->getContent()->keys();
            $course_ids = [];
            $bundle_ids = [];
            foreach (Cart::session(auth()->user()->id)->getContent() as $item) {
                if ($item->attributes->type == 'bundle') {
                    $bundle_ids[] = $item->id;
                } else {
                    $course_ids[] = $item->id;
                }
            }
            $courses = new Collection(Course::find($course_ids));
            $bundles = Bundle::find($bundle_ids);
            $courses = $bundles->merge($courses);

            $total = $courses->sum('price');
            $isCouponValid = false;
            if ($coupon->useByUser() < $coupon->per_user_limit) {
                $isCouponValid = true;
                if (($coupon->min_price != null) && ($coupon->min_price > 0)) {
                    if ($total >= $coupon->min_price) {
                        $isCouponValid = true;
                    }
                } else {
                    $isCouponValid = true;
                }
                if ($coupon->expires_at != null) {
                    if (Carbon::parse($coupon->expires_at) >= Carbon::now()) {
                        $isCouponValid = true;
                    } else {
                        $isCouponValid = false;
                    }
                }

            }

            if ($isCouponValid == true) {
                $type = null;
                if ($coupon->type == 1) {
                    $type = '-' . $coupon->amount . '%';
                } else {
                    $type = '-' . $coupon->amount;
                }

                $condition = new \Darryldecode\Cart\CartCondition(array(
                    'name' => $coupon->code,
                    'type' => 'coupon',
                    'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                    'value' => $type,
                    'order' => 1
                ));

                Cart::session(auth()->user()->id)->condition($condition);
                //Apply Tax
                $taxData = $this->applyTax('subtotal');

                $html = view('frontend.cart.partials.order-stats', compact('total', 'taxData'))->render();
                return ['status' => 'success', 'html' => $html];
            }


        }
        return ['status' => 'fail', 'message' => trans('labels.frontend.cart.invalid_coupon')];
    }

    public function removeCoupon(Request $request)
    {

        Cart::session(auth()->user()->id)->clearCartConditions();
        Cart::session(auth()->user()->id)->removeConditionsByType('coupon');
        Cart::session(auth()->user()->id)->removeConditionsByType('tax');

        $course_ids = [];
        $bundle_ids = [];
        foreach (Cart::session(auth()->user()->id)->getContent() as $item) {
            if ($item->attributes->type == 'bundle') {
                $bundle_ids[] = $item->id;
            } else {
                $course_ids[] = $item->id;
            }
        }
        $courses = new Collection(Course::find($course_ids));
        $bundles = Bundle::find($bundle_ids);
        $courses = $bundles->merge($courses);

        $total = $courses->sum('price');

        //Apply Tax
        $taxData = $this->applyTax('subtotal');

        $html = view('frontend.cart.partials.order-stats', compact('total', 'taxData'))->render();
        return ['status' => 'success', 'html' => $html];

    }

    private function makeOrder()
    {
        $coupon = Cart::session(auth()->user()->id)->getConditionsByType('coupon')->first();
        if ($coupon != null) {
            $coupon = Coupon::where('code', '=', $coupon->getName())->first();
        }

        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->reference_no = str_random(8);
        $order->amount = Cart::session(auth()->user()->id)->getTotal();
        $order->status = 1;
        $order->coupon_id = ($coupon == null) ? 0 : $coupon->id;
        $order->payment_type = 3;
        $order->save();
        //Getting and Adding items
        foreach (Cart::session(auth()->user()->id)->getContent() as $cartItem) {
            if ($cartItem->attributes->type == 'bundle') {
                $type = Bundle::class;
            } else {
                $type = Course::class;
            }
            $order->items()->create([
                'item_id' => $cartItem->id,
                'item_type' => $type,
                'price' => $cartItem->price
            ]);
        }
//        Cart::session(auth()->user()->id)->removeConditionsByType('coupon');
        return $order;
    }

    private function checkDuplicate()
    {
        $is_duplicate = false;
        $message = '';
        $orders = Order::where('user_id', '=', auth()->user()->id)->pluck('id');
        $order_items = OrderItem::whereIn('order_id', $orders)->get(['item_id', 'item_type']);
        foreach (Cart::session(auth()->user()->id)->getContent() as $cartItem) {
            if ($cartItem->attributes->type == 'course') {
                foreach ($order_items->where('item_type', 'App\Models\Course') as $item) {
                    if ($item->item_id == $cartItem->id) {
                        $is_duplicate = true;
                        $message .= $cartItem->name . ' ' . __('alerts.frontend.duplicate_course') . '</br>';
                    }
                }
            }
            if ($cartItem->attributes->type == 'bundle') {
                foreach ($order_items->where('item_type', 'App\Models\Bundle') as $item) {
                    if ($item->item_id == $cartItem->id) {
                        $is_duplicate = true;
                        $message .= $cartItem->name . '' . __('alerts.frontend.duplicate_bundle') . '</br>';
                    }
                }
            }
        }

        if ($is_duplicate) {
            return redirect()->back()->withdanger($message);
        }
        return false;

    }

    private function applyTax($target)
    {
        //Apply Conditions on Cart
        $taxes = Tax::where('status', '=', 1)->get();
        Cart::session(auth()->user()->id)->removeConditionsByType('tax');
        if ($taxes != null) {
            $taxData = [];
            foreach ($taxes as $tax) {
                $total = Cart::session(auth()->user()->id)->getTotal();
                $taxData[] = ['name' => '+' . $tax->rate . '% ' . $tax->name, 'amount' =>  number_format(($total * $tax->rate / 100),2)];
            }

            $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'Tax',
                'type' => 'tax',
                'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                'value' => $taxes->sum('rate') . '%',
                'order' => 2
            ));
            Cart::session(auth()->user()->id)->condition($condition);
            return $taxData;
        }
    }

    private function adminOrderMail($order)
    {
        if(config('access.users.order_mail')) {
            $content = [];
            $items = [];
            $counter = 0;
            foreach (Cart::session(auth()->user()->id)->getContent() as $key => $cartItem) {
                $counter++;
                array_push($items, ['number' => $counter, 'name' => $cartItem->name, 'price' => $cartItem->price]);
            }

            $content['items'] = $items;
            $content['total'] =  number_format(Cart::session(auth()->user()->id)->getTotal(),2);
            $content['reference_no'] = $order->reference_no;

            $admins = User::role('administrator')->get();
            foreach ($admins as $admin) {
                \Mail::to($admin->email)->send(new AdminOrederMail($content, $admin));
            }
        }
    }

    public function instamojoPayment(Request $request)
    {
        if ($this->checkDuplicate()) {
            return $this->checkDuplicate();
        }

        $cartTotal = number_format(Cart::session(auth()->user()->id)->getTotal(), 2);
        $cartdata = [
            "purpose" => "Buy Course/Bundle",
            "amount" => $cartTotal,
            "buyer_name" => auth()->user()->name,
            "send_email" => false,
            "send_sms" => false,
            "phone" => $request->user_phone,
            "email" => auth()->user()->email,
            "redirect_url" => route('cart.instamojo.status'),
        ];
        $instamojoWrapper =  new InstamojoWrapper();
        return $instamojoWrapper->pay($cartdata);
    }

    public function getInstamojoStatus()
    {
        \Session::forget('failure');
        if (request()->get('payment_status') == 'Credit') {
            $order = $this->makeOrder();
            $order->payment_type = 4;
            $order->transaction_id = request()->get('payment_id');
            $order->save();
            \Session::flash('success', trans('labels.frontend.cart.payment_done'));
            $order->status = 1;
            $order->save();
            (new EarningHelper)->insert($order);
            foreach ($order->items as $orderItem) {
                //Bundle Entries
                if ($orderItem->item_type == Bundle::class) {
                    foreach ($orderItem->item->courses as $course) {
                        $course->students()->attach($order->user_id);
                    }
                }
                $orderItem->item->students()->attach($order->user_id);
            }

            //Generating Invoice
            generateInvoice($order);
            $this->adminOrderMail($order);
            Cart::session(auth()->user()->id)->clear();
            return Redirect::route('status');
        }else if (request()->get('payment_status') == 'Failed') {
            \Session::flash('failure', trans('labels.frontend.cart.payment_failed'));
            return Redirect::route('status');
        }
        else {
            \Session::flash('failure', trans('labels.frontend.cart.payment_failed'));
            return Redirect::route('status');
        }
    }

    public function razorpayPayment(Request $request)
    {
        $currency = $this->currency['short_code'];
        $amount = number_format(Cart::session(auth()->user()->id)->getTotal(), 2) * 100;
        $razorWrapper = new RazorpayWrapper();
        $orderId = $razorWrapper->order($currency, $amount);
        $cart = [
            'order_id' => $orderId,
            'amount' =>  $amount,
            'currency' => $currency,
            'description' => auth()->user()->name,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ];
        return redirect()->route('cart.index')->with(['razorpay' => $cart]);
    }

    public function getRazorpayStatus(Request $request)
    {
        $attributes = ['razorpay_signature' => $request->razorpay_signature, 'razorpay_payment_id' => $request->razorpay_payment_id, 'razorpay_order_id' => $request->razorpay_order_id];
        $razorWrapper = new RazorpayWrapper();
        if ($razorWrapper->verifySignature($attributes)) {
            $order = $this->makeOrder();
            $order->payment_type = 5;
            $order->transaction_id = request()->get('payment_id');
            $order->save();
            \Session::flash('success', trans('labels.frontend.cart.payment_done'));
            $order->status = 1;
            $order->save();
            (new EarningHelper)->insert($order);
            foreach ($order->items as $orderItem) {
                //Bundle Entries
                if ($orderItem->item_type == Bundle::class) {
                    foreach ($orderItem->item->courses as $course) {
                        $course->students()->attach($order->user_id);
                    }
                }
                $orderItem->item->students()->attach($order->user_id);
            }

            //Generating Invoice
            generateInvoice($order);
            $this->adminOrderMail($order);
            Cart::session(auth()->user()->id)->clear();
            return Redirect::route('status');
        } else {
            \Session::flash('failure', trans('labels.frontend.cart.payment_failed'));
            return Redirect::route('status');
        }
    }

    public function cashfreeFreePayment(Request $request)
    {
        $amount = number_format(Cart::session(auth()->user()->id)->getTotal(), 2);
        $currency = $this->currency['short_code'];
        $parameter = [
            'orderAmount' => $amount,
            'orderCurrency' => 'INR',
            'orderNote' => auth()->user()->name,
            'customerName' => $request->user_name,
            'customerPhone' => $request->user_phone,
            'customerEmail' => auth()->user()->email,
        ];

        $cashFreeWrapper = new CashFreeWrapper();
        return $cashFreeWrapper->request($parameter);
    }

    public function getCashFreeStatus(Request $request)
    {
        $cashFreeWrapper = new CashFreeWrapper();
        $response = $cashFreeWrapper->signatureVerification($request->except('signature'), $request->signature);
        if($response && $request->txStatus == "SUCCESS"){
            $order = $this->makeOrder();
            $order->payment_type = 6;
            $order->transaction_id = request()->get('payment_id');
            $order->save();
            \Session::flash('success', trans('labels.frontend.cart.payment_done'));
            $order->status = 1;
            $order->save();
            (new EarningHelper)->insert($order);
            foreach ($order->items as $orderItem) {
                //Bundle Entries
                if ($orderItem->item_type == Bundle::class) {
                    foreach ($orderItem->item->courses as $course) {
                        $course->students()->attach($order->user_id);
                    }
                }
                $orderItem->item->students()->attach($order->user_id);
            }

            //Generating Invoice
            generateInvoice($order);
            $this->adminOrderMail($order);
            Cart::session(auth()->user()->id)->clear();
            \Log::info('Gateway:CaseFree,Message:'.$request->txMsg.'txStatus:'.$request->txStatus. ' for id = ' . auth()->user()->id);
            return Redirect::route('status');

        }
        \Log::info('Gateway:CaseFree,Message:'.$request->txMsg.'txStatus:'.$request->txStatus. ' for id = ' . auth()->user()->id);
        \Session::flash('failure', trans('labels.frontend.cart.payment_failed'));
        return Redirect::route('status');
    }

    public function payuPayment(Request $request)
    {
        $payumoneyWrapper = new PayuMoneyWrapper;
        $currency = $this->currency['short_code'];
        $amount = number_format(Cart::session(auth()->user()->id)->getTotal(), 2);
        $parameter = [
            'amount' => $amount,
            'firstname' => auth()->user()->name,
            'productinfo' => auth()->user()->name,
            'email' => auth()->user()->email,
            'phone' => $request->user_phone,
        ];
        return $payumoneyWrapper->request($parameter);
    }

    public function getPayUStatus(Request $request)
    {
        \Session::forget('failure');
        $payumoneyWrapper = new PayuMoneyWrapper();
        $response = $payumoneyWrapper->response($request);
        if(is_array($response) && $response['status'] == 'success'){
            $order = $this->makeOrder();
            $order->payment_type = 7;
            $order->transaction_id = $response['payuMoneyId'];
            $order->save();
            \Session::flash('success', trans('labels.frontend.cart.payment_done'));
            $order->status = 1;
            $order->save();
            (new EarningHelper)->insert($order);
            foreach ($order->items as $orderItem) {
                //Bundle Entries
                if ($orderItem->item_type == Bundle::class) {
                    foreach ($orderItem->item->courses as $course) {
                        $course->students()->attach($order->user_id);
                    }
                }
                $orderItem->item->students()->attach($order->user_id);
            }

            //Generating Invoice
            generateInvoice($order);
            $this->adminOrderMail($order);
            Cart::session(auth()->user()->id)->clear();
            \Log::info('Gateway:PayUMoney,Message:'.$response['error_Message'].',txStatus:'.$response['status']. ' for id = ' . auth()->user()->id);
            return Redirect::route('status');
        }
        \Log::info('Gateway:PayUMoney,Message:'.$response['error_Message'].',txStatus:'.$response['status']. ' for id = ' . auth()->user()->id);
        \Session::flash('failure', trans('labels.frontend.cart.payment_failed'));
        return Redirect::route('status');
    }

    public function flatterPayment(Request $request)
    {
        $request->request->add([
            'amount' => number_format(Cart::session(auth()->user()->id)->getTotal(), 2),
            'payment_method' => 'both',
            'description' => auth()->user()->name,
            'country' => '',
            'currency' => $this->currency['short_code'],
            'email' => auth()->user()->email,
            'firstname' => auth()->user()->first_name,
            'lastname' => auth()->user()->last_name,
            'metadata' => '',
            'phonenumber' => $request->user_phone,
//            'logo' => 'https://demo.neonlms.com/storage/logos/popup-logo.png',
            'logo' => asset('storage/logos/'.config('logo_popup')),
            'title' =>  config('app.name'),
        ]);
        if($request->method() == "POST") {
            Rave::initialize(route('cart.flutter.status'));
        }else{
            \Session::flash('failure', trans('labels.frontend.cart.payment_failed'));
            return Redirect::route('status');
        }
    }

    public function getFlatterStatus(Request $request)
    {
        $response = json_decode($request->resp,true);
        if($response['respcode'] == '00' || $response['respcode'] == "0") {
            $data = Rave::verifyTransaction($response['data']['transactionobject']['txRef']);
            $order = $this->makeOrder();
            $order->payment_type = 7;
            $order->transaction_id = $response['data']['transactionobject']['txRef'];
            $order->status = 1;
            $order->save();
            (new EarningHelper)->insert($order);
            foreach ($order->items as $orderItem) {
                //Bundle Entries
                if ($orderItem->item_type == Bundle::class) {
                    foreach ($orderItem->item->courses as $course) {
                        $course->students()->attach($order->user_id);
                    }
                }
                $orderItem->item->students()->attach($order->user_id);
            }
            //Generating Invoice
            generateInvoice($order);
            $this->adminOrderMail($order);
            Cart::session(auth()->user()->id)->clear();
            \Log::info('Gateway:Flutter,Message:'.$response['respmsg'].',txStatus:'.$response['data']['data']['status']. ' for id = ' . auth()->user()->id);
            \Session::flash('success', trans('labels.frontend.cart.payment_done'));
        }else{
            \Log::info('Gateway:Flutter,Message:'.json_encode($response). ' for id = ' . auth()->user()->id);
            \Session::flash('failure', trans('labels.frontend.cart.payment_failed'));
        }
        return Redirect::route('status');
    }
}
