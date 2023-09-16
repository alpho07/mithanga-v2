@extends('layouts.test')

@section('content')
{!! $dataTable->table() !!}
@endsection


<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>

{!! $dataTable->scripts() !!}

