@extends('backend.layouts.app')

@section('title', __('labels.backend.certificates.title').' | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title ">@lang('labels.backend.certificates.title')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="table-responsive">

                        <table id="myTable"
                               class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th>@lang('labels.general.sr_no')</th>
                                <th>@lang('labels.backend.certificates.fields.course_name')</th>
                                <th>@lang('labels.backend.certificates.fields.progress')</th>
                                <th>@lang('labels.backend.certificates.fields.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(count($certificates) > 0)
                                @foreach($certificates as $key=>$certificate)
                                    @php $key++; @endphp
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$certificate->course->title}}</td>
                                        <td>{{$certificate->course->progress() }}%</td>
                                        <th>
                                            @if($certificate->course->progress() == 100)
                                                <a href="{{asset('storage/certificates/'.$certificate->url)}}" class="btn btn-success">
                                                    @lang('labels.backend.certificates.view') </a>

                                                <a class="btn btn-primary" href="{{route('admin.certificates.download',['certificate_id'=>$certificate->id])}}">
                                                    @lang('labels.backend.certificates.download') </a>
                                            @endif
                                        </th>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {

            $('#myTable').DataTable({
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2]

                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    'colvis'
                ],
                language:{
                    url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",
                    buttons :{
                        colvis : '{{trans("datatable.colvis")}}',
                        pdf : '{{trans("datatable.pdf")}}',
                        csv : '{{trans("datatable.csv")}}',
                    }
                }

            });
        });

    </script>

@endpush