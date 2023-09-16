@extends('layouts.admin')

@section('template_title')
{{ $client->name ?? 'Show Client' }}
@endsection

@section('content')
<link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet' type='text/css'>
<style>

    .emp-profile{
        padding: 3%;
        margin-top: 3%;
        margin-bottom: 3%;
        border-radius: 0.5rem;
        background: #fff;
    }
    .profile-img{
        text-align: center;
    }
    .profile-img img{
        width: 70%;
        height: 100%;
    }
    .profile-img .file {
        position: relative;
        overflow: hidden;
        margin-top: -20%;
        width: 70%;
        border: none;
        border-radius: 0;
        font-size: 15px;
        background: #212529b8;
    }
    .profile-img .file input {
        position: absolute;
        opacity: 0;
        right: 0;
        top: 0;
    }
    .profile-head h5{
        color: #333;
    }
    .profile-head h6{
        color: #0062cc;
    }
    .profile-edit-btn{
        border: none;
        border-radius: 1.5rem;
        width: 70%;
        padding: 2%;
        font-weight: 600;
        color: #6c757d;
        cursor: pointer;
    }
    .proile-rating{
        font-size: 12px;
        color: #818182;
        margin-top: 5%;
    }
    .proile-rating span{
        color: #495057;
        font-size: 15px;
        font-weight: 600;
    }
    .profile-head .nav-tabs{
        margin-bottom:5%;
    }
    .profile-head .nav-tabs .nav-link{
        font-weight:600;
        border: none;
    }
    .profile-head .nav-tabs .nav-link.active{
        border: none;
        border-bottom:2px solid #0062cc;
    }
    .profile-work{
        padding: 14%;
        margin-top: -15%;
    }
    .profile-work p{
        font-size: 12px;
        color: #818182;
        font-weight: 600;
        margin-top: 10%;
    }
    .profile-work a{
        text-decoration: none;
        color: #495057;
        font-weight: 600;
        font-size: 14px;
    }
    .profile-work ul{
        list-style: none;
    }
    .profile-tab label{
        font-weight: 600;
    }
    .profile-tab p{
        font-weight: 600;
        color: #0062cc;
    }
    .btn-lg{
        margin:3px;
    }
</style>
<div class="row">
    <a class="btn btn-md btn-primary" href="{{url('client')}}"><i class="fa fa-back-arrow"></i>< Back</a>
</div>
<div class="container emp-profile"> 
    <form method="post">
        <div id='emp-profile'>
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="{{route('client.avatar',$client[0]->avatar ? $client[0]->avatar : '0.jpg')}}" alt="No Image" width='100px' height="100px"/>                 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        <div class="row">
                            <div class="col-md-6"> ACCOUNT No.:</div>
                            <div class="col-md-6">{{$client[0]->id}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"> AREA:</div>
                            <div class="col-md-6">{{$client[0]->area_name}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"> ACCOUNT NAME:</div>
                            <div class="col-md-6">{{$client[0]->account_name}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"> ID NUMBER:</div>
                            <div class="col-md-6">{{$client[0]->national_id}}</div>
                        </div>

                        <p class="proile-rating">METER NUMBER : <span>{{$client[0]->meter_number}}</span>   |   PLOT NUMBER : <span>{{$client[0]->plot_number}}</span></p>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">READINGS/BALANCES</a>
                            </li>
                            <!--li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">ACCOUNT STATUS</a>
                            </li-->
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    @if($client[0]->status=='1')
                    <a href="#Disconnect-{{ $client[0]->id }}" class="btn btn-lg btn-danger " id='DISCONNECT' name="btnAddMore"><i class="fa fa-power-off"></i> DISCONNECT</a>
                    @else
                    <a href="#Reconnect-{{$client[0]->id }}" class="btn btn-lg btn-warning" id='RECONNECT' name="btnAddMore">RE-CONNECT</a>
                    @endif
                    <a href="{{ route('client.edit',$client[0]->id) }}" class="btn btn-lg btn-primary" name="btnAddMore"><i class="fa fa-pen"></i> Edit Profile</a>
                    <button id='PRINT' type="button" class="btn btn-md btn-warning"><i class="fa fa-print" ></i> Print</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-work">
                        <p>PHONE NUMBER</p>
                        <a href="">{{$client[0]->phone_no}}</a><br/>

                        <p>DATE ACCOUNT OPENED</p>
                        <a href="">{{$client[0]->account_open_date}}</a><br/>

                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Readings</label>
                                </div>
                                <div class="col-md-6 pull-right" >
                                    <p style="font-family: 'Times New Roman', sans-serif; text-align: right; font-size: 17px;font-weight: bold; ">{{$reading}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Current Balance</label>
                                </div>
                                <div class="col-md-6 pull-right">
                                    @php 
                                    $bal='';
                                    if($balance > 0){
                                    $bal = '('.number_format($balance,2).')';
                                    }else{
                                    $bal = number_format(($balance * -1),2);
                                    }
                                    @endphp
                                    <p style="font-family: 'Times New Roman', sans-serif; text-align: right; font-size: 17px;font-weight: bold; ">{{$bal}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Account Status</label>
                                </div>
                                <div class="col-md-6">
                                    <p style="text-align:right;"> {{$client[0]->status_name}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Connection Date</label>
                                </div>
                                <div class="col-md-6">
                                    <p style="text-align:right;"> {{$client[0]->connection_date}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Vacation Date</label>
                                </div>
                                <div class="col-md-6">
                                    <p style="text-align:right;"> {{$client[0]->vaccation_date}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Meter Reading Date</label>
                                </div>
                                <div class="col-md-6">
                                    <p style="text-align:right;"> {{ \Carbon\Carbon::parse($rd)->format('jS F, Y') }}</p>
                                </div>
                            </div>

                        </div>
                        <!--div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Account Status</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{$client[0]->status_name}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Connection Date</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{$client[0]->connection_date}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Vacation Date</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{$client[0]->vaccation_date}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Meter Reading Date</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ \Carbon\Carbon::parse($rd)->format('jS F, Y') }}</p>
                                </div>
                            </div>
    
                        </div-->
                    </div>
                </div>
            </div>
        </div>
    </form>           
</div>
<script>
    $(function () {

        $('#PRINT').click(function () {
            var divToPrint = document.getElementById('emp-profile');
            var htmlToPrint = '' +
                    '<style type="text/css">' +
                    'table th, table td {' +
                    'border:1px solid #000;' +
                    'padding;0.5em;' +
                    '}' +
                    '</style>';
            htmlToPrint += divToPrint.outerHTML;
            newWin = window.open("");
            newWin.document.write("<h3 align='center'>Print Page</h3>");
            newWin.document.write(htmlToPrint);
            newWin.print();
            newWin.close();
        });


        $('#DISCONNECT').click(function () {
            previous = parseInt("{{$reading}}")
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to disconnect {{$client[0]->account_name.'('.$client[0]->id.')'}}, Do you want to continue?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Disconnect'
            }).then((result) => {
                if (result.value) {

                    Swal.fire({
                        title: 'Enter meter reading',
                        input: 'text',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Submit',
                        showLoaderOnConfirm: true,
                        preConfirm: (para) => {

                            if (parseInt(para) < previous) {
                                Swal.showValidationMessage(`Request failed: Current reading less than previous`)
                            } else if (isNaN(para)) {
                                Swal.showValidationMessage(`Request failed: Invalid mete reading`)
                            } else if (para.length <= 0) {
                                Swal.showValidationMessage(`Request failed: No reading found`)
                            } else {

                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.value) {
                            data = {_token: "{{csrf_token()}}", cid: "{{$client[0]->id}}", current_reading: result.value};
                            $.post("{{route('client.disconnect')}}", data, function (resp) {
                                if (resp.status == 'true') {
                                    Swal.fire({
                                        title: 'Disconnected!',
                                        icon: 'success',
                                        text: "{{$client[0]->account_name.'('.$client[0]->id.')'}} Disconnected Successfully!"
                                    })
                                    window.location.href = "";
                                } else {
                                    Swal.fire({
                                        title: 'Not Disconnected!',
                                        icon: 'error',
                                        text: "{{$client[0]->account_name.'('.$client[0]->id.')'}} Could not be disconnected!"
                                    })
                                }
                            });


                        }
                    })

                }
            })
        })


        $('#RECONNECT').click(function () {
            //You are about to reconnect {{$client[0]->account_name.'('.$client[0]->id.')'}},
            previous = parseInt("{{$reading}}")
            Swal.fire({
                title: 'Enter reconnection fee',
                input: 'text',
                inputValue: '1155',
                inputAttributes: {
                    autocapitalize: 'off',

                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                preConfirm: (para) => {

                    if (para == '') {
                        Swal.showValidationMessage(`Request failed: No fee found, Please enter amount..`)
                    }

                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {

                if (result.value) {
                    data = {_token: "{{csrf_token()}}", cid: "{{$client[0]->id}}", amount: result.value};
                    $.post("{{route('client.reconnect')}}", data, function (resp) {
                        if (resp.status == 'true') {
                            Swal.fire({
                                title: 'Reconnected!',
                                icon: 'success',
                                text: "{{$client[0]->account_name.'('.$client[0]->id.')'}} Reconnected Successfully!"
                            })
                            window.location.href = "";
                        } else {
                            Swal.fire({
                                title: 'Not econnected!',
                                icon: 'error',
                                text: "{{$client[0]->account_name.'('.$client[0]->id.')'}} Could not be reconnected!"
                            })
                        }
                    });


                }
            })


        })
    })
</script>
@endsection
