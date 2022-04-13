@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30 mb-2">
    <div class="col-xl-6 col-md-6 mb-30">
        <div class="card b-radius--10 overflow-hidden box--shadow1">
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        @lang('Registration Date')
                        <span class="font-weight-bold">{{ showDateTime(@$service->created_at, 'd/m/Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        @lang('Service')
                        <span class="font-weight-bold">
                            <a href="{{ route('admin.product.update.page', $service->product_id) }}">{{ __(@$service->product->name) }}</a>
                        </span> 
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        @lang('Service Category')
                        <span class="font-weight-bold">
                            {{ __(@$service->product->serviceCategory->name) }}
                        </span> 
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        @lang('Server')
                        <span class="font-weight-bold">{{ __(@$service->server->name) ?? __('N/A') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        @lang('Domain')  
                        <span class="font-weight-bold">{{ __(@$service->domain) ?? __('N/A') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        @lang('Status')
                        <span class="font-weight-bold">@php echo @$service->showDomainStatus; @endphp</span>
                    </li>
                </ul> 
            </div>
        </div> 
    </div>  
    <div class="col-xl-6 col-md-6 mb-30">
        <div class="card b-radius--10 overflow-hidden box--shadow1">
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        @lang('First Payment Amount')
                        <span class="font-weight-bold">{{ $general->cur_sym }}{{ showAmount(@$service->first_payment_amount) }}</span>
                    </li> 
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        @lang('Recurring Amount')
                        @if($service->billing == 1)
                            <span class="font-weight-bold">{{ $general->cur_sym }}{{ showAmount(0) }}</span>
                        @else 
                            <span class="font-weight-bold">{{ $general->cur_sym }}{{ showAmount(@$service->amount) }}</span>
                        @endif 
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        @lang('Next Due Date')
                        <span class="font-weight-bold">{{ showDateTime(@$service->next_due_date, 'd/m/Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        @lang('Billing Cycle')  
                        @if($service->billing == 1)
                            <span class="font-weight-bold">@lang('One Time')</span>
                        @else 
                            <span class="font-weight-bold">{{ billing(@$service->billing_cycle, true)['showText'] }}</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        @lang('Payment Method')
                        <span class="font-weight-bold">
                            @if(@$service->deposit_id)
                                <a href="{{ route('admin.deposit.detail', $service->deposit_id) }}">{{ __(@$service->deposit->gateway->name) }}</a>
                            @else 
                                @lang('Wallet Balance')
                            @endif
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        @lang('Discount')
                        <span class="font-weight-bold">{{ $general->cur_sym }}{{ showAmount(@$service->discount) }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @if(count($service->hostingConfigs))
        @foreach($service->hostingConfigs as $config)
            <div class="col-xl-3 col-md-6 mb-30">
                <div class="card b-radius--10 overflow-hidden">
                    <div class="card-body">
                        <span class="font-weight-bold">{{ __($config->select->name) }}</span>
                        <p>{{ __($config->option->name) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.service.update') }}" method="POST">
                    <input type="hidden" name="id" value="{{ $service->id }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label font-weight-bold"> @lang('Domain') </label>
                                <input class="form-control form-control-lg" type="text" name="domain" value="{{$service->domain}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Dedicated IP')</label>
                                <input class="form-control form-control-lg" type="text" name="dedicated_ip" value="{{$service->dedicated_ip}}">
                            </div> 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"> 
                                <label class="form-control-label font-weight-bold">@lang('Username')</label>
                                <input class="form-control form-control-lg" type="text" name="username" value="{{$service->username}}">
                            </div>
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Password')</label>
                                <input class="form-control form-control-lg" type="text" name="password" value="{{$service->password}}">
                            </div>
                        </div>
                        <div class="col-md-4">   
                            <div class="form-group"> 
                                <label class="form-control-label font-weight-bold">@lang('Status')</label>
                                <select name="domain_status" class="form-control form-control-lg"> 
                                    @foreach($service::domainStatus() as $index => $data) 
                                        <option value="{{ $index }}" {{ $service->domain_status == $index ? 'selected' : null}}>{{ $data }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins') 
<a href="{{ route('admin.order.details', $service->order_id) }}" class="btn btn-sm btn--primary box--shadow1 text-white text--small">
    <i class="fa fa-fw fa-backward"></i>@lang('Go Back')
</a>
@endpush 

@push('style')
    <style>
        
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
           
        })(jQuery);
        
    </script>
@endpush

