<?php

namespace App\Http\Middleware;

use App\Models\Course;
use Closure;

class Subscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(auth()->check()){
            $user = auth()->user();
            if($user->subscription('default')){
                if($course = Course::where('slug', $request->route()->parameter('slug'))->firstOrFail()){
                    if(!in_array($course->id, $user->getPurchasedCoursesIds())) {
                        if (in_array($course->id, $user->getSubscribedCoursesIds())) {
                            if ($user->subscription()->ended()) {
                                return redirect()->back()->withFlashDanger(trans('alerts.frontend.course.subscription_plan_expired'));
                            }
                            if ($user->subscription()->cancelled() && !$user->subscription()->onGracePeriod()) {
                                return redirect()->back()->withFlashDanger(trans('alerts.frontend.course.subscription_plan_cancelled'));
                            }
                        }
                    }
                }
            }
        }
        return $next($request);
    }

}
