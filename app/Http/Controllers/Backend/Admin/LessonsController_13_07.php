<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Course;
use App\Models\CourseTimeline;
use App\Models\Lesson;
use App\Models\Media;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLessonsRequest;
use App\Http\Requests\Admin\UpdateLessonsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\DataTables\Facades\DataTables;
use DB;
class LessonsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Lesson.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('lesson_access')) {
            return abort(401);
        }
        $courses = $courses = Course::has('category')->ofTeacher()->pluck('title', 'id')->prepend('Please select', '');

        return view('backend.lessons.index', compact('courses'));
    }

    /**
     * Display a listing of Lessons via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $lessons = "";
        $lessons = Lesson::query()->where('live_lesson', '=', 0)->whereIn('course_id', Course::ofTeacher()->pluck('id'));


        if ($request->course_id != "") {
            $lessons = $lessons->where('course_id', (int)$request->course_id)->orderBy('lessonorders', 'ASC');
        }

        if ($request->show_deleted == 1) {
            if (!Gate::allows('lesson_delete')) {
                return abort(401);
            }
            $lessons = Lesson::query()->where('live_lesson', '=', 0)->with('course')->orderBy('lessonorders', 'ASC')->onlyTrashed();
        }


        if (auth()->user()->can('lesson_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('lesson_edit')) {
            $has_edit = true;
        }
        if (auth()->user()->can('lesson_delete')) {
            $has_delete = true;
        }

        return DataTables::of($lessons)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.lessons', 'label' => 'id', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.lessons.show', ['lesson' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.lessons.edit', ['lesson' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.lessons.destroy', ['lesson' => $q->id])])
                        ->render();
                    $view .= $delete;
                }

                if (auth()->user()->can('test_view')) {
                    if ($q->test != "") {
                        $view .= '<a href="' . route('admin.tests.index', ['lesson_id' => $q->id]) . '" class="btn btn-success btn-block mb-1">' . trans('labels.backend.tests.title') . '</a>';
                    }
                }

                return $view;
            })
            ->editColumn('course', function ($q) {
                return ($q->course) ? $q->course->title : 'N/A';
            })
            ->editColumn('lesson_image', function ($q) {
                return ($q->lesson_image != null) ? '<img height="50px" src="' . asset('storage/uploads/' . $q->lesson_image) . '">' : 'N/A';
            })
            ->editColumn('free_lesson', function ($q) {
                return ($q->free_lesson == 1) ? "Yes" : "No";
            })
            ->editColumn('published', function ($q) {
                return ($q->published == 1) ? "Yes" : "No";
            })
            ->rawColumns(['lesson_image', 'actions'])
            ->make();
    }

    /**
     * Show the form for creating new Lesson.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('lesson_create')) {
            return abort(401);
        }
        $courses = Course::has('category')->ofTeacher()->get()->pluck('title', 'id')->prepend('Please select', '');
        return view('backend.lessons.create', compact('courses'));
    }

    /**
     * Store a newly created Lesson in storage.
     *
     * @param  \App\Http\Requests\StoreLessonsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonsRequest $request)
    {
        if (!Gate::allows('lesson_create')) {
            return abort(401);
        }

        $slug = "";
        if (($request->slug == "") || $request->slug == null) {
            $slug = str_slug($request->title);
        } elseif ($request->slug != null) {
            $slug = $request->slug;
        }

        $slug_lesson = Lesson::where('slug', '=', $slug)->first();
        if ($slug_lesson != null) {
            return back()->withFlashDanger(__('alerts.backend.general.slug_exist'));
        }

        $lesson = Lesson::create($request->except('downloadable_files', 'lesson_image')
            + ['position' => Lesson::where('course_id', $request->course_id)->max('position') + 1]);

        $lesson->slug = $slug;
        $lesson->save();




        //Saving  videos
        if ($request->media_type != "") {
            $model_type = Lesson::class;
            $model_id = $lesson->id;
            $size = 0;
            $media = '';
            $url = '';
            $video_id = '';
            $name = $lesson->title . ' - video';

            if (($request->media_type == 'youtube') || ($request->media_type == 'vimeo')) {
                $video = $request->video;
                $url = $video;
                $video_id = array_last(explode('/', $request->video));
                $media = Media::where('url', $video_id)
                    ->where('type', '=', $request->media_type)
                    ->where('model_type', '=', 'App\Models\Lesson')
                    ->where('model_id', '=', $lesson->id)
                    ->first();
                $size = 0;
            } elseif ($request->media_type == 'upload') {
                if (\Illuminate\Support\Facades\Request::hasFile('video_file')) {
                    $file = \Illuminate\Support\Facades\Request::file('video_file');
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $size = $file->getSize() / 1024;
                    $path = public_path() . '/storage/uploads/';
                    $file->move($path, $filename);

                    $video_id = $filename;
                    $url = asset('storage/uploads/' . $filename);

                    $media = Media::where('type', '=', $request->media_type)
                        ->where('model_type', '=', 'App\Models\Lesson')
                        ->where('model_id', '=', $lesson->id)
                        ->first();
                }
            } elseif ($request->media_type == 'embed') {
                $url = $request->video;
                $filename = $lesson->title . ' - video';
            }

            if ($media == null) {
                $media = new Media();
                $media->model_type = $model_type;
                $media->model_id = $model_id;
                $media->name = $name;
                $media->url = $url;
                $media->type = $request->media_type;
                $media->file_name = $video_id;
                $media->size = 0;
                $media->save();
            }
        }

        $request = $this->saveAllFiles($request, 'downloadable_files', Lesson::class, $lesson);

        if (($request->slug == "") || $request->slug == null) {
            $lesson->slug = str_slug($request->title);
            $lesson->save();
        }

        $sequence = 1;
        if (count($lesson->course->courseTimeline) > 0) {
            $sequence = $lesson->course->courseTimeline->max('sequence');
            $sequence = $sequence + 1;
        }

        if ($lesson->published == 1) {
            $timeline = CourseTimeline::where('model_type', '=', Lesson::class)
                ->where('model_id', '=', $lesson->id)
                ->where('course_id', $request->course_id)->first();
            if ($timeline == null) {
                $timeline = new CourseTimeline();
            }
            $timeline->course_id = $request->course_id;
            $timeline->model_id = $lesson->id;
            $timeline->model_type = Lesson::class;
            $timeline->sequence = $sequence;
            $timeline->save();
        }

        return redirect()->route('admin.lessons.index', ['course_id' => $request->course_id])->withFlashSuccess(__('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Lesson.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('lesson_edit')) {
            return abort(401);
        }
        $videos = '';
        $courses = Course::has('category')->ofTeacher()->get()->pluck('title', 'id')->prepend('Please select', '');

        $lesson = Lesson::with('media')->findOrFail($id);
        if ($lesson->media) {
            $videos = $lesson->media()->where('media.type', '=', 'YT')->pluck('url')->implode(',');
        }

        return view('backend.lessons.edit', compact('lesson', 'courses', 'videos'));
    }

    /**
     * Update Lesson in storage.
     *
     * @param  \App\Http\Requests\UpdateLessonsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLessonsRequest $request, $id)
    {
        if (!Gate::allows('lesson_edit')) {
            return abort(401);
        }

        $slug = "";
        if (($request->slug == "") || $request->slug == null) {
            $slug = str_slug($request->title);
        } elseif ($request->slug != null) {
            $slug = $request->slug;
        }

        $slug_lesson = Lesson::where('slug', '=', $slug)->where('id', '!=', $id)->first();
        if ($slug_lesson != null) {
            return back()->withFlashDanger(__('alerts.backend.general.slug_exist'));
        }

        $lesson = Lesson::findOrFail($id);
        $lesson->update($request->except('downloadable_files', 'lesson_image'));
        $lesson->slug = $slug;
        $lesson->save();

        //Saving  videos
        if ($request->media_type != "") {
            $model_type = Lesson::class;
            $model_id = $lesson->id;
            $size = 0;
            $media = '';
            $url = '';
            $video_id = '';
            $name = $lesson->title . ' - video';
            $media = $lesson->mediavideo;
            if ($media == "") {
                $media = new  Media();
            }
            if ($request->media_type != 'upload') {
                if (($request->media_type == 'youtube') || ($request->media_type == 'vimeo')) {
                    $video = $request->video;
                    $url = $video;
                    $video_id = array_last(explode('/', $request->video));
                    $size = 0;
                } elseif ($request->media_type == 'embed') {
                    $url = $request->video;
                    $filename = $lesson->title . ' - video';
                }
                $media->model_type = $model_type;
                $media->model_id = $model_id;
                $media->name = $name;
                $media->url = $url;
                $media->type = $request->media_type;
                $media->file_name = $video_id;
                $media->size = 0;
                $media->save();
            }

            if ($request->media_type == 'upload') {
                if (\Illuminate\Support\Facades\Request::hasFile('video_file')) {
                    $file = \Illuminate\Support\Facades\Request::file('video_file');
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $size = $file->getSize() / 1024;
                    $path = public_path() . '/storage/uploads/';
                    $file->move($path, $filename);

                    $video_id = $filename;
                    $url = asset('storage/uploads/' . $filename);

                    $media = Media::where('type', '=', $request->media_type)
                        ->where('model_type', '=', 'App\Models\Lesson')
                        ->where('model_id', '=', $lesson->id)
                        ->first();

                    if ($media == null) {
                        $media = new Media();
                    }
                    $media->model_type = $model_type;
                    $media->model_id = $model_id;
                    $media->name = $name;
                    $media->url = $url;
                    $media->type = $request->media_type;
                    $media->file_name = $video_id;
                    $media->size = 0;
                    $media->save();
                }
            }
        }
        if ($request->hasFile('add_pdf')) {
            $pdf = $lesson->mediaPDF;
            if ($pdf) {
                $pdf->delete();
            }
        }


        $request = $this->saveAllFiles($request, 'downloadable_files', Lesson::class, $lesson);

        $sequence = 1;
        if (count($lesson->course->courseTimeline) > 0) {
            $sequence = $lesson->course->courseTimeline->max('sequence');
            $sequence = $sequence + 1;
        }

        if ((int)$request->published == 1) {
            $timeline = CourseTimeline::where('model_type', '=', Lesson::class)
                ->where('model_id', '=', $lesson->id)
                ->where('course_id', $request->course_id)->first();
            if ($timeline == null) {
                $timeline = new CourseTimeline();
            }
            $timeline->course_id = $request->course_id;
            $timeline->model_id = $lesson->id;
            $timeline->model_type = Lesson::class;
            $timeline->sequence = $sequence;
            $timeline->save();
        }


        return redirect()->route('admin.lessons.index', ['course_id' => $request->course_id])->withFlashSuccess(__('alerts.backend.general.updated'));
    }


    /**
     * Display Lesson.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('lesson_view')) {
            return abort(401);
        }
        $courses = Course::get()->pluck('title', 'id')->prepend('Please select', '');

        $tests = Test::where('lesson_id', $id)->get();

        $lesson = Lesson::findOrFail($id);


        return view('backend.lessons.show', compact('lesson', 'tests', 'courses'));
    }


    /**
     * Remove Lesson from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('lesson_delete')) {
            return abort(401);
        }
        $lesson = Lesson::findOrFail($id);
        $lesson->chapterStudents()->where('course_id', $lesson->course_id)->forceDelete();
        $lesson->delete();

        return back()->withFlashSuccess(__('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Lesson at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('lesson_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Lesson::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Lesson from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('lesson_delete')) {
            return abort(401);
        }
        $lesson = Lesson::onlyTrashed()->findOrFail($id);
        $lesson->restore();

        return back()->withFlashSuccess(trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Lesson from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('lesson_delete')) {
            return abort(401);
        }
        $lesson = Lesson::onlyTrashed()->findOrFail($id);

        if (File::exists(public_path('/storage/uploads/'.$lesson->lesson_image))) {
            File::delete(public_path('/storage/uploads/'.$lesson->lesson_image));
            File::delete(public_path('/storage/uploads/thumb/'.$lesson->lesson_image));
        }

        $timelineStep = CourseTimeline::where('model_id', '=', $id)
            ->where('course_id', '=', $lesson->course->id)->first();
        if ($timelineStep) {
            $timelineStep->delete();
        }

        $lesson->forceDelete();



        return back()->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    function order_edit(Request $request){
        $data = json_decode($request->id_info);
        $test_id = $request->test_id;
        $min_order =min($data);
        //return $test_id;
        for ($i = 0; $i<count($data); $i++){
           DB::table('lessons')
           ->where('id', $data[$i])
           ->where('live_lesson', '=', 0)
           ->update(['lessonorders' => $i+$min_order]);               
        }  

        $output = array(
            'success'  => 'The order is updated successfully'
        );

        echo json_encode($output); 
    }
}
