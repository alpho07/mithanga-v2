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
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            <strong>STATEMENT OF ACCOUNT</strong>
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


                <div class="table-responsive">
                    <form action="{{ route('statement.get') }}" method="POST">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>Client/Area</th>
                                    <th>Date From</th>
                                    <th>Date To</th>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                    <td>
                                        <select name="client_id" id="client_id" class="form-control select2" >
                                            @foreach($clients as $id => $client)
                                            <option value="{{ $client->id }}">{{'ACCOUNT No. '.$client->id. ' | '.$client->account_name.' | '.$client->area_name  }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                               
                                    <td>
                                        <input type="text" name="from" value="{{$from}}" placeholder="From" reqired class="form-control datepicker"/>
                                    </td>
                                    <td>
                                        <input type="text" name="to" placeholder="To" value="{{$to}}" required class="form-control datepicker"/>
                                    </td>

                                    <td>

                                        @can('billing_access')
                                        <button type="input" class="btn btn-sm btn-success" ><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> Get Statement</button>
                                        @endcan
                                        @csrf
                                        
                                        </form>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $(function(){
        $('#client_id').select2();
    });
</script>
@endsection
