

@csrf
<input type="hidden" value="{{date('YmdHis')}}" name="reference"/>
<div class="form-group">
    {{ Form::label('Occurence Date') }}
    {{ Form::text('date', date('Y-m-d H:i:s'), ['class' => 'form-control datepicker' . ($errors->has('date') ? ' is-invalid' : ''), 'placeholder' => 'Occurence Date','required'=>'required']) }}
    {!! $errors->first('date', '<div class="invalid-feedback">:message</p>') !!}
    </div>

    <div class="form-group {{ $errors->has('client_id') ? 'has-error' : '' }}">
        <label for="expense_category">Client Account Number & Name</label>
        <select name="client_id" id="client_id" class="form-control select2" required>
            <option value="">-Select Client-</option>
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
    <div class="form-group {{ $errors->has('mop') ? 'has-error' : '' }}">
        <label for="legal">Legal Center</label>
        <select name="legal" id="legal" class="form-control" required="required">
            <option value=""></option>
            @foreach($legal as $id => $m)
            <option value="{{ $m->id }}" data-amount="{{$m->amount}}">{{$m->center  }}</option>
            @endforeach
        </select>
        <input id="mount" type="hidden" name="amount"/>
        <input id="description" type="hidden" name="description"/>
        @if($errors->has('legal'))
        <em class="invalid-feedback">
            {{ $errors->first('legal') }}
        </em>
        @endif
    </div>

    <div class="form-group" >
        <label>Legal Commentary</label>
        <textarea id="legal_remarks" name="legal_remarks" class="form-control" placeholder="Legal Commentary"></textarea>
        {!! $errors->first('type', '<div class="invalid-feedback">:message</p>') !!}
        </div>


    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>



<script>
    $(function () {
        $('.CHEQUE').hide()
        $('#mop_id').change(function () {
            val = $(this).val();
            if (val == '3') {
                $('.CHEQUE').show()
                $('#cheque_number').prop('required', 'required');
            } else {
                $('.CHEQUE').hide()
                $('#cheque_number').prop('required', false);
            }
        })

        $('#legal').click(function () {
            val = $('#legal option:selected').attr('data-amount');
            name = $('#legal option:selected').text();
            $('#mount').val(val);
            $('#description').val(name);

        })
    });
</script>
