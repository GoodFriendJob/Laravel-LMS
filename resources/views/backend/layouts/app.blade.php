<!DOCTYPE html>
@if(config('app.display_type') == 'rtl' || (session()->has('display_type') && session('display_type') == 'rtl'))
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

    @else
        <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

        @endif
        {{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">--}}
        {{--@else--}}
        {{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
        {{--@endlangrtl--}}
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            
            <title>@yield('title', app_name())</title>
            <meta name="description" content="@yield('meta_description', 'Laravel 5 Boilerplate')">
            <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
            @if(config('favicon_image') != "")
                <link rel="shortcut icon" type="image/x-icon"
                      href="{{asset('storage/logos/'.config('favicon_image'))}}"/>
            @endif
            @yield('meta')
            <link rel="stylesheet" href="{{asset('css/select2.min.css')}}"/>
            <link rel="stylesheet" href="{{asset('css/jquery.nestable.css')}}"/>
            <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap.css')}}"/>

            <link rel="stylesheet" type="{{asset('css/select2.css')}}"/>
            <link rel="stylesheet" href="{{asset('assets/css/fontawesome-all.css')}}"/>
            <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.7.2/css/all.css"/>
                <link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/jstree/dist/themes/default/style.min.css')}}"/>

            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>


            <link rel="stylesheet"
                  href="//cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>
            <link rel="stylesheet"
                  href="https://cdn.datatables.net/select/1.2.0/css/select.dataTables.min.css"/>
            <link rel="stylesheet"
                  href="//cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css"/>
            
            <link href="{{asset('assets/metronic_assets/global/plugins/icheck/skins/all.css')}}" id="style_components" rel="stylesheet" type="text/css"/>
            <link href="{{asset('assets/metronic_assets/global/css/components.css')}}" id="style_components" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/bootstrap-select/bootstrap-select.min.css')}}"/>
           
            <link rel="stylesheet" type="text/css" href="{{asset('css/table-bs.css')}}"/>
           
      
            <link rel="stylesheet" type="text/css" href="{{asset('css/backend.css')}}"/>
           
            @stack('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
            <!-- Otherwise apply the normal LTR layouts -->


            @stack('after-styles')

            @if((config('app.display_type') == 'rtl') || (session('display_type') == 'rtl'))
                <style>
                    .float-left {
                        float: right !important;
                    }

                    .float-right {
                        float: left !important;
                    }
                </style>
            @endif
            <script>
            var siteinfo = {
                url_root:'{{ url('') }}',
            };
            </script>
        </head>

        <body class="{{ config('backend.body_classes') }}">
        @include('backend.includes.header')

        <div class="app-body">
            @include('backend.includes.sidebar')

            <main class="main">
                @include('includes.partials.logged-in-as')
                {{--{!! Breadcrumbs::render() !!}--}}

                <div class="container-fluid" style="padding-top: 30px">
                    <div class="animated fadeIn">
                        <div class="content-header">
                            @yield('page-header')
                        </div><!--content-header-->

                        @include('includes.partials.messages')
                        @yield('content')
                    </div><!--animated-->
                </div><!--container-fluid-->
            </main><!--main-->

            {{--@include('backend.includes.aside')--}}
        </div><!--app-body-->

        @include('backend.includes.footer')

        <!-- Scripts -->
        @stack('before-scripts')
        <!-- {!! script(mix('js/manifest.js')) !!}
        {!! script(mix('js/vendor.js')) !!}
        {!! script(mix('js/backend.js')) !!} -->

        <script src="{{asset('js/manifest.js')}}"></script>
        <script src="{{asset('js/vendor.js')}}"></script>
        <script src="{{asset('js/backend.js')}}"></script>
        <script>
            //Route for message notification
            var messageNotificationRoute = '{{route('admin.messages.unread')}}'
        </script>
        <script src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="{{asset('js/pdfmake.min.js')}}"></script>
        <script src="{{asset('js/vfs_fonts.js')}}"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
        <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


        <script src="{{asset('js/select2.full.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/main.js')}}" type="text/javascript"></script>


        <script src="{{asset('js/ui-nestable.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/jquery.nestable.js')}}" type="text/javascript"></script>

        <!-- <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script> -->
        <script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/dataTables.bootstrap.js')}}"></script>
        
        <script type="text/javascript" src="{{asset('js/table-editable.js')}}"></script>
        
        <script src="{{asset('assets/metronic_assets/global/plugins/jstree/dist/jstree.min.js')}}"></script>
<!-- END PAGE LEVEL SCRIPTS -->
        <script src="{{asset('js/ui-tree.js')}}"></script>
        {{--  <script src="{{asset('js/ui-tree2.js')}}"></script>  --}}

        

        <script>
            window._token = '{{ csrf_token() }}';
        
        </script>

        @stack('after-scripts')

    </body>
</html>
