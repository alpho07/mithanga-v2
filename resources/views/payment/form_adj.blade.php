<div class="box box-info padding-1">
    <div class="box-body">
        <input type="hidden" value="{{date('YmdHis')}}" name="reference"/>

        <div class="form-group {{ $errors->has('client_id') ? 'has-error' : '' }}">
            <label for="expense_category">Client</label>
            <select name="client_id" id="client_id" class="form-control select2" required>
                <option value="">-Select CLient-</option>
                @foreach($clients as $id => $client)
                <option value="{{ $client->id }}">{{'ACCOUNT No. '.$client->id. ' | '.$client->account_name.' | '.$client->area_name  }}</option>
                @endforeach
            </select>
            @if($errors->has('expense_category_id'))
            <em class="invalid-feedback">
                {{ $errors->first('client_id') }}
            </em>
            @endif
        </div>
        <div class="form-group {{ $errors->has('adjustment_type') ? 'has-error' : '' }}">
            <label for="adjustment_type">Adjustment Type</label>
            <select name="adjustment_type" id="adjustment_type" class="form-control select2" required>

                <option value="">-Select-</option>
                <option value="debit">DEBIT - INCREASE BALANCE</option>
                <option value="credit">CREDIT - REDUCE BALANCE </option>

            </select>
            @if($errors->has('adjustment_type'))
            <em class="invalid-feedback">
                {{ $errors->first('adjustment_type') }}
            </em>
            @endif
        </div>

        <input type="hidden" name="staff" value="{{strtoupper(Auth::user()->name)}}"/>
        <div class="form-group">
            <input type="text" name="comment" class="form-control" placeholder="Comment" requied/>

        </div>
        <div class="form-group">
            {{ Form::label('date') }}
            {{ Form::text('date', date('Y-m-d H:i:s'), ['class' => 'form-control' . ($errors->has('date') ? ' is-invalid' : ''), 'placeholder' => 'Date','required'=>'required']) }}
            {!! $errors->first('date', '<div class="invalid-feedback">:message</p>') !!}
            </div>
            <div class="form-group"  style="display:none;">
                {{ Form::label('type') }}
                {{ Form::text('type', 'credit', ['class' => 'form-control' . ($errors->has('type') ? ' is-invalid' : ''), 'placeholder' => 'Type']) }}
                {!! $errors->first('type', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="form-group" style="display:none;">
                    {{ Form::label('Amount Received') }}
                    {{ Form::text('amount_received', $transaction->units, ['class' => 'form-control' . ($errors->has('amount_received') ? ' is-invalid' : ''), 'placeholder' => 'Amount Received']) }}
                    {!! $errors->first('amount_received', '<div class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('Amount Adjusted') }}
                        {{ Form::text('amount', $transaction->amount, ['class' => 'form-control' . ($errors->has('amount') ? ' is-invalid' : ''), 'placeholder' => 'Amount','required'=>'required']) }}
                        {!! $errors->first('amount', '<div class="invalid-feedback">:message</p>') !!}
                        </div>
                        <div class="form-group" style="display:none;">
                            {{ Form::label('units') }}
                            {{ Form::text('units', $transaction->units, ['class' => 'form-control' . ($errors->has('units') ? ' is-invalid' : ''), 'placeholder' => 'Units']) }}
                            {!! $errors->first('units', '<div class="invalid-feedback">:message</p>') !!}
                            </div>

                        </div>
                        <div class="box-footer mt20">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
