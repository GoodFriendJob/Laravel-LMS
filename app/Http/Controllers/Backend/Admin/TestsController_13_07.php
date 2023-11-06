<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Course;
use App\Models\CourseTimeline;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTestsRequest;
use App\Http\Requests\Admin\UpdateTestsRequest;
use Yajra\DataTables\Facades\DataTables;

use DB;

class TestsController extends Controller
{
    /**
     * Display a listing of Test.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('test_access')) {
            return abort(401);
        }

        $courses = Course::ofTeacher()->pluck('title', 'id')->prepend('Please select', '');

        return view('backend.tests.index', compact('courses'));
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
        $tests = "";


        if ($request->course_id != "") {
            $tests = Test::query()->where('course_id', '=', $request->course_id)->orderBy('testorders', 'asc');
        }

        if (request('show_deleted') == 1) {
            if (!Gate::allows('test_delete')) {
                return abort(401);
            }
            $tests = Test::query()->onlyTrashed();
        }


        if (auth()->user()->can('test_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('test_edit')) {
            $has_edit = true;
        }
        if (auth()->user()->can('test_delete')) {
            $has_delete = true;
        }

        return DataTables::of($tests)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.tests', 'label' => 'id', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.tests.show', ['test' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.tests.edit', ['test' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.tests.destroy', ['test' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                return $view;
            })
            ->addColumn('questions', function ($q) {
             if (count($q->questions) > 0) {
                    return "<span>".count($q->questions)."</span><a class='btn btn-success float-right' href='".route('admin.questions.index', ['test_id'=>$q->id])."'><i class='fa fa-arrow-circle-o-right'></i></a> ";
                }
                return count($q->questions);
            })

            ->addColumn('course', function ($q) {
                return ($q->course) ? $q->course->title : "N/A";
            })

            ->addColumn('lesson', function ($q) {
                return ($q->lesson) ? $q->lesson->title : "N/A";
            })

            ->editColumn('published', function ($q) {
                return ($q->published == 1) ? "Yes" : "No";
            })
            ->rawColumns(['actions','questions'])
            ->make();
    }

    /**
     * Show the form for creating new Test.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('test_create')) {
            return abort(401);
        }
        $courses = \App\Models\Course::ofTeacher()->get();
        $courses_ids = $courses->pluck('id');
        $courses = $courses->pluck('title', 'id')->prepend('Please select', '');
        $lessons = \App\Models\Lesson::whereIn('course_id', $courses_ids)->get()->pluck('title', 'id')->prepend('Please select', '');

        return view('backend.tests.create', compact('courses', 'lessons'));
    }

    /**
     * Store a newly created Test in storage.
     *
     * @param  \App\Http\Requests\StoreTestsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTestsRequest $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
            'title' => 'required',
            'description' => 'required'
        ], ['course_id.required' => 'The course field is required']);

        if (! Gate::allows('test_create')) {
            return abort(401);
        }

        $test = Test::create($request->all());
        $test->slug = str_slug($request->title);
        $test->save();

        $sequence = 1;
        if (count($test->course->courseTimeline) > 0) {
            $sequence = $test->course->courseTimeline->max('sequence');
            $sequence = $sequence + 1;
        }

        if ($test->published == 1) {
            $timeline = CourseTimeline::where('model_type', '=', Test::class)
                ->where('model_id', '=', $test->id)
                ->where('course_id', $request->course_id)->first();
            if ($timeline == null) {
                $timeline = new CourseTimeline();
            }
            $timeline->course_id = $request->course_id;
            $timeline->model_id = $test->id;
            $timeline->model_type = Test::class;
            $timeline->sequence = $sequence;
            $timeline->save();
        }



        return redirect()->route('admin.tests.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Test.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('test_edit')) {
            return abort(401);
        }
        $courses = \App\Models\Course::ofTeacher()->get();
        $courses_ids = $courses->pluck('id');
        $courses = $courses->pluck('title', 'id')->prepend('Please select', '');
        $lessons = \App\Models\Lesson::whereIn('course_id', $courses_ids)->get()->pluck('title', 'id')->prepend('Please select', '');

        $test = Test::findOrFail($id);

        return view('backend.tests.edit', compact('test', 'courses', 'lessons'));
    }

    /**
     * Update Test in storage.
     *
     * @param  \App\Http\Requests\UpdateTestsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTestsRequest $request, $id)
    {
        if (! Gate::allows('test_edit')) {
            return abort(401);
        }
        $test = Test::findOrFail($id);
        $test->update($request->all());
        $test->slug = str_slug($request->title);
        $test->save();


        $sequence = 1;
        if (count($test->course->courseTimeline) > 0) {
            $sequence = $test->course->courseTimeline->max('sequence');
            $sequence = $sequence + 1;
        }

        if ($test->published == 1) {
            $timeline = CourseTimeline::where('model_type', '=', Test::class)
                ->where('model_id', '=', $test->id)
                ->where('course_id', $request->course_id)->first();
            if ($timeline == null) {
                $timeline = new CourseTimeline();
            }
            $timeline->course_id = $request->course_id;
            $timeline->model_id = $test->id;
            $timeline->model_type = Test::class;
            $timeline->sequence = $sequence;
            $timeline->save();
        }


        return redirect()->route('admin.tests.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


    /**
     * Display Test.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('test_view')) {
            return abort(401);
        }
        $test = Test::findOrFail($id);

        return view('backend.tests.show', compact('test'));
    }


    /**
     * Remove Test from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('test_delete')) {
            return abort(401);
        }
        $test = Test::findOrFail($id);
        $test->chapterStudents()->where('course_id', $test->course_id)->forceDelete();
        $test->delete();

        return back()->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Test at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('test_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Test::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Test from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('test_delete')) {
            return abort(401);
        }
        $test = Test::onlyTrashed()->findOrFail($id);
        $test->restore();

        return back()->withFlashSuccess(trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Test from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('test_delete')) {
            return abort(401);
        }
        $test = Test::onlyTrashed()->findOrFail($id);
        $test->forceDelete();

        return back()->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    function order_edit(Request $request){
        $data = json_decode($request->id_info);
        $testId = $request->test_id;
        // return $testId;
        $min_order = min($data);
        for ($i = 0; $i<count($data); $i++){
            DB::table('tests')
            ->where('id', $data[$i])
            ->update(['testorders' => $i+$min_order]);               
        }  
        $output = array(
            'success'  => 'The order is updated successfully'
            );

        echo json_encode($output); 
    }
}
