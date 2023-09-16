@extends('layouts.admin')
@section('template_title')
    Dashboard
@endsection

@section('content')
    <script src="{{ asset('js/highcharts.js') }}"></script>
    <script src="{{ asset('js/exporting.js') }}"></script>
    <script src="{{ asset('js/export-data.js') }}"></script>
    <script src="{{ asset('js/accessibility.js') }}"></script>
    <script src="{{ asset('js/financial.js') }}"></script>
    <style>
        #container {
            height: 400px;
        }

        .highcharts-figure,
        .highcharts-data-table table {
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

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
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
                                <h1 class="mt-1">Monthly Revenue</h1>



                                <div class="card mb-1">
                                    <div class="card-header">
                                        <i class="fas fa-table mr-1"></i>
                                        Income
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="INCOMETABLE">
                                                    <tr>
                                                        <td>
                                                            <div class="spinner-border" style="width: 3rem; height: 3rem;"
                                                                role="status">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="spinner-border" style="width: 3rem; height: 3rem;"
                                                                role="status">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            chartdata = '';
            $.getJSON("{{ route('dashboard.allconsumption') }}", function(resp) {
                // console.log(resp);
                financial('containerCR', 'column', 'No. of Units Consumed', source =
                    'Water Consumption CM3', 'Fiancial Water Services', false, -45, 'Period', 'Period',
                    resp.period, resp.consumed);
            });
            $.getJSON("{{ route('dashboard.areaconsumption') }}", function(resp) {
                // console.log(resp);
                financial('containerAREA', 'column', 'No. of Units Consumed', source =
                    'Area Consumption CM3', 'Financial Water Services', false, -45, 'Period', 'Area',
                    resp.period, resp.consumed);
            });
            $.getJSON("{{ route('dashboard.income') }}{{$q}}", function(resp) {
                $('#INCOMETABLE').empty();
                $.each(resp, function(i, d) {
                    tr = '<tr><td>' + d.category + '</td><td>' + d.amount + '</td></tr>';
                    $('#INCOMETABLE').append(tr);
                });
            });


            $('.IDDD').click(function() {
                year = $('#YEAR').val();
                month = $('#MONTH').val();

                $('#INCOMETABLE').empty();
                $('#containerCR').empty();
                $('#containerAREA').empty();

                $.getJSON("{{ url('dashboard/all-consumption') }}", function(resp) {
                    // console.log(resp);
                    financial('containerCR', 'column', 'No. of Units Consumed', source =
                        'Water Consumption CM3', 'Financial Water Services', false, -45,
                        'Period', 'Period', resp.period, resp.consumed);
                });
                $.getJSON("{{ url('dashboard/area-consumption_') }}" + '/' + month + '/' + year, function(
                    resp) {
                    // console.log(resp);
                    financial('containerAREA', 'column', 'No. of Units Consumed', source =
                        'Area Consumption CM3', 'Financial Water Services', false, -45,
                        'Period', 'Area', resp.period, resp.consumed);
                });
                $.getJSON("{{ url('dashboard/all-income_') }}" + '/' + month + '/' + year, function(resp) {
                    $('#INCOMETABLE').empty();
                    $.each(resp, function(i, d) {
                        tr = '<tr><td>' + d.category + '</td><td>' + d.amount +
                            '</td></tr>';
                        $('#INCOMETABLE').append(tr);
                    });
                });

            })
        });
    </script>
@endsection
