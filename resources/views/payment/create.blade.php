@extends('layouts.admin')

@section('template_title')
Create Transaction
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-6">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Make New Payment</span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('payment.store') }}"  role="form" enctype="multipart/form-data">
                        @csrf

                        @include('payment.form')

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title"><b>Client Details</b></span>
                </div>
                <div class="LOADER" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span> 
                    </div>
                    Loading Client Details, Please Wait ...
                </div>
                <div class="card-body">
                    <table class="table-bordered table-responsive">
                        <tr>
                            <td>Account Name</td>
                            <td><span id="account_name"></span></td>
                        </tr>
                        <tr>
                            <td>Current Reading:</td>
                            <td><span id="account_reading"></span></td>
                        </tr>
                        <tr>
                            <td>Account Balance</td>
                            <td><span id="account_balance"></span></td>
                        </tr>
                    </table>                
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function () {
        $('#client_id').select2().on('change', (function (e) {
            $('.LOADER').show();
            $('#account_name').html('');
            $('#account_reading').html('');
            $('#account_balance').html('');
            id = $(this).val();
            result = '';
            $.getJSON("{{url('client-last-info')}}/" + id, function (res) {
                $('#account_name').html(' <strong>' + res[0].account_name + '</strong>');
                $('#account_reading').html(' <strong>' + res[0].current_reading + '</strong>');
                st = res[0].balance;
                if (parseInt(res[0].balance) <= 0) {
                    result = st.replace(/-/g, " ");
                } else {
                    result = '(' + st.replace(/-/g, " ") + ')';
                }

                $('#account_balance').html(' <strong>' + result + '<strong>');
                 $('.LOADER').hide();
            }).done(function(e){
                
            });
        }));
    })
</script>
@endsection
