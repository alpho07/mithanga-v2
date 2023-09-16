<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('center') }}
            {{ Form::text('center', $legalCenter->center, ['class' => 'form-control' . ($errors->has('center') ? ' is-invalid' : ''), 'placeholder' => 'Center']) }}
            {!! $errors->first('center', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('amount') }}
            {{ Form::text('amount', $legalCenter->amount, ['class' => 'form-control' . ($errors->has('amount') ? ' is-invalid' : ''), 'placeholder' => 'Amount']) }}
            {!! $errors->first('amount', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>