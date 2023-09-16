<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('name') }}
            {{ Form::text('name', $branch->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
            </div>
            <div class="form-group">               
                {{ Form::hidden('bank_id', $bank, ['class' => 'form-control' . ($errors->has('bank_id') ? ' is-invalid' : ''), 'placeholder' => 'Bank Id']) }}
                {!! $errors->first('bank_id', '<div class="invalid-feedback">:message</p>') !!}
                </div>

            </div>
            <div class="box-footer mt20">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>