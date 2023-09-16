<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group {{ $errors->has('client_id') ? 'has-error' : '' }}">
            <label for="expense_category">Client</label>
            <select name="client_id" id="client_id" class="form-control select2" required="">
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
        <div class="form-group">
            <input type="text" value="<?php echo date('Y-m-d');?>" class="form-control datepicker" readonly id="DateS" name='change_date' placeholder="Select Change Date..."/>
        </div>
        <div class="form-group">
            <label><strong><u>Previous reading before change:</u></strong></label>
            <span class="badge badge-info" id="PREREADING" style="font-weight: bold; color: blue;font-size: 18px;"></span>
            <br>
            <p></p>
<!--            <input class="form-control" name="prevreading" type="text" id="PREREADINGA" placeholder="Adjusted previous reading"  />-->
        </div>
        <div class="form-group">
            
            <input type="number"  class="form-control" id="NewPReading" required="" name="reading" placeholder="New Reading"/>
        </div>


    </div>
    <div class="box-footer mt20">
        <button id="suMit" type="submit" class="btn btn-primary">Submit</button>
    </div>

</div>
