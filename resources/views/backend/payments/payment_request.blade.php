@extends('backend.layouts.app')

@section('title', __('menus.backend.sidebar.payments_requests.title').' | '.app_name())

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('menus.backend.sidebar.payments_requests.title')</h3>
    </div>
    <div class="card-body">
        <div class="d-block">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="{{ route('admin.payments.requests') }}"
                        style="{{ !request('status')? 'font-weight: 700': '' }}">{{trans('labels.general.all')}}</a>
                </li>
                |
                <li class="list-inline-item">
                    <a href="{{ route('admin.payments.requests') }}?status=1"
                        style="{{ request('status') == 1 ? 'font-weight: 700' : '' }}">{{trans('labels.backend.payments.status.approved')}}</a>
                </li>
                |
                <li class="list-inline-item">
                    <a href="{{ route('admin.payments.requests') }}?status=2"
                        style="{{ request('status') == 2 ? 'font-weight: 700' : '' }}">{{trans('labels.backend.payments.status.rejected')}}</a>
                </li>
            </ul>
        </div>
        <div class="table-responsive">
            <table id="earningTable" class="table table-bordered table-striped ">
                <thead>
                    <tr>
                        <th>@lang('labels.general.sr_no')</th>
                        <th>@lang('labels.general.id')</th>
                        <th>@lang('labels.backend.payments.fields.teacher_name')</th>
                        <th>@lang('labels.backend.payments.fields.amount')</th>
                        <th>@lang('labels.backend.payments.total_balance')</th>
                        <th>@lang('labels.backend.payments.fields.status')</th>
                        <th>@lang('labels.backend.payments.fields.date')</th>
                        @if(!request('status'))
                        <th>@lang('strings.backend.general.actions')</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal" id="updateRequestModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateRequestForm" class="form-material" method="post" accept-charset="UTF-8" data-url=''>
                <div class="modal-header">
                    <h4 class="modal-title">@lang('labels.general.buttons.update')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div id="update-notification-container"></div>
                    @csrf
                    <input type="hidden" name="status" value="" id="request_status">
                    <input type="hidden" name="id" value="" id="update_id">
                    {!! Form::label('remarks', trans('labels.backend.payments.fields.remarks'), ['class' =>
                    'control-label']) !!}
                    {!! Form::textarea('remarks', old('remarks'), ['class' => 'form-control ', 'placeholder' =>
                    trans('labels.backend.payments.fields.remarks')]) !!}

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-dismiss="modal">@lang('labels.general.buttons.cancel')</button>
                    <button type="submit"
                        class="btn btn-primary waves-effect waves-light ">@lang('labels.general.buttons.save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('after-scripts')
<script>
    $(document).ready(function () {
        var get_payment_request_data = '{{route('admin.payments.get_payment_request_data')}}?status={{request('status') }}';


        $('#earningTable').DataTable({
            processing: true,
            serverSide: true,
            iDisplayLength: 10,
            retrieve: true,
            dom: 'lfBrtip<"actions">',
            buttons: [{
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0,1, 2,3,4,6]
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [ 0,1, 2,3,4,6]
                    }
                },
                'colvis'
            ],
            ajax: get_payment_request_data,
            columns: [

                {
                    data: "DT_RowIndex",
                    name: 'DT_RowIndex',
                    width: '8%'
                },
                {
                    data: "id",
                    name: 'id',
                    width: '8%'
                },
                {
                    data: "teacher_name",
                    name: 'teacher_name'
                },
                {
                    data: "amount",
                    name: 'amount'
                },
                {
                    data: "balance",
                    name: 'balance'
                },
                {
                    data: "status",
                    name: 'status'
                },
                {
                    data: "created_at",
                    name: 'created_at'
                },
                @if(!request('status')) {
                    data: "actions",
                    name: "actions"
                },
                @endif
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",
                buttons: {
                    colvis: '{{trans("datatable.colvis")}}',
                    pdf: '{{trans("datatable.pdf")}}',
                    csv: '{{trans("datatable.csv")}}',
                }
            },
            createdRow: function (row, data, dataIndex) {
                $(row).attr('data-entry-id', data.id);
            },
        });
    });

    $(document).on('click', '.update-status-request', function () {
        $('#updateRequestForm').attr('data-url', $(this).data('url'));
        $('#request_status').val($(this).data('status'));
        $('#update_id').val($(this).data('id'));
        $('#updateRequestModal').modal('show');
    });

    $(document).on('submit', 'form#updateRequestForm', function (event) {
        event.preventDefault();
        var url = $(this).data('url');
        var form = this;
        var data = new FormData(this);

        $.ajax({
            method: "POST",
            url: url,
            data: data,
            processData: false,
            contentType: false,
        }).done(function (response) {
            $(form)[0].reset();
            location.reload();
        }).fail(function (jqXhr) {
            var data = jqXhr.responseJSON;
            var errorsHtml = '<div class="alert alert-danger"><ul>';

            $.each(data.errors, function (key, value) {
                errorsHtml += '<li>' + value + '</li>';
            });
            errorsHtml += '</ul></div>';
            $('#update-notification-container').html(errorsHtml);
        });

    });
</script>

@endpush