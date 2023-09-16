@extends('layouts.admin')

@section('template_title')
    {{ $settingsNbrd->name ?? 'Show Settings Nbrd' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Settings Nbrd</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('settings_nbrd.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Company Name:</strong>
                            {{ $settingsNbrd->company_name }}
                        </div>
                        <div class="form-group">
                            <strong>Company Name Short:</strong>
                            {{ $settingsNbrd->company_name_short }}
                        </div>
                        <div class="form-group">
                            <strong>Billing Rate Per Cubic M:</strong>
                            {{ $settingsNbrd->billing_rate_per_cubic_m }}
                        </div>
                        <div class="form-group">
                            <strong>Discount Rate:</strong>
                            {{ $settingsNbrd->discount_rate }}
                        </div>
                        <div class="form-group">
                            <strong>Reconnection Fee:</strong>
                            {{ $settingsNbrd->reconnection_fee }}
                        </div>
                        <div class="form-group">
                            <strong>Bank Name:</strong>
                            {{ $settingsNbrd->bank_name }}
                        </div>
                        <div class="form-group">
                            <strong>Branch:</strong>
                            {{ $settingsNbrd->branch }}
                        </div>
                        <div class="form-group">
                            <strong>Account Number:</strong>
                            {{ $settingsNbrd->account_number }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
