<?php

namespace App\Http\Controllers\Backend;

use Auth;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\General\EarningHelper;

class PaymentController extends Controller
{
    /**
     * Get payment view
     * @return \Illuminate\Http\Response
     **/

    public function index(){
        $earningHelper  = new EarningHelper();
        $total_earnings = $earningHelper->totalEarning();
        $total_withdrawal = $earningHelper->totalWithdrawal();
        $total_withdrawal_pending = $earningHelper->totalWithdrawalPending();
        $total_balance = $earningHelper->totalBalance();
        return view('backend.payments.payment', compact('total_earnings', 'total_withdrawal', 'total_withdrawal_pending', 'total_balance'));
    }

    /**
     * Get teacher earning data
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     **/

    public function getEarningData(Request $request)
    {
        $earnings = Auth::user()->earnings->sortKeysDesc();
        return \DataTables::of($earnings)
            ->addIndexColumn()
            ->addColumn('course', function ($q){
                return $q->course->title;
            })
            ->addColumn('amount', function ($q){
                return number_format($q->order->amount,2);
            })
            ->addColumn('user', function ($q){
                return $q->order->user->name;
            })
            ->addColumn('reference_no', function ($q){
                return $q->order->reference_no;
            })
            ->addColumn('actions', function ($q) use ($request) {
                $view = view('backend.datatable.action-view')
                    ->with(['route' => route('admin.orders.show', ['order' => $q->order->id])])->render();
                return $view;
            })
            ->rawColumns(['course', 'user', 'reference_no', 'actions', 'amount'])
            ->make();
    }

    /**
     * Get teacher withdrawal data
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     **/
    public function getwithdrawalData(Request $request){
        $payment_type = [__('labels.backend.payments.payment_type.bank'), __('labels.backend.payments.payment_type.paypal'), __('labels.backend.payments.payment_type.offline')];
        $status = [__('labels.backend.payments.status.pending'), __('labels.backend.payments.status.approved'), __('labels.backend.payments.status.rejected')];
        $withdraws = Auth::user()->withdraws->sortKeysDesc();
        return \DataTables::of($withdraws)
            ->addIndexColumn()
            ->addColumn('payment_type', function ($q) use($payment_type) {
                return $payment_type[$q->payment_type];
            })
            ->addColumn('amount', function ($q){
                return number_format($q->amount,2);
            })
            ->addColumn('status', function ($q) use($status) {
                return $status[$q->status];
            })
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function createRequest()
    {
        $payment_types = [
            '0' => __('labels.backend.payments.payment_type.bank'),
            '1' => __('labels.backend.payments.payment_type.paypal'),
            '2' =>  __('labels.backend.payments.payment_type.offline')
        ];
        $total_balance = (new EarningHelper)->totalBalance();

        return view('backend.payments.withdraw_request_form', compact('payment_types', 'total_balance'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRequest(Request $request)
    {
        if(request()->amount > (new EarningHelper)->totalBalance() || !(int)(request()->amount > 0))
        return back()->withFlashDanger('Please insert valid amount');

        $data = [
            'user_id' => Auth::user()->id,
            'amount' => request()->amount,
            'payment_type' => request()->payment_type
        ];

        Withdraw::create($data);
        return redirect()->route('admin.payments')->withFlashSuccess(__('alerts.backend.general.created'));
    }

    /**
     * Get payment request view
     * @return \Illuminate\Http\Response
     **/
    public function paymentRequest(){
        return view('backend.payments.payment_request');
    }

    /**
     * Get payment request data
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     **/
    public function getPaymentRequestData(){

        if(request('status')){
            $payment_request = Withdraw::with('teacher')->where('status', request('status'))->orderBy('created_at', 'desc')->get();
        }else{
            $payment_request = Withdraw::with('teacher')->orderBy('created_at', 'desc')->get();
        }


        $status = [__('labels.backend.payments.status.pending'), __('labels.backend.payments.status.approved'), __('labels.backend.payments.status.rejected')];

        return \DataTables::of($payment_request)
            ->addIndexColumn()
            ->editColumn('teacher_name', function ($q) {
                return '<span class="label label-info label-many">' . $q->teacher->name . ' </span>';
            })
            ->addColumn('balance', function ($q) {
                return  (new EarningHelper())->totalBalance($q->teacher->id);
            })
            ->addColumn('status', function ($q) use($status){
                return $status[$q->status];
            })
            ->addColumn('amount', function ($q){
                return number_format($q->amount,2);
            })
            ->addColumn('actions', function ($q) {
                $html = '';
                if ($q->status == 0) {
                    $html .= '<a href="javascript:void(0)" data-status="1" data-id="'.$q->id.'" data-url="'.route('admin.payments.payments_request_update').'"class="btn btn-xs btn-info mb-1 update-status-request">'.__('labels.backend.payments.approve').'</a>';
                    $html .= '   <a href="javascript:void(0)" data-status="2" data-id="'.$q->id.'" data-url="'.route('admin.payments.payments_request_update').'"class="btn btn-xs btn-danger mb-1 update-status-request">'.__('labels.backend.payments.reject').'</a>';
                }
                return $html;
            })
            ->rawColumns(['teacher_name','actions', 'balance', 'status','amount'])
            ->make();
    }

    public function paymentsRequestUpdate(Request $request){
        Withdraw::where('id', request()->id)
        ->update([
            'remarks' => request()->remarks,
            'status' => request()->status,
        ]);
        return;
    }
}
