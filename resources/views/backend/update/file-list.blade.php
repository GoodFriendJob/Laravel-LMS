@extends('backend.layouts.app')

@section('title',  __('labels.backend.update.title').' | '.app_name())

@push('after-styles')
    <style>
        ul.file-list{
            border: 2px solid;
            height: 300px;
            overflow: scroll;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="page-title d-inline">@lang('labels.backend.update.title')</h3>
                    <h3 class="float-right text-primary">@lang('labels.backend.update.current_version') {{config('app.version')}}</h3>

                </div><!--card-header-->
                <div class="card-body">
                    <h4>@lang('labels.backend.update.file_replaced')</h4>
                    <ul class="file-list">
                        @foreach($files as $file)
                            <li>{{$file}}</li>
                        @endforeach
                    </ul>
                    <form method="post" id="update-files" action="{{route('admin.update-files')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="file_name" value="{{$file_name }}">

                        <div class="form-group col-12 ">
                            <button value="cancel" name="submit" class="btn btn-danger mt-auto mr-5"
                                    >@lang('labels.general.buttons.cancel')</button>
                            <button value="update" name="submit" class="btn btn-primary mt-auto"
                                    >@lang('labels.general.buttons.update')</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection


@push('after-scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click','button[name="submit"]',function (e) {
                $('#update-files').submit();
            });
        })

    </script>
@endpush