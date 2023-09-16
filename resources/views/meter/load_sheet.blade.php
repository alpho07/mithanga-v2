@extends('layouts.admin')

@section('template_title')
METER READING SHEETS
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <a href="{{url('areas')}}" class="btn btn-sm btn-warning"> Back to AREAS</a>
                    </div>
                </div>


                <div class="card-body">
                    <div class="table-responsive ">
                        <a href="{{route('download.sheet',$area_id)}}" class="btn btn-sm btn-secondary pull-right">PRINT SHEET</a>
                        <table class="table table-bordered table-hover">
                            <thead class="thead">
                                <tr><td colspan="6" style="text-align: center; font-weight: bold;"> {{trans('panel.site_title')}} - METER READING SHEET FOR <?php echo strtoupper(date('M Y')) ?></td></tr>
                                <tr>
                                    <th colspan="2">AREA: {{$area->name}}</th>                                   
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
                                @foreach($clients as $c)
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
<p style="page-break-before: always">
@endsection

