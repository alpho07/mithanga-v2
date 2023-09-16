<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('status') }}
            {{ Form::text('status', $status->status, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => 'Status']) }}
            {!! $errors->first('status', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>