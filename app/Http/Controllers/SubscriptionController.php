<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Course;
use App\Models\Order;
use App\Models\Stripe\StripePlan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    private $path;

    public function __construct()
    {
        $path = 'frontend';
        if(session()->has('display_type')){
            if(session('display_type') == 'rtl'){
                $path = 'frontend-rtl';
            }else{
                $path = 'frontend';
            }
        }else if(config('app.display_type') == 'rtl'){
            $path = 'frontend-rtl';
        }
        $this->path = $path;
    }

    public function plans()
    {
        $plans = StripePlan::get();
        return view($this->path.'.subscription.plans', compact('plans'));
    }

    public function showForm(StripePlan $plan)
    {
        $intent = auth()->user()->createSetupIntent();
        return view($this->path.'.subscription.form', compact('plan', 'intent'));
    }

    /**
     * Process the form
     */
    public function subscribe(Request $request, StripePlan $plan)
    {
        $paymentMethod = $request->paymentMethod;
        // grab the user
        $user = $request->user();
        $address = [
            "city" => $request->city,
            "country" => $request->country,
            "line1" => $request->address,
            "line2" => null,
            "postal_code" => $request->postal_code,
            "state" => $request->state,
        ];

        $user->createOrGetStripeCustomer();

        $user->updateStripeCustomer([
            'email' => $request->stripeEmail,
            "address" => $address
        ]);

        // create the subscription
        try {
           $user->newSubscription('default', $plan->plan_id)
            ->create($paymentMethod, [
                'email' => $user->email,
            ]);
            \Session::flash('success', trans('labels.subscription.done'));
        } catch (\Exception $e) {
            \Log::info($e->getMessage() . ' for subscription plan ' .$plan->name. ' User Name: '.$user->name.' Id:' .$user->id);
            return redirect()->route('subscription.plans')->withErrors('Error creating subscription.');
        }
        return redirect()->route('subscription.status');
    }


    /**
     * Update the subscription
     */
    public function updateSubscription(Request $request, StripePlan $plan)
    {
        $user = $request->user();

        // if a user is cancelled
        if ($user->subscribed('default') && $user->subscription('default')->onGracePeriod()) {

            if ($user->onPlan($plan->plan_id)) {
                // resume the plan
                $user->subscription('default')->resume();
            } else {
                // resume and switch plan
                $user->subscription('default')->resume()->swap($plan->plan_id);
            }

            // if not cancelled, and switch
        } else {
            // change the plan
            $user->subscription('default')->swap($plan->plan_id);
        }


        \Session::flash('success', trans('labels.subscription.update'));
        return redirect()->route('subscription.status');
    }

    private function checkQuantity($isQuantity)
    {
        if($isQuantity == 0 || $isQuantity == 99){
            return false;
        }
        return true;
    }

    public function status()
    {
        return view('frontend.subscription.status');
    }

    public function courseSubscribed(Request $request)
    {
        $user  = $request->user();

        if($user->subscription()->ended()){
            return redirect()->back()->withDanger(trans('alerts.frontend.course.subscription_plan_expired'));
        }

        if(!$user->subscription()->cancelled()){

            if($user->subscription()->active()){
                $plan = $this->getPlan($user->subscription()->stripe_plan);
                if($request->course_id){
                    if($plan->course == 99){
                        return redirect()->back()->withDanger(trans('alerts.frontend.course.sub_course_not_access'));
                    }
                    if($plan->course != 0 && $user->subscribedCourse()->count() >= $plan->course){
                        return redirect()->back()->withDanger(trans('alerts.frontend.course.sub_course_limit_over'));
                    }
                }else{
                    if($plan->bundle == 99){
                        return redirect()->back()->withDanger(trans('alerts.frontend.course.sub_bundle_not_access'));
                    }
                    if($plan->bundle != 0 && $user->subscribedBundles()->count() >= $plan->bundle){
                        return redirect()->back()->withDanger(trans('alerts.frontend.course.sub_bundle_limit_over'));
                    }
                }

                $this->subscribeBundleOrCourse($request);

                return redirect()->route('admin.dashboard')->withFlashSuccess($request->course_id ? trans('alerts.frontend.course.sub_course_success') : trans('alerts.frontend.course.sub_bundle_success'));
            }
        }else{
            return redirect()->back()->withDanger(trans('alerts.frontend.course.subscription_plan_cancelled'));
        }
    }

    private function getPlan($planId)
    {
        return StripePlan::where('plan_id', $planId)->firstorfail();
    }

    private function subscribeBundleOrCourse(Request $request)
    {
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->reference_no = str_random(8);
        $order->amount = 0;
        $order->status = 1;
        $order->payment_type = 0;
        $order->order_type = 1;
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
            'price' => 0,
            'type' => 1
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
    }
}
