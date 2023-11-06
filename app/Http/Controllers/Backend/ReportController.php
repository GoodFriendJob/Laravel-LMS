<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Bundle;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getSalesReport(Request $request)
    {
        $courses = Course::ofTeacher()->pluck('id');
        $bundles = Bundle::ofTeacher()->pluck('id');

        //  bundle query
        $bundle_earnings = Order::query()->with('items')->where('status', '=', 1);
        if($request->get('bundle')){
            $bundle_earnings->whereHas('items', function ($q) use ($request) {
                $q->where('item_type', '=', Bundle::class)
                    ->where('item_id', $request->get('bundle'));
            });
        }else {
            $bundle_earnings->whereHas('items', function ($q) use ($bundles) {
                $q->where('item_type', '=', Bundle::class)
                    ->whereIn('item_id', $bundles);
            });
        }

        //  course query
        $course_earnings = Order::query()->with('items')->where('status', '=', 1);
        if($request->get('course')){
            $course_earnings->whereHas('items', function ($q) use ($request) {
                $q->where('item_type', '=', Course::class)
                    ->where('item_id', $request->get('course'));
            });
        }else{
            $course_earnings->whereHas('items', function ($q) use ($courses) {
                $q->where('item_type', '=', Course::class)
                    ->whereIn('item_id', $courses);
            });
        }


        if($request->get('student')){
            $bundle_earnings->whereHas('user', function (Builder $query) use($request){
                $query->where('id', '=', $request->get('student'));
            });

            $course_earnings->whereHas('user', function (Builder $query) use($request){
                $query->where('id', '=', $request->get('student'));
            });
        }

        $bundle_earnings =  $this->dateFilter($bundle_earnings);

        $course_earnings =  $this->dateFilter($course_earnings);

        // bundle sales and amount count
        $bundle_sales = $bundle_earnings->count();
        $bundle_earnings = $bundle_earnings->sum('amount');

        // course sales ans amount cont
        $course_sales = $course_earnings->count();
        $course_earnings = $course_earnings->sum('amount');

        $total_earnings = $course_earnings + $bundle_earnings;
        $total_sales = $course_sales + $bundle_sales;

        $students = User::query()->role('student')->get(['id', 'first_name', 'last_name']);

        $courses = Course::ofTeacher()->get(['id', 'title']);

        $bundles = Bundle::ofTeacher()->get(['id', 'title']);

        return view('backend.reports.sales', compact('total_earnings', 'total_sales', 'students', 'courses', 'bundles'));
    }

    public function getStudentsReport()
    {
        return view('backend.reports.students');
    }

    public function getCourseData(Request $request)
    {
        $courses = Course::ofTeacher()->pluck('id');

        $course_orders = OrderItem::query()->with(['item', 'order', 'order.user'])->whereHas('order', function ($q) {
            $q->where('status', '=', 1);
        });

        if($request->get('course')){
            $course_orders->whereHasMorph(
                'item',
                'App\Models\Course',
                function (Builder $query) use ($request) {
                    $query->where('id', $request->get('course'));
                }
            );
        }else {
            $course_orders->whereHasMorph(
                'item',
                'App\Models\Course',
                function (Builder $query) use ($courses) {
                    $query->whereIn('id', $courses);
                }
            );
        }

        if($request->get('student')){
            $course_orders->whereHas('order.user', function (Builder $query) use($request){
                $query->where('id', '=', $request->get('student'));
            });
        }

        $course_orders =  $this->dateFilter($course_orders);

        return \DataTables::of($course_orders)
            ->addColumn('course', function ($query) {
                $course_name = $query->item->title;
                $course_slug = $query->item->slug;
                $link = "<a href='" . route('courses.show', [$course_slug]) . "' target='_blank'>" . $course_name . "</a>";
                return $link;
            })
            ->addColumn('title', function ($query) {
                return $query->item->title;
            })
            ->addColumn('amount', function ($query) {
                return $query->order->amount;
            })
            ->addColumn('student', function ($query) {
                return $query->order->user->name;
            })
            ->addColumn('transaction', function ($query) {
                if ($query->order->transaction_id) {
                    return $query->order->transaction_id;
                }
                return;
            })
            ->editColumn('created_at', function ($query) {
                return $query->created_at->format('d-m-y H:i:s A');
            })
            ->rawColumns(['course'])
            ->addIndexColumn()
            ->make();
    }

    public function getBundleData(Request $request)
    {
        $bundles = Bundle::ofTeacher()->has('students', '>', 0)->withCount('students')->pluck('id');

        $bundle_orders = OrderItem::query()->with(['item', 'order', 'order.user'])->whereHas('order', function ($q) {
            $q->where('status', '=', 1);
        });

        if($request->get('bundle')){
            $bundle_orders->whereHasMorph(
                'item',
                'App\Models\Bundle',
                function (Builder $query) use ($request) {
                    $query->where('id', $request->get('bundle'));
                }
            );
        }else {
            $bundle_orders->whereHasMorph(
                'item',
                'App\Models\Bundle',
                function (Builder $query) use ($bundles) {
                    $query->whereIn('id', $bundles);
                }
            );
        }

        if($request->get('student')){
            $bundle_orders->whereHas('order.user', function (Builder $query) use($request){
                $query->where('id', '=', $request->get('student'));
            });
        }

        $bundle_orders =  $this->dateFilter($bundle_orders);

        return \DataTables::of($bundle_orders)
            ->addIndexColumn()
            ->addColumn('bundle', function ($q) {
                $bundle_name = $q->item->title;
                $bundle_slug = $q->item->slug;
                $link = "<a href='" . route('bundles.show', [$bundle_slug]) . "' target='_blank'>" . $bundle_name . "</a>";
                return $link;
            })
            ->addColumn('title', function ($query) {
                return $query->item->title;
            })
            ->addColumn('amount', function ($query) {
                return $query->order->amount;
            })
            ->addColumn('student', function ($query) {
                return $query->order->user->name;
            })
            ->addColumn('transaction', function ($query) {
                if ($query->order->transaction_id) {
                    return $query->order->transaction_id;
                }
                return;
            })
            ->editColumn('created_at', function ($query) {
                return $query->created_at->format('d-m-y H:i:s A');
            })
            ->rawColumns(['course'])
            ->rawColumns(['bundle'])
            ->make();
    }

    public function getStudentsData(Request $request)
    {
        $courses = Course::ofTeacher()->has('students', '>', 0)->withCount('students')->get();

        return \DataTables::of($courses)
            ->addIndexColumn()
            ->addColumn('completed', function ($q) {
                $count = 0;
                if (count($q->students) > 0) {
                    foreach ($q->students as $student) {
                        $completed_lessons = $student->chapters()->where('course_id', $q->id)->get()->pluck('model_id')->toArray();
                        if (count($completed_lessons) > 0) {
                            $progress = intval(count($completed_lessons) / $q->courseTimeline->count() * 100);
                            if ($progress == 100) {
                                $count++;
                            }
                        }
                    }
                }
                return $count;

            })
            ->make();
    }

    private function dateFilter($query)
    {

        if(request()->get('applyDate')){
            if(request()->get('date')) {
                $date = explode(' / ', request()->get('date'));
                $start = $date[0];
                $end = $date[1];
                $query->whereDate('created_at','<=', $end)->whereDate('created_at', '>=', $start);
            }
        }
        return $query;
    }
}
