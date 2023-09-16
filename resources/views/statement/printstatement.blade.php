<head>
    <style>
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <section id="printToPdf">
        <div class="row col-12">
            <div class="row col-12">
                <div class="d-flex justify-content-end mb-4">
                    <form action="{{ url('statement/print') }}" method="get">
                        @csrf
                        <button class="btn btn-primary" type="submit" >Export to PDF</button>
                    </form>
                </div>
            </div>
            <table class="table">
                <tr>
                    <td><strong>Name</strong></td>
                    <td><strong>{{strtoupper($clients_narrowed[0]->account_name)}}</strong></td>
                    <td></td>
                    <td><strong>Service Area</strong></td>
                    <td><strong>{{strtoupper($clients_narrowed[0]->area_name)}}</strong></td>
                </tr>
                <tr>
                    <td><strong>Account No:</strong></td>
                    <td><strong>{{strtoupper($clients_narrowed[0]->id)}}</strong></td>
                    <td></td>
                    <td><strong>Statement Period</strong></td>
                    <td><strong>{{date('M Y', strtotime($from))}} to {{date('M Y', strtotime($to))}}</strong></td>
                </tr>

            </table>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead">

                    <tr>
                        <th>DATE</th>
                        <th>DESCRIPTION</th>
                        <th>REFERENCE</th>
                        <th style="text-align: right;">DEBIT</th>
                        <th style="text-align: right;">CREDIT</th>
                        <th style="text-align: right;">BALANCE</th>
                    </tr>
                    <tr>
                        <td colspan="5" style="font-weight: bold;">{{$opening_balance >= 0 ? 'OPENING BALANCE' : 'ARREARS'}}</td>                              
                        <td style="text-align: right;"><b>{{number_format($opening_balance,2)}}</b></td>
                    </tr>
                </thead>
                <tbody>

                    @php 
                    $account_balance = $opening_balance; 
                    @endphp
                    @foreach($statement as $s)
                    @php
                    $account_balance = ($s->type =='credit') ? $account_balance + $s->amount : $account_balance - $s->amount;
                    $credit_amount= ($s->type =='credit') ? $s->amount : '';
                    $debit_amount= ($s->type =='debit') ? $s->amount : '';                           

                    @endphp

                    <tr>
                        <td>{{$s->transaction_date}}</td>
                        <td>{{$s->description}}</td>                                
                        <td>{{$s->reference}}</td>
                        <td style="text-align: right;">{{is_numeric($debit_amount) ? number_format($debit_amount,2) : $debit_amount}}</td>
                        <td style="text-align: right;">{{is_numeric($credit_amount) ? number_format($credit_amount,2) : $credit_amount}}</td>
                        <td style="text-align: right;">{{number_format($account_balance,2)}}</td>
                    </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="font-weight: bold;">CLOSING BALANCE</td>                              
                        <td style="text-align: right;"><b>{{number_format($account_balance,2)}}</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
</body>



