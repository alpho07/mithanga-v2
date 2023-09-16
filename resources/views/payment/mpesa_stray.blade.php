@extends('layouts.admin')

@section('template_title')
Transaction
@endsection

@section('content')
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

 <script src="{{ asset('js/jquery.min.js') }}"></script>

<!-- Popper.js (required for Bootstrap JavaScript plugins) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


  <script src="{{ asset('js/select2.full.min.js') }}"></script>


 <script>
$(function(){
    clients='';
    clientSelect = $('#clientSelect');
    
    $.getJSON("<?php echo url('all_clients');?> ",function(resp){
        clientSelect.empty();
        clientSelect.append('<option value="">-Select Client-</option>');
        $.each(resp,function(i,d){
          clientSelect.append('<option value='+d.id+'>'+d.name+'</option>');  
        },'JSON')
        
        //clientSelect.select2();
    })
   // Open modal and populate form when "RECONCILER" button is clicked
$(".RECONCILER").click(function() {
    // Extract data from the table row
    const account = $(this).attr("account");
    const amount = $(this).attr("amount");
    const accountname = $(this).attr("accountname");
    const transcode = $(this).attr("code");
    // Populate the form with data
    $("#accountInput").val(account);
    $("#amountInput").val(amount);
    $("#accountNameInput").val(accountname);
    $("#transInput").val(transcode);
    // Open the modal
    $("#reconcileModal").modal();
});

// Handle form submission
$("#confirmSubmit").click(function() {
    
    if($('#clientSelect').val()==''){
      alert('Please select an account to reconcile payment before proceeing...')
      return false;
    }else{
    // You can perform any necessary form validation here
    // If the form is valid, you can show a confirmation popup
    if (confirm("Are you sure you want to submit? This will credit the new account selected, Process cannot be reversed")) {
        // Perform AJAX submit or form submission here
        // Close the modal when done
        //$("#reconcileModal").modal("dismiss");
        $('#reconcileForm').submit();
    }
    }
});

});
</script>

<!-- Button to trigger the modal -->


<!-- Modal -->
<div class="modal fade" id="reconcileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="reconcileForm" action="{{route('reconcile.save')}}" method="POST">
            {{csrf_field()}}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reconcile Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
    <div class="form-group">
        <label for="clientSelect">Select Client</label>
        <select class="form-control select2" id="clientSelect" name="new_account">
          
        
            <!-- Add more client options as needed -->
        </select>
    </div>
    <div class="form-group">
        <label for="accountInput">Account name</label>
        <input type="text" class="form-control" id="accountNameInput" name="accountName" readonly>
    </div>
    <div class="form-group">
        <label for="accountInput">Account</label>
        <input type="text" class="form-control" id="accountInput" name="accountNumber" readonly>
    </div>
    <div class="form-group">
        <label for="amountInput">Amount</label>
        <input type="text" class="form-control" id="amountInput" name="amount" readonly>
    </div>
                
      <div class="form-group">
        <label for="amountInput">Transaction Code(M-PESA)</label>
        <input type="text" class="form-control" id="transInput" name="transcode" readonly>
    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="confirmSubmit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            <strong>Stray Payments</strong>
                        </span>
                          <div class="float-right">
                              <a href="{{ route('mobile_transactions.stray') }}{{$q}}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                 Stray Payments
                            </a>
                            <a href="{{ route('mobile_transactions.index') }}{{$q}}" class="btn btn-warning btn-sm float-right"  data-placement="left">
                                Reconciled Payments
                            </a>
                       

                        </div>
                       
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif



    <!-- Search Form -->
    <form action="{{ route('transactions.search') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search by TransID or Transaction Type">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <!-- Transaction Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>M-PESA Code</th>
                <th>Account</th>                
                <th>Date Time</th>                
                <th>Customer</th>
                <th>Phone Number</th>
                <th style="text-align: right; ">Amount(KES)</th>
                  <th>Action</th>
               
                
                <!-- Add other table headers for columns -->
            </tr>
        </thead>
        <tbody >
               @php
             $amount = 0
             @endphp
            @foreach ($transactions as $transaction)
             @php
             $amount = $amount + $transaction->TransAmount; 
             @endphp
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->TransID }}</td>
                    <td>{{ $transaction->BillRefNumber }}</td>
                    <td>{{ $transaction->TransTime }}</td>                    
                    <td>{{ $transaction->FirstName.' '.$transaction->MiddleName.' '.$transaction->LastName }}</td>
                    <td>{{ str_replace('254','0',$transaction->MSISDN)}}</td>
                    <td style="text-align: right;font-weight: bold;">{{ number_format($transaction->TransAmount,2) }}</td>
                    <td><a class="btn btn-sm btn-warning RECONCILER" transcode="" code="{{$transaction->TransID }}" account="{{$transaction->BillRefNumber}}" amount="{{$transaction->TransAmount}}" accountname="{{ $transaction->FirstName.' '.$transaction->MiddleName.' '.$transaction->LastName }}" href="#reconcile">Reconcile</a></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="font-weight: bold">Total(KES)</td>
                <td style="font-weight: bold;text-align: right;">{{number_format($amount,2)}}</td>
            </tr>
        </tfoot>
    </table>

    <!-- Pagination Links -->
    {{ $transactions->links() }}
</div>              
                
                
                </div>
            </div>

        </div>

@endsection
