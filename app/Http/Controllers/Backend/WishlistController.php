<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WishList;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.wishlist.index');
    }

    /**
     * Display a listing of Courses via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $wishlists = WishList::query()->with(['course'])->where('user_id',auth()->user()->id);


        return DataTables::of($wishlists)
            ->addIndexColumn()
            ->addColumn('actions', function ($q){
                $view = '';
                $view .= view('backend.datatable.action-delete')
                    ->with(['route' => route('admin.wishlist.destroy', ['wishlist' => $q->id])])
                    ->render();
                $view .= view('backend.datatable.action-view')
                    ->with(['route' => route('courses.show', [$q->course->slug])])->render();

                return $view;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if(!WishList::where('course_id',$request->course)->where('user_id',auth()->user()->id)->first()){
            WishList::create([
                'user_id' => auth()->user()->id,
                'course_id' => $request->course,
                'price' => $request->price
            ]);
            return response()->json(['status' => true,'message' => trans('alerts.frontend.wishlist.added')]);
        }else{
            return response()->json(['status' => false,'message' => trans('alerts.frontend.wishlist.exist')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WishList  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(WishList $wishlist)
    {
        $wishlist->delete();
        return redirect()->route('admin.wishlist.index')->withFlashSuccess(__('alerts.backend.general.deleted'));
    }
}
