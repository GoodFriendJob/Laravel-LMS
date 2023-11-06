@extends('backend.layouts.app')

@section('title', __('labels.backend.subscription.title').' | '.app_name())

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
                </div><!--card-header-->
                <div class="card-body">
                    <div class="row">
                        @if(auth()->user()->subscription('default'))
                        @if(!auth()->user()->subscription('default')->cancelled())
                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-dark text-center py-3">
                                <div class="card-body">
                                    <h1 class="text-uppercase">{{ $activePlan->name }}</h1>
                                    <h3>@lang('labels.backend.subscription.active_plan')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-dark text-center py-3">
                                <div class="card-body">
                                    <h1 class="">{{ trans_choice('labels.backend.subscription.quantity', $activePlan->bundle, ['quantity' => $activePlan->bundle]) }}</h1>
                                    <h3>@lang('labels.backend.subscription.bundle')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-dark text-center py-3">
                                <div class="card-body">
                                    <h1 class="">{{ trans_choice('labels.backend.subscription.quantity', $activePlan->course, ['quantity' => $activePlan->course]) }}</h1>
                                    <h3>@lang('labels.backend.subscription.course')</h3>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif
                        @if(auth()->user()->subscription('default'))
                        <div class="col-md-12">
                            <div class="d-inline-block form-group w-100">
                                <h4 class="mb-0">
                                    @if(auth()->user()->subscription()->cancelled())
                                    @lang('labels.backend.subscription.subscribe_plan')
                                    <a href="{{ route('subscription.plans') }}"
                                       class="btn btn-primary">
                                        @lang('labels.backend.subscription.click_here')
                                    </a>
                                    @else
                                    @lang('labels.backend.subscription.cancel_title')
                                    <a href="{{ route('admin.subscriptions.delete') }}"
                                       class="btn btn-primary">
                                        @lang('labels.backend.subscription.click_here')
                                    </a>
                                    @endif
                                </h4>
                            </div>

                        </div>
                        @endif


                        <div class="col-md-12 col-12">
                            <div class="d-inline-block form-group w-100">
                                <h4 class="mb-0">@lang('labels.backend.subscription.invoice_list') </h4>
                            </div>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <td>@lang('labels.backend.subscription.date')</td>
                                    <td>@lang('labels.backend.subscription.sub_total')</td>
                                    <td>@lang('labels.backend.subscription.total')</td>
                                    <td>@lang('labels.backend.subscription.download')</td>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->date()->toFormattedDateString() }}</td>
                                        <td>{{ $invoice->subtotal() }}</td>
                                        <td>{{ $invoice->total() }}</td>
                                        <td>
                                            <a href="{{ route('admin.subscriptions.download_invoice', ['invoice' => $invoice->id]) }}"
                                                class="btn btn-primary">
                                                @lang('labels.backend.subscription.download')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4"> <h4> You have not subscribe any plan</h4></td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
