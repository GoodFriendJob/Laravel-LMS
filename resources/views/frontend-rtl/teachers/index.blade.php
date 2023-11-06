@extends('frontend-rtl.layouts.app'.config('theme_layout'))
@push('after-styles')
    <style>
        .couse-pagination li.active {
            color: #333333!important;
            font-weight: 700;
        }
        .page-link {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #c7c7c7;
            background-color: white;
            border: none;
        }
        .page-item.active .page-link {
            z-index: 1;
            color: #333333;
            background-color:white;
            border:none;

        }
        ul.pagination{
            display: inline;
            text-align: center;
        }
    </style>
@endpush
@section('content')

	<!-- Start of breadcrumb section
		============================================= -->
		<section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
			<div class="blakish-overlay"></div>
			<div class="container">
				<div class="page-breadcrumb-content text-center">
					<div class="page-breadcrumb-title">
						<h2 class="breadcrumb-head black bold">{{env('APP_NAME')}} <span>@lang('labels.frontend.teacher.title')</span></h2>
					</div>
				</div>
			</div>
		</section>
	<!-- End of breadcrumb section
		============================================= -->



	<!-- Start of teacher section
		============================================= -->
		<section id="teacher-page" class="teacher-page-section">
			<div class="container">
				<div class="row">
					<div class="col-md-9">
						<div class="teachers-archive">
							<div class="row">
                                @if(count($teachers) > 0)
                                @foreach($teachers as $item)
								<div class="col-md-4 col-sm-6">
									<div class="teacher-pic-content">
										<div class="teacher-img-content relative-position">
											<img src="{{$item->picture}}" alt="">
											<div class="teacher-hover-item">
												<div class="teacher-social-name ul-li-block">
													<ul>
                                                        <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                                                        <li><a href="{{route('admin.messages',['teacher_id'=>$item->id])}}"><i class="fa fa-comments"></i></a></li>
													</ul>
												</div>
												{{--<div class="teacher-text">--}}
													{{--Lorem ipsum dolor  consectuer adipiscing elit, nonummy nibh euismod tincidunt.--}}
												{{--</div>--}}
											</div>
											<div class="teacher-next text-center">
												<a href="{{route('teachers.show',['id'=>$item->id])}}"><i class="text-gradiant fas fa-arrow-right"></i></a>
											</div>
										</div>
										<div class="teacher-name-designation">
											<span class="teacher-name">{{$item->full_name}}</span>
											{{--<span class="teacher-designation">Mobile Apps</span>--}}
										</div>
									</div>
								</div>
                                @endforeach
                                @else
                                    <h4>@lang('lables.general.no_data_available')</h4>
                                @endif


							</div>
							<div class="couse-pagination text-center ul-li">
                                {{ $teachers->links() }}
							</div>
							
						</div>
					</div>
					@include('frontend.layouts.partials.right-sidebar')
				</div>
			</div>
		</section>
	<!-- End of teacher section
		============================================= -->



@endsection