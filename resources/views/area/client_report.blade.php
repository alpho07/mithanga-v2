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
<div class="card-body">
    <div class="table-responsive ">
        <table class="table table-striped table-hover areas">
            <thead class="thead">
                <tr>
                    <td colspan="4">
            <center>
                <strong>{{trans('panel.site_title')}} SERVICES CLIENTS BY AREA - {{$area}}</strong>
            </center>
            </td>
            </tr>
            <tr>
                <td colspan="4">
                    <strong>TOTAL CLIENTS: {{count($clients)}}</strong>
                </td>
            </tr>
            <tr>
                <th>No.#</th>
                <th>Account Number</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Balance</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($clients as $c)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->account_name }}</td>
                    <td>{{ $c->phone_no }}</td>
                    <td style="text-align: right">{{ number_format($c->balance) }}</td>


                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>