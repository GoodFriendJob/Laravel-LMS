<?php

namespace App\Http\Controllers\Backend;

use App\Models\Tax;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaxController extends Controller
{
    /**
     * Display a listing of Taxes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tax = Tax::orderBy('created_at', 'desc')
            ->get();
        return view('backend.tax.index',compact('tax'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.tax.create');
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
            'rate' => 'required',
        ]);

        $tax = Tax::where('name','=',$request->name)->first();
        if($tax == null){
            $tax = new Tax();
            $tax->name = $request->name;
            $tax->rate = $request->rate;
            $tax->save();
        }

        return redirect()->route('admin.tax.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tax = Tax::findOrFail($id);
        return view('backend.tax.edit',compact('tax'));
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
            'rate' => 'required',
        ]);

        $tax = Tax::findOrFail($id);
        if($tax != null){
            $tax->name = $request->name;
            $tax->rate = $request->rate;
            $tax->save();
            return redirect()->route('admin.tax.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
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
        $tax = Tax::findOrFail($id);
        $tax->delete();
        return back()->withFlashSuccess(trans('alerts.backend.general.deleted'));

    }


    public function status($id)
    {
        $tax = Tax::findOrFail($id);
        if ($tax->status == 1) {
            $tax->status = 0;
        } else {
            $tax->status = 1;
        }
        $tax->save();

        return back()->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Update tax status
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     **/
    public function updateStatus()
    {
        $tax = Tax::findOrFail(request('id'));
        $tax->status = $tax->status == 1? 0 : 1;
        $tax->save();
    }
}
