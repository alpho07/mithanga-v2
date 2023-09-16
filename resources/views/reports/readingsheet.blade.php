@extends('layouts.admin')

@section('template_title')
Transaction
@endsection

@section('content')
@foreach($data as $d)
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">   
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-bordered table-hover">
                            <thead class="thead">
                                <tr><td colspan="6" style="text-align: center; font-weight: bold;">FINANCIAL WATER - METER READING SHEET FOR <?php echo strtoupper(date('M Y')) ?></td></tr>
                                <tr>
                                    <th colspan="2">AREA: {{$d['area']}}</th>                                   
                                    <th colspan="2">Meter Reader: ________________________________________</th>                                    
                                    <th colspan="2">Reading Date: ________________________________________</th>

                                </tr>
                                <tr>
                                    <th>No</th>
                                    <th>Account Number</th>
                                    <th>Account Name</th>
                                    <th>Previous Meter Reading</th>
                                    <th>Current Meter Reading</th>
                                    <th>Comments</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach($d['clients'] as $c)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$c->id}}</td>
                                    <td>{{strtoupper($c->account_name)}}</td>
                                    <td style="text-align: right;">{{$c->previous_reading}}</td>
                                    <td></td>
                                    <td></td>
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

@endforeach
@endsection