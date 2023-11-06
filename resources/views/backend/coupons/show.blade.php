@extends('backend.layouts.app')
@section('title', __('labels.backend.coupons.title').' | '.app_name())

@section('content')

    <div class="card">

        <div class="card-header">
            <h3 class="page-title mb-0 float-left">@lang('labels.backend.coupons.title')</h3>
            <div class="float-right">
                <a href="{{ route('admin.coupons.index') }}"
                   class="btn btn-success">@lang('labels.backend.coupons.view')</a>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-striped">
                       <tr>
                           <th width="20%">@lang('labels.backend.coupons.fields.name')</th>
                           <td>
                             {{$coupon->name}}
                           </td>
                       </tr>
                        <tr>
                            <th width="20%">@lang('labels.backend.coupons.fields.description')</th>
                            <td>
                                {{$coupon->description}}
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.coupons.fields.code')</th>
                            <td>
                                {{$coupon->code}}
                            </td>
                        </tr>

                        <tr>
                            <th>@lang('labels.backend.coupons.fields.type')</th>
                            <td>
                                @if($coupon->type == 1)
                                    @lang('labels.backend.coupons.discount_rate') (in %)
                                @else
                                    @lang('labels.backend.coupons.flat_rate') ( in {{config('app.currency')}})
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.coupons.fields.amount')</th>
                            <td>{{$coupon->amount}}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.coupons.fields.expires_at')</th>
                            <td>
                                @if($coupon->expires_at)
                                    {{\Illuminate\Support\Carbon::parse($coupon->expires_at)->format('d M Y')}}
                                @else
                                    @lang('labels.backend.coupons.unlimited')
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.coupons.fields.status')</th>
                            <td>
                                @if($coupon->status == 1)
                                    @lang('labels.backend.coupons.on')
                                @else
                                    @lang('labels.backend.coupons.off')
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.coupons.fields.min_price')</th>
                            <td>
                                {{$coupon->min_price}}
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.coupons.fields.per_user_limit')</th>
                            <td>
                                {{$coupon->per_user_limit}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->

            <a href="{{ route('admin.coupons.index') }}" class="btn btn-default border">@lang('strings.backend.general.app_back_to_list')</a>
        </div>
    </div>
@stop