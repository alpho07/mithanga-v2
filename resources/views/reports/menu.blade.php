<div class="card">

    <div class="card-body">
        @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p><strong><i>{{ $message }}</i></strong></p>
        </div>
        @endif
        <form method="get" action="">
            <table class="table">
                <tbody>
                    <tr>
                        <td><input type="radio" class="radio" value="detail" name="report_type" @if(@$report_type=='detail') {{'checked'}} @endif "/> Detail</td>
                        <td><input type="radio" class="radio" value="summary" name="report_type" @if(@$report_type=='summary') {{'checked'}} @endif "/> Summary</td>
                        <td><input type="radio" class="radio" value="receipt" name="report_type" @if(@$report_type=='receipt') {{'checked'}} @endif "/> Receipt</td>
                        <td><input type="radio" class="radio" value="votehead" name="report_type" @if(@$report_type=='votehead') {{'checked'}} @endif "/> Votehead</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <input id="receiptno" name="receiptno" type="number" value="{{@$vh}}" placeholder="Receipt No." class="form-control" {{@$vd}} "/>
                        </td>
                        <td>
                            <div id="VH" {{@$vs}}>
                                <select id="votehead" class="form-control" name="voteheadselection" >
                                    <option value="APPLICATION FEE">APPLICATION FEE</option>
                                    <option value="ADVANCE PAY">ADVANCE PAY</option>
                                    <option value="ARREARS">ARREARS</option>
                                    <option value="RECONNECTION FEES">RECONNECTION FEE</option>
                                    <option value="WATER CHARGES">WATER CHARGES</option>
                                </select>
                            </div>
                        </td>
                    <tr>
                        <td>
                            <select id="DateSel" class="form-control" name="datecriteria">
                                <option value="datesingle">DATE</option>
                                <option value="date_range">DATE RANGE</option>                                             
                            </select> 
                        </td>
                        <td><input type="text" id="d1"  class="form-control datepicker" {{@$ds}} value="{{$date ?? date('Y-m-d')}}" name="date" placeholder="Select Date"></td>
                        <td><input type="text" id=""  class="form-control datepicker d2" {{@$dr}}  value="{{$datefrom ?? date('Y-m-01')}}"name="datefrom" placeholder="Select From Date"></td>
                        <td><input type="text"  class="form-control datepicker d2" {{@$dr}} value="{{$dateto ?? date('Y-m-t')}}" name="dateto" placeholder="Select To Date"></td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Submit" class="btn btn-sm btn-warning"/></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </form>

    </div>
</div> 
<script>
    $(function () {
        $('#DateSel').val("{{@$dc}}").trigger('change');
        $('#votehead').val("{{@$vhs}}").trigger('change');
    })
</script>