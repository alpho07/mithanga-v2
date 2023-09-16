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

                            <form method="get" action="{{route('meter.history')}}">
                                <table>
                                    <tr>
                                        <td>
                                        <td>
                                            <select class="form-control" name="type" style="width:300px !important;" id="AREA">                                                
                                                <option value="">-Select Client-</option>
                                                @foreach($clients as $c)
                                                <option value="{{$c->id}}">{{$c->account_name}}</option>
                                                @endforeach;

                                            </select> 
                                        </td>
                                        </td>
                                        <td>
                                            <input type="text" id="dateChange" name="period" value="{{$period}}" class="form-control datepicker" placeholder="Select Date..."/>
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
                                    <th colspan="6"><center><b>FINANCAL WATER</b></center></th>                                   
                            </tr>
                            <tr>             
                                <th colspan="6"><center><b>METER READING HISTORY FOR {{$single->account_name. ' - '. @$result[0]->area_name}}</b></center></th>                                   
                            </tr>
                            <tr>
                                <th>Period</th>
                                <th><center>Units Read</center></th>

                            </tr>
                            </thead>
                            <tbody>
                                @if(count($result) > 0)
                                @foreach($result as $r)
                                <tr>
                                    <td>{{\Carbon\Carbon::parse($r->reading_date)->format('M-Y')}}</td>
                                    <td><center>{{$r->current_reading}}</center></td>

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
    $(function () {
        $('#AREA').select2();
        $('#AREA').val("{{$type}}").trigger('change');
    });
</script>
@endsection

