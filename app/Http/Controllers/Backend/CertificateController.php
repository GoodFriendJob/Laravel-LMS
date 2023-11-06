<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CertificateController extends Controller
{
    public function __construct()
    {

        $path = 'frontend';
        if (session()->has('display_type')) {
            if (session('display_type') == 'rtl') {
                $path = 'frontend-rtl';
            } else {
                $path = 'frontend';
            }
        } else if (config('app.display_type') == 'rtl') {
            $path = 'frontend-rtl';
        }
        $this->path = $path;
    }

    /**
     * Get certificates lost for purchased courses.
     */
    public function getCertificates()
    {
        $certificates = auth()->user()->certificates;
        return view('backend.certificates.index', compact('certificates'));
    }


    /**
     * Generate certificate for completed course
     */
    public function generateCertificate(Request $request)
    {
        $course = Course::whereHas('students', function ($query) {
            $query->where('id', \Auth::id());
        })
            ->where('id', '=', $request->course_id)->first();
        if (($course != null) && ($course->progress() == 100)) {
            $certificate = Certificate::firstOrCreate([
                'user_id' => auth()->user()->id,
                'course_id' => $request->course_id
            ]);

            $data = [
                'name' => auth()->user()->name,
                'course_name' => $course->title,
                'date' => Carbon::now()->format('d M, Y'),
            ];
            $certificate_name = 'Certificate-' . $course->id . '-' . auth()->user()->id . '.pdf';
            $certificate->name = auth()->user()->name;
            $certificate->url = $certificate_name;
            $certificate->save();

            $pdf = \PDF::loadView('certificate.index', compact('data'))->setPaper('', 'landscape');

            $pdf->save(public_path('storage/certificates/' . $certificate_name));

            return back()->withFlashSuccess(trans('alerts.frontend.course.completed'));
        }
        return abort(404);
    }

    /**
     * Download certificate for completed course
     */
    public function download(Request $request)
    {
        $certificate = Certificate::findOrFail($request->certificate_id);
        if($certificate != null){
            $file = public_path() . "/storage/certificates/" . $certificate->url;
            return Response::download($file);
        }
        return back()->withFlashDanger('No Certificate found');


    }


    /**
     * Get Verify Certificate form
     */
    public function getVerificationForm()
    {
        return view($this->path.'.certificate-verification');
    }


    /**
     * Verify Certificate
     */
    public function verifyCertificate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'date' => 'required'
        ]);

        $certificates = Certificate::where('name', '=', $request->name)
            ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), "=", $request->date)
            ->get();
        $data['certificates'] = $certificates;
        $data['name'] = $request->name;
        $data['date'] = $request->date;
        session()->forget('certificates');
        return back()->with(['data' => $data]);

    }
}
