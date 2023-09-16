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
                            <strong>INVOICES</strong>
                        </span>

                        <div class="float-right">
                            <!--                            <a href="{{ route('payment.adjust') }}" class="btn btn-warning btn-sm float-right"  data-placement="left">
                                                            <i class="fa fa-plus" aria-hidden="true"></i> Tansaction Adjustments
                                                        </a>-->
                            <a href="{{ url('invoice/create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                <i class="fa fa-plus" aria-hidden="true"></i> Create Invoice
                            </a>

                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card-body">
                    <!--                    <a href="{{ route('run.bill') }}" class="btn btn-warning btn-lg float-left"  data-placement="left">
                                            Run Bills <i class="fa fa-rocket" aria-hidden="true"></i>
                                        </a>-->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Supplier</th>
                                    <th>Reference</th>
                                    <th>Date</th>
                                    <th>Amount Invoiced</th>
                                    <th>Amount Paid</th>
                                    <th>Balance</th>
                                    <th>Remarks</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ ++$i}}</td>
                                    <td>{{ $invoice->suppliers }}</td>
                                    <td>{{ $invoice->reference }}</td>
                                    <td>{{ $invoice->date }}</td>
                                    <td style="text-align: right;">{{ number_format($invoice->amount_invoiced,2) }}</td>
                                    <td style="text-align: right;">{{ number_format($invoice->paid,2) }}</td>
                                    <td style="text-align: right;">{{ number_format($invoice->balance,2) }}</td>
                                    <td>{{ $invoice->remarks }}</td>
                                    <td>
                                        @if($invoice->paid <= 0)
                                        <span class="badge badge-danger">NOT PAID</span>
                                        @elseif($invoice->paid > 0 && $invoice->paid < $invoice->amount_invoiced  )
                                        <span class="badge badge-warning">PARTIALLY PAID</span>
                                        @elseif($invoice->paid >= $invoice->amount_invoiced)
                                        <span class="badge badge-success">FULLY PAID</span>
                                        @endif
                                    </td>

                                    <td>
                                        <form action="{{ route('bill.destroy',$invoice->id) }}" method="POST">
                                            @can('billing_access')
                                            <a class="btn btn-sm btn-success" data-pid="{{$invoice->id}}"  href="{{route('invoicing.show',['cid'=>$invoice->supplier,'ref'=>$invoice->reference])}}"  id="TRANSRCEIPT"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                                            <a class="btn btn-sm btn-primary" data-pid="{{$invoice->id}}"   href="{{route('invoicing.edit',['cid'=>$invoice->supplier,'ref'=>$invoice->reference])}}"  id="TRANSRCEIPT"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                                            <a class="btn btn-sm btn-warning PAY" data-pid="{{$invoice->id}}"  data-ref="{{$invoice->reference}}" data-bal="{{number_format($invoice->balance,2) }}"  data-supplier="{{ $invoice->suppliers }}" href="{{route('invoicing.show',['cid'=>$invoice->supplier,'ref'=>$invoice->reference])}}"  data-toggle="modal" data-target="#myModal" id=""><i class="fa fa-check" aria-hidden="true"></i> Pay</a>
                                            <a class="btn btn-sm btn-danger" data-pid="{{$invoice->id}}"  href="{{route('invoicing.delete',$invoice->reference)}}"  id=""><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                                            @endcan
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
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


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form method="post" id="PFORM">
            @csrf
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="float:left;">Payment</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>Payee:</th>
                            <td id="PAYEE"></td>
                        </tr>
                        <tr>
                            <th>Payment Mode:</th>
                            <td>
                                <select name="mode" id="mop_id" class="form-control select2">
                                    @foreach($mop as $id => $m)
                                    <option value="{{ $m->id }}">{{$m->name  }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Bank Account:</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Bank:</th>
                            <td>
                                <select name="bank" id="BANK" class="form-control select2">
                                    <option value="">--Select Bank--</option> 
                                    @foreach($banks as $id => $m)
                                    <option value="{{ $m->id }}">{{$m->name  }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Reference:<input type="hidden" name="reference" id="REFIN" /></th>
                            <td id="REF"></td>
                        </tr>
                        <tr>
                            <th>Bank Balance:</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Current Balance:</th>
                            <td id="CBAL"></td>
                        </tr>
                        <tr>
                            <th>Amount:</th>
                            <td><input type="text" class="form-control" id="amount" name="amount" placeholder="Amount"/></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td></td>
                        </tr>
                    </table>
                    <div class="row">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>DATE</th>
                                    <th>MODE</th>
                                    <th>BANK</th>
                                    <th>AMOUNT PAID</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody id="PAYMANTS">
                                @foreach($payments as $p)
                                <tr>
                                    <td>{{$p->date_paid}}</td>
                                    <td>{{$p->pmode}}</td>
                                    <td>{{$p->banks}}</td>
                                    <td style="text-align: right;">{{number_format($p->amount,2)}}</td>
                                    <td><a href="#remove" data-id="{{$p->id}}" class="btn btn-danger bt-sm DREMOVE">-</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table>
                                <tr>
                                    <td> </td>
                                    <td></td>
                                </tr>
                            </table>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="button" class="btn tn-sm btn-primary" id="Pay" value="Submit"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </form>


    </div>
</div>

<!-- Modal -->
<script>
    $(function () {
        $('.PAY').click(function () {
            supplier = $(this).attr('data-supplier');
            ref = $(this).attr('data-ref');
            bal = $(this).attr('data-bal');
            $('#PAYEE').text(supplier)
            $('#REF').text(ref)
            $('#CBAL').text(bal)
            $('#REFIN').val(ref);
            $.getJSON("{{url('invoice/loaddetails')}}/" + ref, function (resp) {
                $('#PAYMANTS').empty();
                $.each(resp, function (i, d) {
                    tr = '<tr><td>' + d.date_paid + '</td><td>' + d.pmode + '</td><td>' + d.banks + '</td><td style="text-align: right;">' + d.amount + '</td><td><a href="#remove" data-id="' + d.id + '" class="btn btn-danger bt-sm DREMOVE">-</a></td></tr>';
                    $('#PAYMANTS').append(tr);
                })
            });

            // alert(supplier)
        })

        $('#Pay').click(function () {
            if ($('#mop_id').val() == '') {
                alert("Error: Select mode of payment");
            } else if ($('#BANK').val() == '') {
                alert("Error: MSelect Bank");
            } else if ($('#amount').val() == '') {
                alert("Error: Enter amount");
            } else {
                $.post("{{route('invoicing.pay')}}", $('#PFORM').serialize(), function () {
                    alert('Payment Added Successfully');
                    window.location.href = "";
                });
            }
        })

        $('.DREMOVE').click(function () {
            id = $(this).attr('data-id');
            ref = $('#REFIN').val();
            $.get("{{url('invoice/deletepay')}}/" + id + '/' + ref, function () {
                window.location.href = "";
            })
        });


    })
</script>
@endsection
