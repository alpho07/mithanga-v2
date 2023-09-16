@extends('layouts.admin')
@section('template_title')
Dashboard
@endsection

@section('content')
<script src="{{asset('js/highcharts.js')}}"></script>
<script src="{{asset('js/exporting.js')}}"></script>
<script src="{{asset('js/export-data.js')}}"></script>
<script src="{{asset('js/accessibility.js')}}"></script>
<script src="{{asset('js/financial.js')}}"></script>
<style>
    #container {
        height: 400px; 
    }

    .highcharts-figure, .highcharts-data-table table {
        min-width: 310px; 
        max-width: 800px;
        margin: 1em auto;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }
    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }
    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }
    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
        padding: 0.5em;
    }
    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }
    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">


                <div class="card-body">
                    <div class="table-responsive">
                        <div class="container-fluid">
                            <h1 class="mt-4">Dashboard</h1>

                            <!--div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card border-left-primary shadow  py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">SALES TODAY (<small>{{date('d/m/Y')}}</small>)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">KES. {{number_format($salestoday,2)}}</div> 
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-cash-register fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card border-left-primary shadow  py-2">

                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{date('F-Y')}} TOTAL SALES</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">KES. {{number_format($salesmonthly,2)}}</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card border-left-primary shadow  py-2">

                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Clients</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{number_format($clients->count(),0)}}</div> 
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-users fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card border-left-primary shadow  py-2">

                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Areas</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$areas->count()}}</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-building fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                                                <span class="navbar-toggler-icon"></span>
                                            </button>
                                            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                                                <a class="navbar-brand" href="{{url('client')}}"><i class="fa fa-users"></i> Filter | </a>
                                                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

                                                    <li class="nav-item ">
                                                        <select class="form-control" id="YEAR">
                                                            <option>-Select Year</option>
                                                            <option value="2023">2023</option>
                                                            {{-- <option value="2021">2021</option>                                                            --}}
                                                        </select>
                                                    </li>
                                                    <li class="nav-item ">
                                                        <select class="form-control" id="MONTH">
                                                            <option>-Select Month</option>
                                                            <option value="Jan">Jan</option>
                                                            <option value="Feb">Feb</option>
                                                            <option value="Mar">Mar</option>
                                                            <option value="Apr">Apr</option>
                                                            <option value="May">May</option>
                                                            <option value="Jun">Jun</option>
                                                            <option value="Jul">Jul</option>
                                                            <option value="Aug">Aug</option>
                                                            <option value="Sep">Sep</option>
                                                            <option value="Oct">Oct</option>
                                                            <option value="Nov">Nov</option>
                                                            <option value="Dec">Dec</option>
                                                        </select>
                                                    </li>
                                                    <li class="nav-item ">
                                                        <button class="btn btn-sm btn-primary IDDD">Filter</button>
                                                    </li>


                                                </ul>

                                            </div>
                                        </nav>
                                    </div>
                                </div>

                            </div-->

                            <div class="row mt-3">
                                <div class="col-xl-6">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-chart-area mr-1"></i>
                                            Consumption Report By Month
                                        </div>
                                        <div class="card-body">
                                            <figure class="highcharts-figure">
                                                <div id="containerCR">
                                                    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </div>

                                            </figure>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-chart-bar mr-1"></i>
                                            Total Consumption By Area
                                        </div>
                                        <div class="card-body">
                                            <figure class="highcharts-figure">
                                                <div id="containerAREA">
                                                    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </div>

                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table mr-1"></i>
                                    Income Sources
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Amount</th>                                                   
                                                </tr>
                                            </thead>

                                            <tbody id="INCOMETABLE">
                                                <tr>
                                                    <td> <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div></td>
                                                    <td> <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div></td>                                                
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
$(function () {
    chartdata = '';
    $.getJSON("{{route('dashboard.allconsumption')}}", function (resp) {
        // console.log(resp);
        financial('containerCR', 'column', 'No. of Units Consumed', source = 'Water Consumption CM3', 'Fiancial Water Services', false, -45, 'Period', 'Period', resp.period, resp.consumed);
    });
    $.getJSON("{{route('dashboard.areaconsumption')}}", function (resp) {
        // console.log(resp);
        financial('containerAREA', 'column', 'No. of Units Consumed', source = 'Area Consumption CM3', 'Financial Water Services', false, -45, 'Period', 'Area', resp.period, resp.consumed);
    });
    $.getJSON("{{route('dashboard.income')}}", function (resp) {
        $('#INCOMETABLE').empty();
        $.each(resp, function (i, d) {
            tr = '<tr><td>' + d.category + '</td><td>' + d.amount + '</td></tr>';
            $('#INCOMETABLE').append(tr);
        });
    });


    $('.IDDD').click(function () {
        year = $('#YEAR').val();
        month = $('#MONTH').val();

        $('#INCOMETABLE').empty();
        $('#containerCR').empty();
        $('#containerAREA').empty();

        $.getJSON("{{url('dashboard/all-consumption')}}", function (resp) {
            // console.log(resp);
            financial('containerCR', 'column', 'No. of Units Consumed', source = 'Water Consumption CM3', 'Financial Water Services', false, -45, 'Period', 'Period', resp.period, resp.consumed);
        });
        $.getJSON("{{url('dashboard/area-consumption_')}}" + '/' + month + '/' + year, function (resp) {
            // console.log(resp);
            financial('containerAREA', 'column', 'No. of Units Consumed', source = 'Area Consumption CM3', 'Financial Water Services', false, -45, 'Period', 'Area', resp.period, resp.consumed);
        });
        $.getJSON("{{url('dashboard/all-income_')}}" + '/' + month + '/' + year, function (resp) {
            $('#INCOMETABLE').empty();
            $.each(resp, function (i, d) {
                tr = '<tr><td>' + d.category + '</td><td>' + d.amount + '</td></tr>';
                $('#INCOMETABLE').append(tr);
            });
        });

    })
});



</script>
@endsection
