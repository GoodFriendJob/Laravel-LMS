<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreSponsorsRequest;
use App\Http\Requests\Admin\UpdateSponsorsRequest;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SponsorController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $sponsors = Sponsor::all();

        return view('backend.sponsors.index', compact('sponsors'));
    }

    /**
     * Display a listing of Courses via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $sponsors = "";


        $sponsors = Sponsor::orderBy('created_at','desc')->get();




        return DataTables::of($sponsors)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ( $request) {
                $view = "";
                $edit = "";
                $delete = "";

                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.sponsors.edit', ['sponsor' => $q->id])])
                        ->render();
                    $view .= $edit;

                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.sponsors.destroy', ['sponsor' => $q->id])])
                        ->render();
                    $view .= $delete;

                return $view;

            })
            ->editColumn('logo',function ($q){
                if($q->logo != null){
                    return  '<img src="'.asset('storage/uploads/'.$q->logo).'" height="50px">';
                }
                return 'N/A';
            })
            ->editColumn('status', function ($q) {
                $html = html()->label(html()->checkbox('')->id($q->id)
                ->checked(($q->status == 1) ? true : false)->class('switch-input')->attribute('data-id', $q->id)->value(($q->status == 1) ? 1 : 0).'<span class="switch-label"></span><span class="switch-handle"></span>')->class('switch switch-lg switch-3d switch-primary');
                return $html;
            })
            ->rawColumns(['actions','logo','status'])
            ->make();
    }

    /**
     * Show the form for creating new Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('backend.sponsors.create');
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreSponsorsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSponsorsRequest $request)
    {
        $request = $this->saveFiles($request);

        Sponsor::create($request->all());


        return redirect()->route('admin.sponsors.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sponsor = Sponsor::findOrFail($id);

        return view('backend.sponsors.index', compact('sponsor'));
    }

    /**
     * Update Category in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateSponsorsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSponsorsRequest $request, $id)
    {
        $request = $this->saveFiles($request);

        $sponsor = Sponsor::findOrFail($id);
        $sponsor->update($request->all());

        return redirect()->route('admin.sponsors.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }



    /**
     * Remove Category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $sponsor = Sponsor::findOrFail($id);
        $sponsor->delete();

        return redirect()->route('admin.sponsors.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Category at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {

        if ($request->input('ids')) {
            $entries = Sponsor::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    public function status($id)
    {
        $slide = Sponsor::findOrFail($id);
        if ($slide->status == 1) {
            $slide->status = 0;
        } else {
            $slide->status = 1;
        }
        $slide->save();

        return back()->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Update sponsor status
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     **/
    public function updateStatus()
    {
        $sponsor = Sponsor::findOrFail(request('id'));
        $sponsor->status = $sponsor->status == 1? 0 : 1;
        $sponsor->save();
    }

}
