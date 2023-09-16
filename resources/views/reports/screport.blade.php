@extends('layouts.admin')

@section('template_title')
Area
@endsection


@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <div class="card-body">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

                            <form method="get" action="{{route('area.report')}}">
                                <table>
                                    <tr>
                                        <td>
                                            <select class="form-control" name="type" style="width:200px !important;" id="AREA">
                                                <option value="AREA">SUMMARY</option>
                                                <option value="CLIENTS">DETAILED</option>
                                            </select> 
                                        </td>
                                        <td>
                                            <input type="text" id="dateChange" name="period" value="{{$period}}" class="form-control" placeholder="Select Date..."/>
                                        </td>
                                        <td>
                                            <input type="submit" id="MoveToData" class="btn btn-sm btn-primary" value="Submit"/>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </nav>
                </div>
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            @foreach($data as $d)
            <div class="card">

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive ">

                        <table class="table table-bordered table-hover areas">
                            <thead class="thead">
                                <tr>             
                                    <th colspan="6"><center><b>FINANCAL WATER | AREA {{$d['area']}}</b></center></th>                                   
                            </tr>
                            <tr>             
                                <th colspan="6"><center><b>CONSUMPTION DETAILS BY AREA FOR {{$period1}}</b></center></th>                                   
                            </tr>
                            <tr>
                                <th>Account</th>
                                <th>Client Name</th>
                                <th><center>Units Consumed</center></th>
                            <th><center>Flat Rated Customer Count</center></th>
                            <th><center>Invoiced Amount(KSh.)</center></th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(count($d['clients']) > 0)
                                @foreach($d['clients'] as $r)
                                <tr>
                                    <td>{{$r->account}}</td>
                                    <td>{{$r->account_name}}</td>
                                    <td class=""><center>{{($r->units > 0) ? $r->units : ''}}</center></td>
                                    <td class=""><center>{{($r->units > 0) ? '' :$r->units }}</center></td>
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
            @endforeach
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#AREA').val("{{$type}}").trigger('change');
    });
</script>
@endsection

