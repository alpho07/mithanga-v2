<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('billing_period') }}
            {{ Form::text('billing_period', $settingsDpm->billing_period, ['class' => 'form-control' . ($errors->has('billing_period') ? ' is-invalid' : ''), 'placeholder' => 'Billing Period']) }}
            {!! $errors->first('billing_period', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('due_days') }}
            {{ Form::text('due_days', $settingsDpm->due_days, ['class' => 'form-control' . ($errors->has('due_days') ? ' is-invalid' : ''), 'placeholder' => 'Due Days']) }}
            {!! $errors->first('due_days', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('first_billing_message') }}
            {{ Form::text('first_billing_message', $settingsDpm->first_billing_message, ['class' => 'form-control' . ($errors->has('first_billing_message') ? ' is-invalid' : ''), 'placeholder' => 'First Billing Message']) }}
            {!! $errors->first('first_billing_message', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('second_billing_message') }}
            {{ Form::text('second_billing_message', $settingsDpm->second_billing_message, ['class' => 'form-control' . ($errors->has('second_billing_message') ? ' is-invalid' : ''), 'placeholder' => 'Second Billing Message']) }}
            {!! $errors->first('second_billing_message', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('third_billing_message') }}
            {{ Form::text('third_billing_message', $settingsDpm->third_billing_message, ['class' => 'form-control' . ($errors->has('third_billing_message') ? ' is-invalid' : ''), 'placeholder' => 'Third Billing Message']) }}
            {!! $errors->first('third_billing_message', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('receipt_message') }}
            {{ Form::text('receipt_message', $settingsDpm->receipt_message, ['class' => 'form-control' . ($errors->has('receipt_message') ? ' is-invalid' : ''), 'placeholder' => 'Receipt Message']) }}
            {!! $errors->first('receipt_message', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>