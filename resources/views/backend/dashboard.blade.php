@extends('backend.layouts.app')

@section('title', __('strings.backend.dashboard.title').' | '.app_name())

@push('after-styles')
    <style>
        .trend-badge-2 {
            top: -10px;
            left: -52px;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            position: absolute;
            padding: 40px 40px 12px;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            background-color: #ff5a00;
        }

        .progress {
            background-color: #b6b9bb;
            height: 2em;
            font-weight: bold;
            font-size: 0.8rem;
            text-align: center;
        }

        .best-course-pic {
            background-color: #333333;
            background-position: center;
            background-size: cover;
            height: 150px;
            width: 100%;
            background-repeat: no-repeat;
        }


    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
                </div><!--card-header-->
                <div class="card-body">
                    <div class="row">
                        @if(auth()->user()->hasRole('student'))


                            @if(count($pending_orders) > 0)
                                <div class="col-12">
                                    <h4>@lang('labels.backend.dashboard.pending_orders')</h4>
                                </div>
                                <div class="col-12 text-center">

                                    <table class="table table table-bordered table-striped">
                                        <thead>
                                        <tr>

                                            <th>@lang('labels.general.sr_no')</th>
                                            <th>@lang('labels.backend.orders.fields.reference_no')</th>
                                            <th>@lang('labels.backend.orders.fields.items')</th>
                                            <th>@lang('labels.backend.orders.fields.amount')
                                                <small>(in {{$appCurrency['symbol']}})</small>
                                            </th>
                                            <th>@lang('labels.backend.orders.fields.payment_status.title')</th>
                                            <th>@lang('labels.backend.orders.fields.date')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pending_orders as $key=>$item)
                                            @php $key++ @endphp
                                            <tr>
                                                <td>
                                                    {{$key}}
                                                </td>
                                                <td>
                                                    {{$item->reference_no}}
                                                </td>
                                                <td>
                                                    @foreach($item->items as $key=>$subitem)
                                                        @php $key++ @endphp
                                                        @if($subitem->item != null)
                                                            {{$key.'. '.$subitem->item->title}} <br>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{$item->amount}}
                                                </td>
                                                <td>
                                                    @if($item->status == 0)
                                                        @lang('labels.backend.dashboard.pending')
                                                    @elseif($item->status == 1)
                                                        @lang('labels.backend.dashboard.success')
                                                    @elseif($item->status == 2)
                                                        @lang('labels.backend.dashboard.failed')
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$item->created_at->format('d-m-Y h:i:s')}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            @endif

                            <div class="col-12">
                                <h4>@lang('labels.backend.dashboard.my_courses')</h4>
                            </div>


                            @if(count($purchased_courses) > 0)
                                @foreach($purchased_courses as $item)
                                <div class="col-md-3">
                                        <div class="best-course-pic-text position-relative border">
                                            <div class="best-course-pic position-relative overflow-hidden"
                                                 @if($item->course_image != "") style="background-image: url({{asset('storage/uploads/'.$item->course_image)}})" @endif>

                                                @if($item->trending == 1)
                                                    <div class="trend-badge-2 text-center text-uppercase">
                                                        <i class="fas fa-bolt"></i>
                                                        <span>@lang('labels.backend.dashboard.trending') </span>
                                                    </div>
                                                @endif

                                                <div class="course-rate ul-li">
                                                    <ul>
                                                        @for($i=1; $i<=(int)$item->rating; $i++)
                                                            <li><i class="fas fa-star"></i></li>
                                                        @endfor
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="best-course-text d-inline-block w-100 p-2">
                                                <div class="course-title mb20 headline relative-position">
                                                    <h5>
                                                        <a href="{{ route('courses.show', [$item->slug]) }}">{{$item->title}}</a>
                                                    </h5>
                                                </div>
                                                <div class="course-meta d-inline-block w-100 ">
                                                    <div class="d-inline-block w-100 0 mt-2">
                                                     <span class="course-category float-left">
                                                <a href="{{route('courses.category',['category'=>$item->category->slug])}}"
                                                   class="bg-success text-decoration-none px-2 p-1">{{$item->category->name}}</a>
                                            </span>
                                                        <span class="course-author float-right">
                                                 {{ $item->students()->count() }}
                                                            @lang('labels.backend.dashboard.students')
                                            </span>
                                                    </div>

                                                    <div class="progress my-2">
                                                        <div class="progress-bar"
                                                             style="width:{{$item->progress() }}%">
                                                            @lang('labels.backend.dashboard.completed')
                                                            {{ $item->progress()  }} %
                                                        </div>
                                                    </div>
                                                    @if($item->progress() == 100)
                                                        @if(!$item->isUserCertified())
                                                            <form method="post"
                                                                  action="{{route('admin.certificates.generate')}}">
                                                                @csrf
                                                                <input type="hidden" value="{{$item->id}}"
                                                                       name="course_id">
                                                                <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                                                        id="finish">@lang('labels.frontend.course.finish_course')</button>
                                                            </form>
                                                        @else
                                                            <div class="alert alert-success px-1 text-center mb-0">
                                                                @lang('labels.frontend.course.certified')
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12 text-center">
                                    <h4 class="text-center">@lang('labels.backend.dashboard.no_data')</h4>
                                    <a class="btn btn-primary"
                                       href="{{route('courses.all')}}">@lang('labels.backend.dashboard.buy_course_now')
                                        <i class="fa fa-arrow-right"></i></a>
                                </div>
                            @endif
                            @if(count($purchased_bundles) > 0)

                                <div class="col-12 mt-5">
                                    <h4>@lang('labels.backend.dashboard.my_course_bundles')</h4>
                                </div>
                                @foreach($purchased_bundles as $key=>$bundle)
                                    @php $key++ @endphp
                                    <div class="col-12">
                                        <h5><a href="{{route('bundles.show',['slug'=>$bundle->slug ])}}">{{$key.'. '.$bundle->title}}</a></h5>
                                    </div>
                                    @if(count($bundle->courses) > 0)
                                        @foreach($bundle->courses as $item)
                                            <div class="col-md-3 mb-5">
                                                <div class="best-course-pic-text position-relative border">
                                                    <div class="best-course-pic position-relative overflow-hidden"
                                                         @if($item->course_image != "") style="background-image: url({{asset('storage/uploads/'.$item->course_image)}})" @endif>

                                                        @if($item->trending == 1)
                                                            <div class="trend-badge-2 text-center text-uppercase">
                                                                <i class="fas fa-bolt"></i>
                                                                <span>@lang('labels.backend.dashboard.trending') </span>
                                                            </div>
                                                        @endif

                                                        <div class="course-rate ul-li">
                                                            <ul>
                                                                @for($i=1; $i<=(int)$item->rating; $i++)
                                                                    <li><i class="fas fa-star"></i></li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="best-course-text d-inline-block w-100 p-2">
                                                        <div class="course-title mb20 headline relative-position">
                                                            <h5>
                                                                <a href="{{ route('courses.show', [$item->slug]) }}">{{$item->title}}</a>
                                                            </h5>
                                                        </div>
                                                        <div class="course-meta d-inline-block w-100 ">
                                                            <div class="d-inline-block w-100 0 mt-2">
                                                                <span class="course-category float-left">
                                                                    <a href="{{route('courses.category',['category'=>$item->category->slug])}}"
                                                                    class="bg-success text-decoration-none px-2 p-1">{{$item->category->name}}</a>
                                                                </span>
                                                                <span class="course-author float-right">
                                                                    {{ $item->students()->count() }}
                                                                    @lang('labels.backend.dashboard.students')
                                                                </span>
                                                            </div>

                                                            <div class="progress my-2">
                                                                <div class="progress-bar"
                                                                     style="width:{{$item->progress() }}%">{{ $item->progress()  }}
                                                                    %
                                                                    @lang('labels.backend.dashboard.completed')
                                                                </div>
                                                            </div>
                                                            @if($item->progress() == 100)
                                                                @if(!$item->isUserCertified())
                                                                    <form method="post"
                                                                          action="{{route('admin.certificates.generate')}}">
                                                                        @csrf
                                                                        <input type="hidden" value="{{$item->id}}"
                                                                               name="course_id">
                                                                        <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                                                                id="finish">@lang('labels.frontend.course.finish_course')</button>
                                                                    </form>
                                                                @else
                                                                    <div class="alert alert-success px-1 text-center mb-0">
                                                                        @lang('labels.frontend.course.certified')
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            @if($subscribed_courses->count() > 0)
                                <div class="col-12 mt-5">
                                    <h4>@lang('labels.backend.dashboard.my_subscribed_courses')</h4>
                                </div>
                                @foreach($subscribed_courses as $item)

                                    <div class="col-md-3">
                                        <div class="best-course-pic-text position-relative border">
                                            <div class="best-course-pic position-relative overflow-hidden"
                                                 @if($item->course_image != "") style="background-image: url({{asset('storage/uploads/'.$item->course_image)}})" @endif>

                                                @if($item->trending == 1)
                                                    <div class="trend-badge-2 text-center text-uppercase">
                                                        <i class="fas fa-bolt"></i>
                                                        <span>@lang('labels.backend.dashboard.trending') </span>
                                                    </div>
                                                @endif

                                                <div class="course-rate ul-li">
                                                    <ul>
                                                        @for($i=1; $i<=(int)$item->rating; $i++)
                                                            <li><i class="fas fa-star"></i></li>
                                                        @endfor
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="best-course-text d-inline-block w-100 p-2">
                                                <div class="course-title mb20 headline relative-position">
                                                    <h5>
                                                        <a href="{{ route('courses.show', [$item->slug]) }}">{{$item->title}}</a>
                                                    </h5>
                                                </div>
                                                <div class="course-meta d-inline-block w-100 ">
                                                    <div class="d-inline-block w-100 0 mt-2">
                                         <span class="course-category float-left">
                                    <a href="{{route('courses.category',['category'=>$item->category->slug])}}"
                                       class="bg-success text-decoration-none px-2 p-1">{{$item->category->name}}</a>
                                </span>
                                                        <span class="course-author float-right">
                                     {{ $item->students()->count() }}
                                                            @lang('labels.backend.dashboard.students')
                                </span>
                                                    </div>

                                                    <div class="progress my-2">
                                                        <div class="progress-bar"
                                                             style="width:{{$item->progress() }}%">
                                                            @lang('labels.backend.dashboard.completed')
                                                            {{ $item->progress()  }} %
                                                        </div>
                                                    </div>
                                                    @if($item->progress() == 100)
                                                        @if(!$item->isUserCertified())
                                                            <form method="post"
                                                                  action="{{route('admin.certificates.generate')}}">
                                                                @csrf
                                                                <input type="hidden" value="{{$item->id}}"
                                                                       name="course_id">
                                                                <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                                                        id="finish">@lang('labels.frontend.course.finish_course')</button>
                                                            </form>
                                                        @else
                                                            <div class="alert alert-success px-1 text-center mb-0">
                                                                @lang('labels.frontend.course.certified')
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            @if($subscribed_bundles->count() > 0)
                                <div class="col-12 mt-5">
                                    <h4>@lang('labels.backend.dashboard.my_subscribed_course_bundles')</h4>
                                </div>
                                @foreach($subscribed_bundles as $key=>$bundle)
                                    @php $key++ @endphp
                                    <div class="col-12">
                                        <h5><a href="{{route('bundles.show',['slug'=>$bundle->slug ])}}">{{$key.'. '.$bundle->title}}</a></h5>
                                    </div>
                                    @if(count($bundle->courses) > 0)
                                        @foreach($bundle->courses as $item)
                                            <div class="col-md-3 mb-5">
                                                <div class="best-course-pic-text position-relative border">
                                                    <div class="best-course-pic position-relative overflow-hidden"
                                                         @if($item->course_image != "") style="background-image: url({{asset('storage/uploads/'.$item->course_image)}})" @endif>

                                                        @if($item->trending == 1)
                                                            <div class="trend-badge-2 text-center text-uppercase">
                                                                <i class="fas fa-bolt"></i>
                                                                <span>@lang('labels.backend.dashboard.trending') </span>
                                                            </div>
                                                        @endif

                                                        <div class="course-rate ul-li">
                                                            <ul>
                                                                @for($i=1; $i<=(int)$item->rating; $i++)
                                                                    <li><i class="fas fa-star"></i></li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="best-course-text d-inline-block w-100 p-2">
                                                        <div class="course-title mb20 headline relative-position">
                                                            <h5>
                                                                <a href="{{ route('courses.show', [$item->slug]) }}">{{$item->title}}</a>
                                                            </h5>
                                                        </div>
                                                        <div class="course-meta d-inline-block w-100 ">
                                                            <div class="d-inline-block w-100 0 mt-2">
                                                            <span class="course-category float-left">
                                                                <a href="{{route('courses.category',['category'=>$item->category->slug])}}"
                                                                   class="bg-success text-decoration-none px-2 p-1">{{$item->category->name}}</a>
                                                            </span>
                                                                <span class="course-author float-right">
                                                                {{ $item->students()->count() }}
                                                                    @lang('labels.backend.dashboard.students')
                                                            </span>
                                                            </div>

                                                            <div class="progress my-2">
                                                                <div class="progress-bar"
                                                                     style="width:{{$item->progress() }}%">{{ $item->progress()  }}
                                                                    %
                                                                    @lang('labels.backend.dashboard.completed')
                                                                </div>
                                                            </div>
                                                            @if($item->progress() == 100)
                                                                @if(!$item->isUserCertified())
                                                                    <form method="post"
                                                                          action="{{route('admin.certificates.generate')}}">
                                                                        @csrf
                                                                        <input type="hidden" value="{{$item->id}}"
                                                                               name="course_id">
                                                                        <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                                                                id="finish">@lang('labels.frontend.course.finish_course')</button>
                                                                    </form>
                                                                @else
                                                                    <div class="alert alert-success px-1 text-center mb-0">
                                                                        @lang('labels.frontend.course.certified')
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif


                    @elseif(auth()->user()->hasRole('teacher'))
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-3 col-12 border-right">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card text-white bg-primary text-center">
                                                <div class="card-body">
                                                    <h2 class="">{{count(auth()->user()->courses) + count(auth()->user()->bundles)}}</h2>
                                                    <h5>@lang('labels.backend.dashboard.your_courses_and_bundles')</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card text-white bg-success text-center">
                                                <div class="card-body">
                                                    <h2 class="">{{$students_count}}</h2>
                                                    <h5>@lang('labels.backend.dashboard.students_enrolled')</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-12 border-right">
                                    <div class="d-inline-block form-group w-100">
                                        <h4 class="mb-0">@lang('labels.backend.dashboard.recent_reviews') <a
                                                    class="btn btn-primary float-right"
                                                    href="{{route('admin.reviews.index')}}">@lang('labels.backend.dashboard.view_all')</a>
                                        </h4>

                                    </div>
                                    <table class="table table-responsive-sm table-striped">
                                        <thead>
                                        <tr>
                                            <td>@lang('labels.backend.dashboard.course')</td>
                                            <td>@lang('labels.backend.dashboard.review')</td>
                                            <td>@lang('labels.backend.dashboard.time')</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($recent_reviews) > 0)
                                            @foreach($recent_reviews as $item)
                                                <tr>
                                                    <td>
                                                        <a target="_blank"
                                                           href="{{route('courses.show',[$item->reviewable->slug])}}">{{$item->reviewable->title}}</a>
                                                    </td>
                                                    <td>{{$item->content}}</td>
                                                    <td>{{$item->created_at->diffforhumans()}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">@lang('labels.backend.dashboard.no_data')</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="d-inline-block form-group w-100">
                                        <h4 class="mb-0">@lang('labels.backend.dashboard.recent_messages') <a
                                                    class="btn btn-primary float-right"
                                                    href="{{route('admin.messages')}}">@lang('labels.backend.dashboard.view_all')</a>
                                        </h4>
                                    </div>


                                    <table class="table table-responsive-sm table-striped">
                                        <thead>
                                        <tr>
                                            <td>@lang('labels.backend.dashboard.message_by')</td>
                                            <td>@lang('labels.backend.dashboard.message')</td>
                                            <td>@lang('labels.backend.dashboard.time')</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($threads) > 0)
                                            @foreach($threads as $item)
                                                <tr>
                                                    <td>
                                                        <a target="_blank"
                                                           href="{{asset('/user/messages/?thread='.$item->id)}}">{{$item->participants()->with('user')->where('user_id','<>', auth()->user()->id)->first()->user->name}}</a>
                                                    </td>
                                                    <td>{{$item->messages()->orderBy('id', 'desc')->first()->body}}</td>
                                                    <td>{{$item->messages()->orderBy('id', 'desc')->first()->created_at->diffForHumans() }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">@lang('labels.backend.dashboard.no_data')</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    @elseif(auth()->user()->hasRole('administrator'))
                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-dark text-center py-3">
                                <div class="card-body">
                                    <h1 class="">{{$courses_count}}</h1>
                                    <h3>@lang('labels.backend.dashboard.course_and_bundles')</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-light text-dark text-center py-3">
                                <div class="card-body">
                                    <h1 class="">{{$students_count}}</h1>
                                    <h3>@lang('labels.backend.dashboard.students')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-primary text-center py-3">
                                <div class="card-body">
                                    <h1 class="">{{$teachers_count}}</h1>
                                    <h3>@lang('labels.backend.dashboard.teachers')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 border-right">
                            <div class="d-inline-block form-group w-100">
                                <h4 class="mb-0">@lang('labels.backend.dashboard.recent_orders') <a
                                            class="btn btn-primary float-right"
                                            href="{{route('admin.orders.index')}}">@lang('labels.backend.dashboard.view_all')</a>
                                </h4>

                            </div>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <td>@lang('labels.backend.dashboard.ordered_by')</td>
                                    <td>@lang('labels.backend.dashboard.amount')</td>
                                    <td>@lang('labels.backend.dashboard.time')</td>
                                    <td>@lang('labels.backend.dashboard.view')</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($recent_orders) > 0)
                                    @foreach($recent_orders as $item)
                                        <tr>
                                            <td>
                                                {{$item->user->full_name}}
                                            </td>
                                            <td>{{$item->amount.' '.$appCurrency['symbol']}}</td>
                                            <td>{{$item->created_at->diffforhumans()}}</td>
                                            <td><a class="btn btn-sm btn-primary"
                                                   href="{{route('admin.orders.show', $item->id)}}" target="_blank"><i
                                                            class="fa fa-arrow-right"></i></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">@lang('labels.backend.dashboard.no_data')</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="d-inline-block form-group w-100">
                                <h4 class="mb-0">@lang('labels.backend.dashboard.recent_contact_requests') <a
                                            class="btn btn-primary float-right"
                                            href="{{route('admin.contact-requests.index')}}">@lang('labels.backend.dashboard.view_all')</a>
                                </h4>

                            </div>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <td>@lang('labels.backend.dashboard.name')</td>
                                    <td>@lang('labels.backend.dashboard.email')</td>
                                    <td>@lang('labels.backend.dashboard.message')</td>
                                    <td>@lang('labels.backend.dashboard.time')</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($recent_contacts) > 0)
                                    @foreach($recent_contacts as $item)
                                        <tr>
                                            <td>
                                                {{$item->name}}
                                            </td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->message}}</td>
                                            <td>{{$item->created_at->diffforhumans()}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">@lang('labels.backend.dashboard.no_data')</td>

                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                    @else
                        <div class="col-12">
                            <h1>@lang('labels.backend.dashboard.title')</h1>
                        </div>
                    @endif
                </div>
            </div><!--card-body-->
        </div><!--card-->
    </div><!--col-->
@endsection
