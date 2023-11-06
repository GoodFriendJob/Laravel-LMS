@extends('frontend.layouts.app'.config('theme_layout'))

@section('title', ($blog->meta_title) ? $blog->meta_title : app_name() )
@section('meta_description', $blog->meta_description)
@section('meta_keywords', $blog->meta_keywords)

@section('content')

    <!-- Start of breadcrumb section
    ============================================= -->
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">{{$blog->title}}</h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
        ============================================= -->


    <!-- Start of Blog single content
        ============================================= -->
    <section id="blog-detail" class="blog-details-section">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="blog-details-content">
                        <div class="post-content-details">
                            @if($blog->image != "")

                                <div class="blog-detail-thumbnile mb35">
                                    <img src="{{asset('storage/uploads/'.$blog->image)}}" alt="">
                                </div>
                            @endif

                            <h2>{{$blog->title}}</h2>

                            <div class="date-meta text-uppercase">
                                <span><i class="fas fa-calendar-alt"></i> {{$blog->created_at->format('d M Y')}}</span>
                                <span><i class="fas fa-user"></i> {{$blog->author->name}}</span>
                                <span><i class="fas fa-comment-dots"></i> {{$blog->comments->count()}}</span>
                                <span><i class="fas fa-tag"><a
                                                href="{{route('blogs.category',['category' => $blog->category->slug])}}"> {{$blog->category->name}}</a></i></span>
                            </div>
                            <p>
                                {!! $blog->content !!}
                            </p>


                        </div>
                        <div class="blog-share-tag">
                            <div class="share-text float-left">
                                @lang('labels.frontend.blog.share_this_news')
                            </div>

                            <div class="share-social ul-li float-right">
                                <ul>
                                    <li><a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u={{url()->current()}}"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a target="_blank" href="http://twitter.com/share?url={{url()->current()}}&text={{$blog->title}}"><i class="fab fa-twitter"></i></a></li>
                                    <li><a target="_blank" href="http://www.linkedin.com/shareArticle?url={{url()->current()}}&title={{$blog->title}}&summary={{substr(strip_tags($blog->content),0,40)}}..."><i class="fab fa-linkedin"></i></a></li>
                                    <li><a target="_blank" href="https://api.whatsapp.com/send?phone=&text={{url()->current()}}"><i class="fab fa-whatsapp"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="author-comment d-inline-block p-3   h-100 d-table text-center mx-auto">
                            <div class="author-img float-none">
                                <img src="{{$blog->author->picture}}" alt="">
                            </div>
                            <span class="mt-2  d-table-cell align-middle">BY:  <b>{{$blog->author->name}}</b></span>
                        </div>

                        <div class="next-prev-post">
                            @if($previous != "")
                                <div class="next-post-item float-left">
                                    <a href="{{route('blogs.index',['slug'=>$previous->slug.'-'.$previous->id ])}}"><i
                                                class="fas fa-arrow-circle-left"></i>Previous Post</a>
                                </div>
                            @endif

                            @if($next != "")
                                <div class="next-post-item float-right">
                                    <a href="{{route('blogs.index',['slug'=>$next->slug.'-'.$next->id ])}}">Next Post<i
                                                class="fas fa-arrow-circle-right"></i></a>
                                </div>
                                @endif

                        </div>
                    </div>

                    <div class="blog-recent-post about-teacher-2">
                        <div class="section-title-2  headline text-left">
                            <h2> @lang('labels.frontend.blog.related_news')</h2>
                        </div>
                        @if(count($related_news) > 0)
                            <div class="recent-post-item">
                                <div class="row">
                                    @foreach($related_news as $item)
                                        <div class="col-md-6">
                                            <div class="blog-post-img-content">
                                                <div class="blog-img-date relative-position">
                                                    <div class="blog-thumnile" @if($item->image != "") style="background-image: url({{asset('storage/uploads/'.$item->image)}})" @endif></div>

                                                    <div class="course-price text-center gradient-bg">
                                                        <span>{{$item->created_at->format('d M Y')}}</span>
                                                    </div>
                                                </div>
                                                <div class="blog-title-content headline">
                                                    <h3>
                                                        <a href="{{route('blogs.index',['slug'=>$item->slug.'-'.$item->id ])}}">{{$item->title}}</a>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="blog-comment-area ul-li about-teacher-2">
                        <div class="reply-comment-box">
                            <div class="section-title-2  headline text-left">
                                <h2> @lang('labels.frontend.blog.post_comments')</h2>
                            </div>

                            @if(auth()->check())
                                <div class="teacher-faq-form">
                                    <form method="POST" action="{{route('blogs.comment',['id'=>$blog->id])}}"
                                          data-lead="Residential">
                                        @csrf
                                        <div class="form-group">
                                            <label for="comment"> @lang('labels.frontend.blog.write_a_comment')</label>
                                            <textarea name="comment" required class="mb-0" id="comment" rows="2"
                                                      cols="20"></textarea>
                                            <span class="help-block text-danger">{{ $errors->first('comment', ':message') }}</span>
                                        </div>

                                        <div class="nws-button text-center  gradient-bg text-uppercase">
                                            <button type="submit" value="Submit"> @lang('labels.frontend.blog.add_comment')</button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <a id="openLoginModal" class="btn nws-button gradient-bg text-white"
                                   data-target="#myModal"> @lang('labels.frontend.blog.login_to_post_comment')</a>
                            @endif
                        </div>
                        @if($blog->comments->count() > 0)

                        <ul class="comment-list my-5">
                                @foreach($blog->comments as $item)
                                <li class="d-block">
                                    <div class="comment-avater">
                                        <img src="{{$item->user->picture}}" alt="">
                                    </div>

                                    <div class="author-name-rate">
                                        <div class="author-name float-left">
                                            @lang('labels.frontend.blog.by'): <span>{{$item->name}}</span>
                                        </div>

                                        <div class="time-comment float-right">{{$item->created_at->diffforhumans()}}</div><br>
                                        @if($item->user_id == auth()->user()->id)
                                        <div class="time-comment float-right">

                                            <a class="text-danger font-weight-bolf" href="{{route('blogs.comment.delete',['id'=>$item->id])}}"> @lang('labels.general.delete')</a>

                                        </div>
                                        @endif
                                    </div>
                                    <div class="author-designation-comment">
                                        <p>{{$item->comment}}</p>
                                    </div>
                                </li>
                                @endforeach


                        </ul>
                        @else
                            <p class="my-5">@lang('labels.frontend.blog.no_comments_yet')</p>
                        @endif



                    </div>
                </div>
                @include('frontend.blogs.partials.sidebar')
            </div>
        </div>
    </section>
    <!-- End of Blog single content
        ============================================= -->


@endsection