<?php

namespace App\Http\Controllers\Backend;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    /**
     * Display a listing of Taxes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')
            ->get();
        return view('backend.coupons.index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required|unique:coupons',
            'type' => 'required',
            'amount' => 'required',
            'per_user_limit' => 'required',
        ]);

        $coupon = Coupon::where('name','=',$request->name)->first();
        if($coupon == null){
            $coupon = new Coupon();
            $coupon->name = $request->name;
            $coupon->description = $request->description;
            $coupon->code = $request->code;
            $coupon->type = $request->type;
            $coupon->amount = $request->amount;
            $coupon->expires_at = $request->expires_at;
            $coupon->min_price = $request->min_price;
            $coupon->per_user_limit = $request->per_user_limit ?? 0;
            $coupon->save();
        }

        return redirect()->route('admin.coupons.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('backend.coupons.show',compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('backend.coupons.edit',compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required|unique:coupons,code,'.$id,
            'type' => 'required',
            'amount' => 'required',
            'per_user_limit' => 'required',

        ]);

        $coupon = Coupon::findOrFail($id);
        if($coupon != null){
            $coupon->name = $request->name;
            $coupon->description = $request->description;
            $coupon->code = $request->code;
            $coupon->type = $request->type;
            $coupon->amount = $request->amount;
            $coupon->expires_at = $request->expires_at;
            $coupon->min_price = $request->min_price;
            $coupon->per_user_limit = $request->per_user_limit;
            $coupon->save();
            return redirect()->route('admin.coupons.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
        }
        return abort(404);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return back()->withFlashSuccess(trans('alerts.backend.general.deleted'));

    }


    public function status($id)
    {
        $coupon = Coupon::findOrFail($id);
        if ($coupon->status == 1) {
            $coupon->status = 0;
        } else {
            $coupon->status = 1;
        }
        $coupon->save();

        return back()->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    public function updateStatus()
    {
        $coupon = Coupon::find(request('id'));
        $coupon->status = $coupon->status == 1? 0 : 1;
        $coupon->save();
    }
}
