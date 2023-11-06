@extends('backend.layouts.app')

@section('title', __('labels.backend.teachers.title').' | '.app_name())
@push('after-styles')
<style>
    table th {
        width: 20%;
    }
</style>
@endpush
@section('content')

    <div class="card">

        <div class="card-header">
            <h3 class="page-title d-inline mb-0">@lang('labels.backend.teachers.title')</h3>
            <div class="float-right">
                <a href="{{ route('admin.teachers.index') }}"
                   class="btn btn-success">@lang('labels.backend.teachers.view')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('labels.backend.access.users.tabs.content.overview.avatar')</th>
                            <td><img height="100px" src="{{ $teacher->picture }}" class="user-profile-image" /></td>
                        </tr>

                        <tr>
                            <th>@lang('labels.backend.access.users.tabs.content.overview.name')</th>
                            <td>{{ $teacher->name }}</td>
                        </tr>

                        <tr>
                            <th>@lang('labels.backend.access.users.tabs.content.overview.email')</th>
                            <td>{{ $teacher->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.access.users.tabs.content.overview.status')</th>
                            <td>{!! $teacher->status_label !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.general_settings.user_registration_settings.fields.gender')</th>
                            <td>{!! $teacher->gender !!}</td>
                        </tr>
                        @php
                            $teacherProfile = $teacher->teacherProfile?:'';
                            $payment_details = $teacher->teacherProfile?json_decode($teacher->teacherProfile->payment_details):new stdClass();
                        @endphp
                        <tr>
                            <th>@lang('labels.teacher.facebook_link')</th>
                            <td>{!! $teacherProfile->facebook_link !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.teacher.twitter_link')</th>
                            <td>{!! $teacherProfile->twitter_link !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.teacher.linkedin_link')</th>
                            <td>{!! $teacherProfile->linkedin_link !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.teacher.payment_details')</th>
                            <td>{!! $teacherProfile->payment_method !!}</td>
                        </tr>
                        @if($teacherProfile->payment_method == 'bank')
                        <tr>
                            <th>@lang('labels.teacher.bank_details.name')</th>
                            <td>{!! $payment_details->bank_name !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.teacher.bank_details.bank_code')</th>
                            <td>{!! $payment_details->ifsc_code !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.teacher.bank_details.account')</th>
                            <td>{!! $payment_details->account_number !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.teacher.bank_details.holder_name')</th>
                            <td>{!! $payment_details->account_name !!}</td>
                        </tr>
                        @else
                        <tr>
                            <th>@lang('labels.teacher.paypal_email')</th>
                            <td>{!! $payment_details->paypal_email !!}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div><!-- Nav tabs -->
        </div>
    </div>
@stop
