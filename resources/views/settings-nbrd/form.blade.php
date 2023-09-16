<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('company_name') }}
            {{ Form::text('company_name', $settingsNbrd->company_name, ['class' => 'form-control' . ($errors->has('company_name') ? ' is-invalid' : ''), 'placeholder' => 'Company Name']) }}
            {!! $errors->first('company_name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('company_name_short') }}
            {{ Form::text('company_name_short', $settingsNbrd->company_name_short, ['class' => 'form-control' . ($errors->has('company_name_short') ? ' is-invalid' : ''), 'placeholder' => 'Company Name Short']) }}
            {!! $errors->first('company_name_short', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('billing_rate_per_cubic_m') }}
            {{ Form::text('billing_rate_per_cubic_m', $settingsNbrd->billing_rate_per_cubic_m, ['class' => 'form-control' . ($errors->has('billing_rate_per_cubic_m') ? ' is-invalid' : ''), 'placeholder' => 'Billing Rate Per Cubic M']) }}
            {!! $errors->first('billing_rate_per_cubic_m', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('discount_rate') }}
            {{ Form::text('discount_rate', $settingsNbrd->discount_rate, ['class' => 'form-control' . ($errors->has('discount_rate') ? ' is-invalid' : ''), 'placeholder' => 'Discount Rate']) }}
            {!! $errors->first('discount_rate', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('reconnection_fee') }}
            {{ Form::text('reconnection_fee', $settingsNbrd->reconnection_fee, ['class' => 'form-control' . ($errors->has('reconnection_fee') ? ' is-invalid' : ''), 'placeholder' => 'Reconnection Fee']) }}
            {!! $errors->first('reconnection_fee', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('bank_name') }}
            {{ Form::text('bank_name', $settingsNbrd->bank_name, ['class' => 'form-control' . ($errors->has('bank_name') ? ' is-invalid' : ''), 'placeholder' => 'Bank Name']) }}
            {!! $errors->first('bank_name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('branch') }}
            {{ Form::text('branch', $settingsNbrd->branch, ['class' => 'form-control' . ($errors->has('branch') ? ' is-invalid' : ''), 'placeholder' => 'Branch']) }}
            {!! $errors->first('branch', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('account_number') }}
            {{ Form::text('account_number', $settingsNbrd->account_number, ['class' => 'form-control' . ($errors->has('account_number') ? ' is-invalid' : ''), 'placeholder' => 'Account Number']) }}
            {!! $errors->first('account_number', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>