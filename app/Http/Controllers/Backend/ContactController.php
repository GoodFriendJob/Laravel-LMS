<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class ContactController extends Controller
{
    /**
     * Display a listing of Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('backend.contacts.index');
    }

    /**
     * Display a listing of Courses via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $contacts = "";
        $contacts = Contact::query()->orderBy('created_at', 'desc')->get();


        return DataTables::of($contacts)
            ->addIndexColumn()
            ->editColumn('created_at', function ($q) {
               return $q->created_at->format('d M, Y | H:i A');
            })
            ->editColumn('number', function ($q) {
                if($q->number == ""){
                    return "N/A";
                }else{
                    return $q->number;
                }
            })
            ->make();
    }
}
