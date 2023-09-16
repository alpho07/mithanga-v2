@extends('layouts.admin')

@section('template_title')
Update Client
@endsection

@section('content')
<section class="content container-fluid">
    <div class="">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title"><h4><strong>Update Client &#187 {{$client[0]->account_name}} &#187  Account No.: {{$client[0]->id}}</strong></h4></span>
                </div>
                <div class="card-body"  style="background: #E3F2FD">
                    <form method="POST" action="{{ route('client.update', $client[0]->id) }}"  role="form" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @csrf
                        <div class="box box-info padding-1">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="area">Area</label>
                                            <select class="form-control" id="area" name="area">
                                                <option value="{{$client[0]->area}}">{{$client[0]->area_name}}</option>               
                                                @foreach($area as $a)
                                                <option value="{{$a->id}}">{{$a->name}}</option>
                                                @endforeach
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Account Name</label>
                                            <input type="text" value="{{$client[0]->account_name}}" class="form-control" id="account_name" name="account_name" placeholder="Account Name">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Phone Number</label>
                                            <input type="number" value="{{$client[0]->phone_no}}"  class="form-control" id="phone_no" name="phone_no" placeholder="Phone Number">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Email Address</label>
                                            <input type="email" value="{{$client[0]->email}}"  class="form-control" id="email" name="email" placeholder="Email Address">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">ID Number</label>
                                            <input type="number" value="{{$client[0]->national_id}}"  class="form-control" id="national_id" name="national_id" placeholder="ID Number">
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Plot Number</label>
                                                <input type="text"  value="{{$client[0]->plot_number}}" class="form-control" id="plot_number" name="plot_number" placeholder="Plot Number">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Plot Number</label>
                                            <input type="text"  value="{{$client[0]->plot_number}}" class="form-control" id="plot_number" name="plot_number" placeholder="Plot Number">
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Account Open Date</label>
                                            <input type="text" class="form-control datepicker" value="{{$client[0]->account_open_date}}"  id="account_open_date" name="account_open_date" data-date-format="DD MMMM YYYY" placeholder="Account Open Date">
                                        </div>
                                    </div>        
                                    <div class="col-6">              
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Meter Number</label>
                                            <input type="text"  value="{{$client[0]->meter_number}}" class="form-control" id="meter_number" name="meter_number" placeholder="Meter Number">
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect2">Account Status</label>
                                            <select  class="form-control" id="status" name="status">
                                                <option value="{{$client[0]->status}}">{{$client[0]->status_name}}</option>               
                                                @foreach($status as $a)
                                                <option value="{{$a->id}}">{{$a->status}}</option>
                                                @endforeach
                                            </select>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Avatar</label>
                                            <input type="file" class="form-control" id="avatar" name="avatar" placeholder="Avatar">
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Connection Date</label>
                                            <input type="text"  value="{{$client[0]->connection_date}}"    class="form-control datepicker" id="connection_date" name="connection_date" placeholder="Connection Date">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Vacation Date</label>
                                            <input type="text"  value="{{$client[0]->vaccation_date}}" class="form-control datepicker" id="vaccation_date" name="vaccation_date" placeholder="Vacation Date">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Reconnection Date</label>
                                            <input type="text"  value="{{$client[0]->reconnection_date}}" class="form-control datepicker" id="reconnection_date" name="reconnection_date" placeholder="Reconnection Date">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Meter Reading Date</label>
                                            <input type="date" class="form-control" value="{{$client[0]->meter_reading_date}}" id="meter_reading_date" name="meter_reading_date" placeholder="Meter Reading Date">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Comments</label>
                                            <textarea class="form-control"  value="{{$client[0]->comment}}" id="comment" name="comment" placeholder="Any Comment" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-md btn-primary" id="submit" value="Submit"/>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
