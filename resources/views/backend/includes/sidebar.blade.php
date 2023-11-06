@inject('request', 'Illuminate\Http\Request')

<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('menus.backend.sidebar.general')
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon icon-speedometer"></i> @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>


            <!--=======================Custom menus===============================-->
            @can('order_access')
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'orders' ? 'active' : '' }}"
                    href="{{ route('admin.orders.index') }}">
                    <i class="nav-icon icon-bag"></i>
                    <span class="title">@lang('menus.backend.sidebar.orders.title')</span>
                </a>
            </li>
            @endcan
            @if ($logged_in_user->isAdmin())
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(2) == 'teachers' ? 'active' : '' }}"
                    href="{{ route('admin.teachers.index') }}">
                    <i class="nav-icon icon-directions"></i>
                    <span class="title">@lang('menus.backend.sidebar.teachers.title')</span>
                </a>
            </li>
            @endif

            @can('category_access')
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(2) == 'categories' ? 'active' : '' }}"
                    href="{{ route('admin.categories.index') }}">
                    <i class="nav-icon icon-folder-alt"></i>
                    <span class="title">@lang('menus.backend.sidebar.categories.title')</span>
                </a>
            </li>
            @endcan
            @if((!$logged_in_user->hasRole('student')) && ($logged_in_user->hasRole('teacher') ||
            $logged_in_user->isAdmin() ||
            $logged_in_user->hasAnyPermission(['course_access','lesson_access','test_access','question_access','textgroup_access','bundle_access'])))
            {{--@if($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['course_access','lesson_access','test_access','question_access','bundle_access']))--}}

            <li
                class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern(['user/courses*','user/lessons*','user/tests*','user/questions*','user/live-lessons*','user/live-lesson-slots*']), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/*')) }}" href="#">
                    <i class="nav-icon icon-puzzle"></i> @lang('menus.backend.sidebar.courses.management')


                </a>

                <ul class="nav-dropdown-items">

                    @can('course_access')
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'courses' ? 'active' : '' }}"
                            href="{{ route('admin.courses.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.courses.title')</span>
                        </a>
                    </li>
                    @endcan

                    @can('lesson_access')
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'lessons' ? 'active' : '' }}"
                            href="{{ route('admin.lessons.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.lessons.title')</span>
                        </a>
                    </li>
                    @endcan

                    @can('test_access')
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'tests' ? 'active' : '' }}"
                            href="{{ route('admin.tests.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.tests.title')</span>
                        </a>
                    </li>
                    @endcan
                    
                    @can('course_access')
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'reorder-lesson-test' ? 'active' : '' }}"
                            href="{{ route('admin.courses.reorder_lesson_test') }}">
                            <span class="title">@lang('menus.backend.sidebar.reoder-lesson-test.title')</span>
                        </a>
                    </li>
                    @endcan


                    @can('question_access')
                    <li class="nav-item">
                        <a class="nav-link {{ $request->segment(2) == 'questions' ? 'active' : '' }}"
                            href="{{ route('admin.questions.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.questions.title')</span>
                        </a>
                    </li>

                    @endcan

                    {{-- @can('textgroup_access')  --}}
                    <li class="nav-item">
                        <a class="nav-link {{ $request->segment(2) == 'textgroups' ? 'active' : '' }}"
                            href="{{ route('admin.textgroups.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.textgroups.title')</span>
                        </a>
                    </li>
                    {{-- @endcan  --}}

                    <li class="nav-item">
                        <a class="nav-link {{ $request->segment(2) == 'testreports' ? 'active' : '' }}"
                            href="{{ route('admin.testreports.index') }}">
                            <span class="title">Test Report</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ $request->segment(2) == 'charts' ? 'active' : '' }}"
                            href="{{ route('admin.charts.index') }}">
                            <span class="title">Charts & Tables</span>
                        </a>
                    </li>


                    @can('live_lesson_access')
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'live-lessons' ? 'active' : '' }}"
                            href="{{ route('admin.live-lessons.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.live_lessons.title')</span>
                        </a>
                    </li>
                    @endcan

                    @can('live_lesson_slot_access')
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'live-lesson-slots' ? 'active' : '' }}"
                            href="{{ route('admin.live-lesson-slots.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.live_lesson_slots.title')</span>
                        </a>
                    </li>
                    @endcan

                </ul>
            </li>
            @can('bundle_access')
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(2) == 'bundles' ? 'active' : '' }}"
                    href="{{ route('admin.bundles.index') }}">
                    <i class="nav-icon icon-layers"></i>
                    <span class="title">@lang('menus.backend.sidebar.bundles.title')</span>
                </a>
            </li>
            @endcan
            @if($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin())
            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern(['user/reports*']), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/*')) }}" href="#">
                    <i class="nav-icon icon-pie-chart"></i>@lang('menus.backend.sidebar.reports.title')

                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(1) == 'sales' ? 'active' : '' }}"
                            href="{{ route('admin.reports.sales') }}">
                            @lang('menus.backend.sidebar.reports.sales')
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(1) == 'students' ? 'active' : '' }}"
                            href="{{ route('admin.reports.students') }}">@lang('menus.backend.sidebar.reports.students')
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            @endif








            @if ($logged_in_user->isAdmin() ||
            $logged_in_user->hasAnyPermission(['blog_access','page_access','reason_access']))
            <li
                class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern(['user/contact','user/sponsors*','user/testimonials*','user/faqs*','user/footer*','user/blogs','user/sitemap*']), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/*')) }}" href="#">
                    <i class="nav-icon icon-note"></i> @lang('menus.backend.sidebar.site-management.title')
                </a>

                <ul class="nav-dropdown-items">
                    @can('page_access')
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'pages' ? 'active' : '' }}"
                            href="{{ route('admin.pages.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.pages.title')</span>
                        </a>
                    </li>
                    @endcan
                    @can('blog_access')
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'blogs' ? 'active' : '' }}"
                            href="{{ route('admin.blogs.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.blogs.title')</span>
                        </a>
                    </li>
                    @endcan
                    @can('reason_access')
                    <li class="nav-item">
                        <a class="nav-link {{ $request->segment(2) == 'reasons' ? 'active' : '' }}"
                            href="{{ route('admin.reasons.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.reasons.title')</span>
                        </a>
                    </li>
                    @endcan
                    @if ($logged_in_user->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/menu-manager')) }}"
                            href="{{ route('admin.menu-manager') }}">
                            {{ __('menus.backend.sidebar.menu-manager.title') }}</a>
                    </li>


                    <li class="nav-item ">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/sliders*')) }}"
                            href="{{ route('admin.sliders.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.hero-slider.title')</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'sponsors' ? 'active' : '' }}"
                            href="{{ route('admin.sponsors.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.sponsors.title')</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'testimonials' ? 'active' : '' }}"
                            href="{{ route('admin.testimonials.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.testimonials.title')</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'forums-category' ? 'active' : '' }}"
                            href="{{ route('admin.forums-category.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.forums-category.title')</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'faqs' ? 'active' : '' }}"
                            href="{{ route('admin.faqs.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.faqs.title')</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'contact' ? 'active' : '' }}"
                            href="{{ route('admin.contact-settings') }}">
                            <span class="title">@lang('menus.backend.sidebar.contact.title')</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'newsletter' ? 'active' : '' }}"
                            href="{{ route('admin.newsletter-settings') }}">
                            <span class="title">@lang('menus.backend.sidebar.newsletter-configuration.title')</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'footer' ? 'active' : '' }}"
                            href="{{ route('admin.footer-settings') }}">
                            <span class="title">@lang('menus.backend.sidebar.footer.title')</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'sitemap' ? 'active' : '' }}"
                            href="{{ route('admin.sitemap.index') }}">
                            <span class="title">@lang('menus.backend.sidebar.sitemap.title')</span>
                        </a>
                    </li>
                    @endif

                </ul>


            </li>
            @else
            @can('blog_access')
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(2) == 'blogs' ? 'active' : '' }}"
                    href="{{ route('admin.blogs.index') }}">
                    <i class="nav-icon icon-note"></i>
                    <span class="title">@lang('menus.backend.sidebar.blogs.title')</span>
                </a>
            </li>
            @endcan
            @can('reason_access')
            <li class="nav-item">
                <a class="nav-link {{ $request->segment(2) == 'reasons' ? 'active' : '' }}"
                    href="{{ route('admin.reasons.index') }}">
                    <i class="nav-icon icon-layers"></i>
                    <span class="title">@lang('menus.backend.sidebar.reasons.title')</span>
                </a>
            </li>
            @endcan
            @endif

            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'messages' ? 'active' : '' }}"
                    href="{{ route('admin.messages') }}">
                    <i class="nav-icon icon-envelope-open"></i> <span
                        class="title">@lang('menus.backend.sidebar.messages.title')</span>
                </a>
            </li>
            @if ($logged_in_user->hasRole('student'))
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'invoices' ? 'active' : '' }}"
                    href="{{ route('admin.invoices.index') }}">
                    <i class="nav-icon icon-notebook"></i> <span
                        class="title">@lang('menus.backend.sidebar.invoices.title')</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'certificates' ? 'active' : '' }}"
                    href="{{ route('admin.certificates.index') }}">
                    <i class="nav-icon icon-badge"></i> <span
                        class="title">@lang('menus.backend.sidebar.certificates.title')</span>
                </a>
            </li>
            @endif
            @if ($logged_in_user->hasRole('teacher'))
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'reviews' ? 'active' : '' }}"
                    href="{{ route('admin.reviews.index') }}">
                    <i class="nav-icon icon-speech"></i> <span
                        class="title">@lang('menus.backend.sidebar.reviews.title')</span>
                </a>
            </li>
            @endif

            @if ($logged_in_user->isAdmin())
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'contact-requests' ? 'active' : '' }}"
                    href="{{ route('admin.contact-requests.index') }}">
                    <i class="nav-icon icon-envelope-letter"></i>
                    <span class="title">@lang('menus.backend.sidebar.contacts.title')</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'contact-requests' ? 'active' : '' }}"
                    href="{{ route('admin.coupons.index') }}">
                    <i class="nav-icon icon-star"></i>
                    <span class="title">@lang('menus.backend.sidebar.coupons.title')</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'contact-requests' ? 'active' : '' }}"
                    href="{{ route('admin.tax.index') }}">
                    <i class="nav-icon icon-credit-card"></i>
                    <span class="title">@lang('menus.backend.sidebar.tax.title')</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'contact-requests' ? 'active' : '' }}"
                    href="{{ route('admin.payments.requests') }}">
                    <i class="nav-icon icon-people"></i>
                    <span class="title">@lang('menus.backend.sidebar.payments_requests.title')</span>
                </a>
            </li>
            @endif
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'account' ? 'active' : '' }}"
                    href="{{ route('admin.account') }}">
                    <i class="nav-icon icon-key"></i>
                    <span class="title">@lang('menus.backend.sidebar.account.title')</span>
                </a>
            </li>
           
           
            @if ($logged_in_user->hasRole('student'))
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'subscriptions' ? 'active' : '' }}"
                    href="{{ route('admin.subscriptions') }}">
                    <i class="nav-icon fas fa-briefcase"></i>
                    <span class="title">@lang('menus.backend.sidebar.subscription.title')</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'wishlist' ? 'active' : '' }}"
                    href="{{ route('admin.wishlist.index') }}">
                    <i class="nav-icon fas fa-heart"></i>
                    <span class="title">@lang('menus.backend.sidebar.wishlist.title')</span>
                </a>
            </li>

            <!-- <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'reports' ? 'active' : '' }}"
                   href="{{ url('user/testreports/studentreport') }}">
                    <i class="nav-icon fas fa-heart"></i>
                    <span class="title">@lang('menus.backend.sidebar.reports.title')</span>
                </a>
            </li> -->
            
            <li class="nav-item nav-dropdown {{ $request->segment(1) == 'reports' ? 'active' : '' }}">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon fas fa-heart"></i> @lang('menus.backend.sidebar.reports.title')
                </a>
                <ul class="nav-dropdown-items">
                <li class="nav-item nav-dropdown {{ $request->segment(1) == 'reports' ? 'active' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fas fa-download "></i> Reports 
                        </a>
                        <ul class="nav-dropdown-items">

                            @foreach($sidebarData as $sidemenus)
                            <li class="nav-item nav-dropdown {{ $request->segment(1) == 'reports' ? 'active' : '' }}">
                                 <a class="nav-link nav-dropdown-toggle" href="#">
                                    <i class="nav-icon fas fa-file-alt"></i>{{$sidemenus['title']}}
                                </a>
                                <ul class="nav-dropdown-items">

                             @foreach($sidemenus['tests'] as $ts)
                            <li class="nav-item" style="margin-left: 35px;">
                                <!-- <a download class="nav-link" href="{{asset('/').'/'.$ts['report_pdf']}}"> -->
                                    <a  class="nav-link" href="{{route('pdf.showreport',['course_id' => $sidemenus['id'],'slug'=>$ts['slug'],'test_id'=>$ts['id']])}}">
                                    {{$ts['title']}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                             <li class="nav-item nav-dropdown {{ $request->segment(1) == 'reports' ? 'active' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fas fa-download "></i> Questionnaire 
                        </a>
                        <ul class="nav-dropdown-items">

                            @foreach($sidebarData as $sidemenus)
                            <li class="nav-item nav-dropdown {{ $request->segment(1) == 'reports' ? 'active' : '' }}">
                                 <a class="nav-link nav-dropdown-toggle" href="#">
                                    <i class="nav-icon fas fa-file-alt"></i>{{$sidemenus['title']}}
                                </a>
                                <ul class="nav-dropdown-items">

                             @foreach($sidemenus['tests'] as $ts)
                            <li class="nav-item" style="margin-left: 35px;">
                                <!-- <a download class="nav-link" href="{{asset('/').'/'.$ts['questions_ans_pdf']}}"> -->
                                    <a  class="nav-link" href="{{route('pdf.show',['course_id' => $sidemenus['id'],'slug'=>$ts['slug'],'test_id'=>$ts['id']])}}">
                                    {{$ts['title']}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                 

                </ul>
            </li>
            @endif
            @if ($logged_in_user->isAdmin())
<!-- 
            <li class="nav-title">
                Time limit for answer
            </li> -->
            <li class="nav-title">
                @lang('menus.backend.sidebar.system')
            </li>

            <li
                class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern(['admin/stripe*','admin/stripe/plans*']), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/stripe*')) }}"
                    href="#">
                    <i class="nav-icon fab fa-stripe"></i> @lang('menus.backend.stripe.title')
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/stripe/plans*')) }}"
                            href="{{ route('admin.stripe.plans.index') }}">
                            @lang('menus.backend.stripe.plan')
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth*')) }}"
                    href="#">
                    <i class="nav-icon icon-user"></i> @lang('menus.backend.access.title')

                    @if ($pending_approval > 0)
                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                    @endif
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user*')) }}"
                            href="{{ route('admin.auth.user.index') }}">
                            @lang('labels.backend.access.users.management')

                            @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}"
                            href="{{ route('admin.auth.role.index') }}">
                            @lang('labels.backend.access.roles.management')
                        </a>
                    </li>
                </ul>
            </li>


            <!--==================================================================-->
            <li class="divider"></li>

            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/settings*')) }}"
                    href="#">
                    <i class="nav-icon icon-settings"></i> @lang('menus.backend.sidebar.settings.title')
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/settings')) }}"
                            href="{{ route('admin.general-settings') }}">
                            @lang('menus.backend.sidebar.settings.general')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}"
                            href="{{ route('admin.social-settings') }}">
                            @lang('menus.backend.sidebar.settings.social-login')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/settings/zoom-settings*')) }}"
                            href="{{ route('admin.zoom-settings') }}">
                            @lang('menus.backend.sidebar.settings.zoom_setting')
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(1) == 'account' ? 'active' : '' }}"
                            href="{{ route('admin.time_limit') }}">
                            <i class="nav-icon icon-key"></i>
                            <span class="title">@lang('menus.backend.sidebar.timelimmit.title')</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/log-viewer*')) }}"
                    href="#">
                    <i class="nav-icon icon-list"></i> @lang('menus.backend.sidebar.debug-site.title')
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}"
                            href="{{ route('log-viewer::dashboard') }}">
                            @lang('menus.backend.log-viewer.dashboard')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}"
                            href="{{ route('log-viewer::logs.list') }}">
                            @lang('menus.backend.log-viewer.logs')
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'translation-manager' ? 'active' : '' }}"
                    href="{{ asset('user/translations') }}">
                    <i class="nav-icon icon-docs"></i>
                    <span class="title">@lang('menus.backend.sidebar.translations.title')</span>
                </a>
            </li>

            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'backup' ? 'active' : '' }}"
                    href="{{ route('admin.backup') }}">
                    <i class="nav-icon icon-shield"></i>
                    <span class="title">@lang('menus.backend.sidebar.backup.title')</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'update-theme' ? 'active' : '' }}"
                    href="{{ route('admin.update-theme') }}">
                    <i class="nav-icon icon-refresh"></i>
                    <span class="title">@lang('menus.backend.sidebar.update.title')</span>
                </a>
            </li>
            @endif

            @if ($logged_in_user->hasRole('teacher'))
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(2) == 'payments' ? 'active' : '' }}"
                    href="{{ route('admin.payments') }}">
                    <i class="nav-icon icon-wallet"></i>
                    <span class="title">@lang('menus.backend.sidebar.payments.title')</span>
                </a>
            </li>
            @endif

        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
<!--sidebar-->