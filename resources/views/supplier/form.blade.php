<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('name') }}
            {{ Form::text('name', $supplier->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('contactPerson') }}
            {{ Form::text('contactPerson', $supplier->contactPerson, ['class' => 'form-control' . ($errors->has('contactPerson') ? ' is-invalid' : ''), 'placeholder' => 'Contactperson']) }}
            {!! $errors->first('contactPerson', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('phone') }}
            {{ Form::text('phone', $supplier->phone, ['class' => 'form-control' . ($errors->has('phone') ? ' is-invalid' : ''), 'placeholder' => 'Phone']) }}
            {!! $errors->first('phone', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>