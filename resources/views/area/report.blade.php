@extends('layouts.admin')

@section('template_title')
Area
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive ">
                        <div class="col-md-12">
                            <div class="col-6">
                                <div class="col-md-6">
                                    <input type="text" id="dateChange" value="{{$period}}" class="form-control" placeholder="Select Date..."/>
                                </div>
                                <div class="col-md-3">
                                    <input type="button" id="MoveToData" class="btn btn-sm btn-primary" value="Submit"/>
                                </div>
                            </div>

                        </div>
                        <table class="table table-striped table-hover areas">
                            <thead class="thead">
                                <tr>             
                                    <th colspan="6"><center><b>FINANCIAL WATER</b></center></th>                                   
                            </tr>
                            <tr>             
                                <th colspan="6"><center><b>CONSUMPTION SUMMARY BY AREAS OF {{$period1}}</b></center></th>                                   
                            </tr>
                            <tr>
                                <th>Area Code</th>
                                <th>Service Area</th>
                                <th><center>Client Count</center></th>
                            <th><center>Units Consumed</center></th>
                            <th><center>Flat Rated Customer Count</center></th>
                            <th><center>Invoiced Amount(KSh.)</center></th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(count($result) > 0)
                                @foreach($result as $r)
                                <tr>
                                    <td>{{$r->id}}</td>
                                    <td>{{$r->name}}</td>
                                    <td class=""><center>{{number_format($r->clients,0)}}</center></td>
                            <td class=""><center>{{number_format($r->units_consumed,0)}}</center></td>
                            <td class=""><center>{{number_format($r->flat_rate,0)}}</center></td>
                            <td class="text-right">{{number_format($r->invoiced,2)}}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6"><center><span class="alert alert-warning">No data found for this period!</span></center></td>                             
                            </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#dateChange").datepicker({dateFormat: 'yy-mm-dd'});

        $('#MoveToData').click(function () {
            window.location.href = "{{url('areas/report/')}}/" + $('#dateChange').val();
        })

    })
</script>

@endsection

