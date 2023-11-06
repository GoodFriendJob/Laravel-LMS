<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreReasonsRequest;
use App\Http\Requests\Admin\UpdateReasonsRequest;
use App\Models\Reason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class ReasonController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Reason.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('reason_access')) {
            return abort(401);
        }

        return view('backend.reasons.index');
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
        $reasons = "";

        $reasons = Reason::orderBy('created_at', 'desc')->get();


        if (auth()->user()->can('reason_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('reason_edit')) {
            $has_edit = true;
        }
        if (auth()->user()->can('reason_delete')) {
            $has_delete = true;
        }

        return DataTables::of($reasons)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.reasons', 'label' => 'reason', 'value' => $q->id]);
                }
//                if ($has_view) {
//                    $view = view('backend.datatable.action-view')
//                        ->with(['route' => route('admin.reasons.show', ['reason' => $q->id])])->render();
//                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.reasons.edit', ['reason' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.reasons.destroy', ['reason' => $q->id])])
                        ->render();
                    $view .= $delete;
                }


                return $view;

            })
            ->editColumn('icon', function ($q) {
                if ($q->icon != "") {
                    return '<i style="font-size:40px;" class="' . $q->icon . '"></i>';
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('status', function ($q) {
                $html = html()->label(html()->checkbox('')->id($q->id)
                ->checked(($q->status == 1) ? true : false)->class('switch-input')->attribute('data-id', $q->id)->value(($q->status == 1) ? 1 : 0).'<span class="switch-label"></span><span class="switch-handle"></span>')->class('switch switch-lg switch-3d switch-primary');
                return $html;
            })
            ->rawColumns(['actions', 'icon', 'status'])
            ->make();
    }

    /**
     * Show the form for creating new Reason.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('reason_create')) {
            return abort(401);
        }
        return view('backend.reasons.create');
    }

    /**
     * Store a newly created Reason in storage.
     *
     * @param  \App\Http\Requests\StoreReasonsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReasonsRequest $request)
    {

        if (!Gate::allows('reason_create')) {
            return abort(401);
        }

        $reason = new  Reason();
        $reason->title = $request->title;
        $reason->content = $request->get('content');
        $reason->icon = $request->icon;
        $reason->save();

        return redirect()->route('admin.reasons.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Reason.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('reason_edit')) {
            return abort(401);
        }
        $reason = Reason::findOrFail($id);

        return view('backend.reasons.edit', compact('reason'));
    }

    /**
     * Update Reason in storage.
     *
     * @param  \App\Http\Requests\UpdateReasonsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReasonsRequest $request, $id)
    {
        if (!Gate::allows('reason_edit')) {
            return abort(401);
        }

        $reason = Reason::findOrFail($id);
        $reason->title = $request->title;
        $reason->content = $request->get('content');
        $reason->icon = $request->icon;
        $reason->save();

        return redirect()->route('admin.reasons.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


    /**
     * Display Reason.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('reason_view')) {
            return abort(401);
        }
        $reason = Reason::findOrFail($id);

        return view('backend.reasons.show', compact('reason'));
    }


    /**
     * Remove Reason from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('reason_delete')) {
            return abort(401);
        }
        $reason = Reason::findOrFail($id);
        $reason->delete();

        return redirect()->route('admin.reasons.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Reason at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('reason_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Reason::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    public function status($id)
    {
        $reason = Reason::findOrFail($id);
        if ($reason->status == 1) {
            $reason->status = 0;
        } else {
            $reason->status = 1;
        }
        $reason->save();

        return back()->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Update reason status
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     **/
    public function updateStatus()
    {
        $reason = Reason::findOrFail(request('id'));
        $reason->status = $reason->status == 1? 0 : 1;
        $reason->save();
    }
}
