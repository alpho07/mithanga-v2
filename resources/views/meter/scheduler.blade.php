@extends('layouts.admin')

@section('template_title')
Meter Reading
@endsection

@section('content')
<style>
    .number{text-align: right;}

</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            <strong>NOTIFICATION MESSAGING SCHEDULER</strong>
                        </span>

                        <div class="float-right">

                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card-body">
                    <div class="row col-md-12">
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-3">
                            <form action="{{ url('schedule-cns') }}" method="POST">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>Date</label>
                                        <input type="text" class="form-control monthPicker" value="{{date('d-m-Y', strtotime(date('d-m-Y') . ' + 1 day'))}}" required id="selection_date"  name="selection_date" >

                                    </div>
                                    <div class="col-md-4">
                                        <label>Area</label>
                                        <select class="form-control" id="area_id_id" name="area" required style="">
                                            <option value="All">-All-</option>
                                            @foreach($area as $a)
                                            <option value="{{$a->id}}">{{$a->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>-</label>
                                        <button type="submit" class="btn btn-danger btn-sm SCHEDULER11"><i class="fa fa-fw fa-arrow-circle-right"></i> Schedule </button> 
                                    </div>
                                </div>
                                @csrf
                                @method('POST')

                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover legal">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Water Service Area</th>
                                    <th>Account No.</th>
                                    <th>Account Name</th>
                                    <th>Phone Number</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Units</th>                                   
                                    <th>Status</th>
                                    <th>Message</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($readings  as $r)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $r->c_area }}</td>
                                    <td>{{ $r->client_id }}</td>
                                    <td>{{ $r->account_name }}</td>
                                    <td>{{ $r->phone_no }}</td>
                                    <td>{{ $r->date }}</td>
                                    <td style="text-align: right;">{{number_format($r->amount,2)}}</td>
                                    <td class="number">{{ $r->units }}</td>
                                    <td class="number">{{ $r->sstatus }}</td>                                    
                                    <td class="number">{{ $r->smessage }}</td>                                

                                    <td>
                                        @can('update_readings')
                                        <form action="{{ route('legal-centers.destroy',$r->id) }}" method="POST">
<!--                                            <a class="btn btn-sm btn-primary " href="{{ route('legal-centers.show',$r->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>-->
                                            @if($r->sstatus=='pending')
                                            <a class="btn btn-sm btn-warning" href="{{ url('sendNotification',$r->client_id) }}"><i class="fa fa-fw fa-plane"></i> Send Notification</a>
                                            @elseif($r->sstatus=='sent')
                                            <span><i class="fa fa-fw fa-check"></i> Sent</span>
                                            @endif
                                            @csrf
                                            @method('DELETE')
    <!--                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>-->
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title float-left" style="float: left;">Meter Reading</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="{{url('meter_reading')}}">
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="email">Area:</label>
                        <div class="col-sm-12">
                            <select class="form-control" required id='area_sel' name=''>
                                <option value="">-Select Area-</option>
                                @foreach($area as $a)
                                <option value="{{$a->id}}">{{$a->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="pwd">Account</label>
                        <div class="col-sm-12">
                            <select class="form-control" required id='account_' name='client_id'>
                                <option value="">-Select Account-</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-6" for="pwd">Reading Date</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control datepicker" required id="reading_date"  name="reading_date" placeholder="Reading Date" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="pwd">Reading(Units)</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" required id="current_reading"  name="current_reading" placeholder="Reading(Units)" >
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<div id="myModalE" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <strong><span class="modal-title" id="EDITTITLE" style="float:left;">Modal Header</span></strong>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" class="form-control datepicker11" id="id_">
                    <label class="sr-only" for="email">Reading Date</label>
                    <input type="text" class="form-control datepicker11" id="reading_date1">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="pwd">Reading(Units)</label>
                    <input type="text" class="form-control" id="current_reading1">
                </div>
                @can('update_readings')
                <button type="submit" id="UpdateData" class="btn btn-primary">Submit</button>
                @endcan
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

@endsection
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(function () {
    $(".datepicker11").datepicker({dateFormat: 'yy-mm-dd'});
    $('#area_sel').change(function () {
        val = $(this).val();
        $.getJSON("{{url('api/v1/client')}}/" + val, function (resp) {
            $('#account_').empty();
            $('#account_').append('<option value="">-Select Account-</option>');
            $.each(resp, function (i, d) {
                $('#account_').append('<option value="' + d.id + '">' + d.account_name + '</option>');
            })
            //  $('#account_').select2();
        });
    });

    $('.SCHEDULER11111111111111111111111').click(function () {
        window.location.href = "{{url('notification')}}/" + $('#area_id_id').val() + '/' + $('#selection_date').val();

    });

    //$('#area_sel').select2();

    $(document).on('click', '.EDITS', function () {
        id = $(this).attr('data-id');
        account = $(this).attr('data-account');
        account_name = $(this).attr('data-account-name');
        area = $(this).attr('data-area');
        date = $(this).attr('data-date');
        units = $(this).attr('data-units');
        $('#EDITTITLE').text("AREA > " + area + " | ACCOUNT No. > " + account + " | ACC.NAME > " + account_name);
        $('#reading_date1').val(date);
        $('#current_reading1').val(units);
        $('#id_').val(id);
    });

    $('#UpdateData').click(function () {
        data = {
            id_: $('#id_').val(),
            reading_date: $('#reading_date1').val(),
            current_reading: $('#current_reading1').val(),
            _token: "{{csrf_token()}}"
        }
        $.post("{{url('updateReadings')}}/", data, function () {
            window.location.href = ""
        });
    });
})
</script>
