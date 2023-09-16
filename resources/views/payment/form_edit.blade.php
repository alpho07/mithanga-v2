<div class="box box-info padding-1">
    <div class="box-body">
        <input type="hidden" value="{{date('YmdHis')}}" name="reference"/>

        <div class="form-group {{ $errors->has('supplier') ? 'has-error' : '' }}">
            <label for="supplier">Supplier</label>
            <select name="supplier" id="" class="form-control select2" required>
                <option value="{{$invoice[0]->supplier}}">{{$invoice[0]->suppliers}}</option>
                @foreach($suppliers as $id => $c)
                <option value="{{ $c->id }}">{{$c->name}}</option>
                @endforeach
            </select>

        </div>
        <div class="form-group {{ $errors->has('supplier') ? 'has-error' : '' }}">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>Cost Center</td>
                        <td>Amount</td>
                        <td>
                            <a href="#add" id="PRIME" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add</a>
                        </td>
                    </tr>
                </thead>
                <tbody id="PRIMEBODY">
                    @foreach($details as $detail)
                    <tr id="PRIMARY">
                        <td>
                            <select name="cost_center[]" id="cost_center" class="cost_center" class="form-control" required selected="selected">
                                <option value="{{$detail->item}}">{{$detail->center}}</option>
                                @foreach($cost_center as $id => $co)
                                <option value="{{ $co->id }}">{{$co->center  }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="amount_invoiced[]" required placeholder="Amount Invoiced" value="{{$detail->amount}}" class="form-control"/>

                        </td>
                        <td>
                            <a href="#remove" class="REMOVE btn btn-danger btn-sm"><i class="fa fa-minus"></i> Remove</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>         


        </div>

        <input type="hidden" name="staff" value="{{strtoupper(Auth::user()->name)}}"/>

        <div class="form-group">
            <label for="refeence">Reference</label>
            <input type="text" name="reference" readonly="" class="form-control" value="{{$ref}}"/>
        </div>

        <div class="form-group" >
            <label for="remarks">Comments/Remarks</label>
            <textarea name="remarks" required placeholder="Remarks" class="form-control">{{$invoice[0]->remarks}}</textarea>
        </div>


    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>


<script>
    $(function () {
        $('#PRIME').click(function () {
            body = $('#PRIMARY').html();
            $('#PRIMEBODY').append('<tr>' + body + '</tr>');


        });

        $(document).on('click', '.REMOVE', function () {
            $(this).closest('tr').remove();
        })



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
    });
</script>
