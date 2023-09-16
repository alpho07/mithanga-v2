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
<table class="table table-bordered table-hover">
    <thead class="thead">
        <tr><td colspan="6" style="text-align: center; font-weight: bold;">FINANCIAL WATER - METER READING SHEET FOR <?php echo strtoupper(date('M Y')) ?></td></tr>
        <tr>
            <th colspan="2">AREA: {{$area->name}}</th>                                   
            <th colspan="2">Meter Reader: ________________________________</th>                                    
            <th colspan="2">Reading Date: ________________________________
            </th>

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
