@extends('layouts.admin')

@section('template_title')
Transaction
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card">

                        <div class="card-body">
                            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                                    <form method="get" action="{{route('reading.history')}}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Client:
                                                <select name="client" class="form-control" id="CID">
                                                    <option value="1">1 - IMBUCHE ORINA - MBUKONI</option>
                                                    @foreach($clients as $c)
                                                    <option value="{{$c->id}}">{{$c->id.' - '.$c->account_name. ' - '.$c->area_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                Date:<input type="text" placeholder="Pick Date" value="{{$date}}" class="form-control datepicker" name="date"/> 
                                            </div>
                                            <div class="col-md-2">
                                                &nbsp;
                                                <input type="submit"  class="btn btn-sm btn-primary"/>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </nav>
                        </div>
                    </div> 

                    <div style="">



                        <div class="row pull-right">
                            <button id="PRINT" class="btn btn-sm btn-primary">Print</button>
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif



                <div class="card-body" id="printToPdf">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <strong><b>FIANCIAL WATER - HISTORY OF METER READINGS</b></strong>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <strong><b>Account Number:-{{$client[0]->id}} | Account Name:-{{$client[0]->account_name}}</b></strong>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">           
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <table class="table table-bordered" style="width:1000px !important;">
                                <thead>
                                    <tr>
                                        <th class="tg-7btt">PERIOD</th>
                                        <th class="">METER READING</th>
                                        <th class="tg-7btt">CONSUMPTION</th>                                             
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($balances as $b)
                                    <tr>
                                        <td class="tg-c3ow" style="text-align: left;">{{\Carbon\Carbon::parse($b->reading_date)->format('M-Y')}}</td>
                                        <td class="tg-c3ow">{{$b->current_reading}}<br></td>
                                        <td class="" style="text-align: right;">{{$b->consumed_units }}</td>                                      
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script>
    $(function () {
        $('#CID').val("{{$cid}}").trigger('change');



        function printData()
        {
            $('.pagination').hide();
            $('table th').css('border', '1px solid black')
            $('table th').css('padding', '3px`')
            $('table td').css('border', '1px solid black')
            $('table td').css('padding', '3px')
            $('table').css('border-collapse', 'collapse')
            var divToPrint = document.getElementById("printToPdf");
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }

        $('#PRINT').on('click', function () {
            printData();
        })

    })
</script>
@endsection