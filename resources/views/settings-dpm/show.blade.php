@extends('layouts.admin')

@section('template_title')
    {{ $settingsDpm->name ?? 'Show Settings Dpm' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Settings Dpm</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('settings_dpm.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Billing Period:</strong>
                            {{ $settingsDpm->billing_period }}
                        </div>
                        <div class="form-group">
                            <strong>Due Days:</strong>
                            {{ $settingsDpm->due_days }}
                        </div>
                        <div class="form-group">
                            <strong>First Billing Message:</strong>
                            {{ $settingsDpm->first_billing_message }}
                        </div>
                        <div class="form-group">
                            <strong>Second Billing Message:</strong>
                            {{ $settingsDpm->second_billing_message }}
                        </div>
                        <div class="form-group">
                            <strong>Third Billing Message:</strong>
                            {{ $settingsDpm->third_billing_message }}
                        </div>
                        <div class="form-group">
                            <strong>Receipt Message:</strong>
                            {{ $settingsDpm->receipt_message }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
