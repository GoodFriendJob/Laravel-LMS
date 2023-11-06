<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{

    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slides_list = Slider::OrderBy('sequence','asc')->get();

        return view('backend.slider.index', compact('slides_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.slider.create');
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
            'image' => 'required|file',
        ]);

        $request = $this->saveFiles($request);
        $sequence = Slider::max('sequence');
        $sequence += 1;
        $slide = new Slider();
        $slide->name = $request->name;
        $slide->bg_image = $request->image;
        $slide->overlay = $request->overlay;
        $slide->sequence = $sequence;
        $slide->content = $request->dataJson;
        $slide->status = 1;
        $slide->save();

        return redirect()->route('admin.sliders.index')->withFlashSuccess(trans('alerts.backend.general.created'));
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
        $slide = Slider::findOrFail($id);
        return view('backend.slider.edit',compact('slide'));
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
        ]);

        $request = $this->saveFiles($request);
        $slide = Slider::findOrFail($id);
        if($request->image != ""){
            $slide->bg_image = $request->image;
        }
        $slide->name = $request->name;
        $slide->overlay = ($request->overlay == "") ? 0 : 1 ;
        $slide->content = $request->dataJson;
        $slide->save();

        return redirect()->route('admin.sliders.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slide = Slider::findOrFail($id);
        $slide->delete();
        return back()->withFlashSuccess(trans('alerts.backend.general.deleted'));

    }


    public function status($id)
    {
        $slide = Slider::findOrFail($id);
        if ($slide->status == 1) {
            $slide->status = 0;
        } else {
            $slide->status = 1;
        }
        $slide->save();

        return back()->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Permanently save Sequence from storage.
     *
     * @param  Request
     */
    public function saveSequence(Request $request)
    {

        foreach ($request->list as $item) {
            $slide = Slider::find($item['id']);
            $slide->sequence= $item['sequence'];
            $slide->save();
        }
        return 'success';
    }

    /**
     * Update slider status
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     **/
    public function updateStatus()
    {
        $slide = Slider::findOrFail(request('id'));
        $slide->status = $slide->status == 1? 0 : 1;
        $slide->save();
    }
}
