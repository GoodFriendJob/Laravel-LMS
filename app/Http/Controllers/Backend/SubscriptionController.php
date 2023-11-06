<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Stripe\StripePlan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __invoke(Request $request)
    {
        $user     = $request->user();
        $invoices = $user->subscribed('default') ? $user->StripeInvoices() : optional();
        $activePlan = $user->subscribed('default') ? StripePlan::where('plan_id', $user->subscription()->stripe_plan)->first()??optional() : optional();
        return view('backend.subscription', compact('user', 'invoices', 'activePlan'));
    }

    /**
     * Download an invoice
     */
    public function downloadInvoice($invoiceId)
    {
        return auth()->user()->downloadInvoice($invoiceId, [
            'vendor'  => config('app.name'),
            'product' => 'Monthly Subscription'
        ]);
    }

    /**
     * Delete subscription
     */
    public function deleteSubscription(Request $request)
    {
        $user = $request->user();

        // cancel the subscription
        $user->subscription('default')->cancel();

        return redirect()->back()->withFlashSuccess(__('labels.subscription.cancel'));
    }

    /**
     * Update the credit card
     */
    public function updateCard(Request $request)
    {
        // get the user
        $user = $request->user();

        // get the cc token
        $ccToken = $request->input('cc_token');

        // update the card
        $user->updateCard($ccToken);

        // return a redirect back to account
        return redirect('account')->with(['success' => 'Credit card updated.']);
    }

}
