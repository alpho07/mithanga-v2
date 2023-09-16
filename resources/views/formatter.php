<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ trans('panel.site_title') }}</title>
        <link href="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
        <link href="//use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
        <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
        <link href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
        <link href="//cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
        <link href="//cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
        <link href="//unpkg.com/@coreui/coreui@2.1.16/dist/css/coreui.min.css" rel="stylesheet" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
        @yield('styles')
        <style>
            body{
                background: -webkit-linear-gradient(left, #3931af, #00c6ff);
            }

            .btn-sm{
                margin: 1px;
            }

        </style>

    </head>

    <body class="app header-fixed sidebar-fixed aside-menu-fixed pace-done sidebar-lg-show">
        <header class="app-header navbar">
            <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">
                <span class="navbar-brand-full">{{ trans('panel.site_title') }}</span>
                <span class="navbar-brand-minimized">{{ trans('panel.site_title') }}</span>
            </a>
            <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
                <span class="navbar-toggler-icon"></span>
            </button>

            <ul class="nav navbar-nav ml-auto">
                @if(count(config('panel.available_languages', [])) > 1)
                <li class="nav-item dropdown d-md-down-none">
                    <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach(config('panel.available_languages') as $langLocale => $langName)
                        <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }} ({{ $langName }})</a>
                        @endforeach
                    </div>
                </li>
                @endif


            </ul>
        </header>

        <div class="app-body">
            @include('partials.menu')
            <main class="main">


                <div style="padding-top: 20px" class="container-fluid">
                    @if(session('message'))
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        </div>
                    </div>
                    @endif
                    @if($errors->count() > 0)
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @yield('content')

                </div>


            </main>
            <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="//unpkg.com/@coreui/coreui@2.1.16/dist/js/coreui.min.js"></script>
        <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
        <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
        <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="//cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
        <script src="//cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
        <script>
$(function() {


$('#BANK').change(function(){
$.getJSON("{{url('bank-branches')}}/" + $(this).val(), function(data){
$('#BRANCH').empty();
$('#BRANCH').append('<option value="">--Select Branch--</option>');
$.each(data, function(i, d){

$('#BRANCH').append('<option value="' + d.id + '">' + d.name + '</option>');
});
})
});
$(document).on('click', '#TRANSRCEIPT', function(){
pid = $(this).attr('data-pid');
client_id = $(this).attr('data-client-id');
$.getJSON("{{url('client-info')}}/" + pid + '/' + client_id, function(data){
$('#pdate').text(data.transactions[0].date)
        $('#pref').text(data.transactions[0].reference)
        $('#paccount').text(data.transactions.client_id)
        $('#paname').text(data.due[0].account_name)
        $('#pitem').text(data.transactions[0].description)
        $('#price_').text(data.transactions[0].amount)
        $('#price_due').text(data.transactions[0].balance)
        $('#mode').text(data.transactions[0].mode)
        $('#served').text(data.transactions[0].staff)
        if (data.due[0].balance == '' || data.due[0].balance > 0){
balance = '0.00';
} else{
balance = data.due[0].balance
}
$('#price_due').text(balance)


})
});
$('#meterselection').change(function(){
value = $(this).val();
name = $('#meterselection option:selected').text();
$.get("{{url('find_id')}}/" + value, function(resp){

if (resp == ''){
Swal.fire(
        'No Clients',
        name + ' has no clients',
        'success'
        )
} else{

}

})
})






        let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
        let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
        let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
        let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
        let printButtonTrans = '{{ trans('global.datatables.print') }}'
        let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'

        let languages = {
        'en': '//cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
        };
$.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
        $.extend(true, $.fn.dataTable.defaults, {
        language: {
        url: languages['{{ app()->getLocale() }}']
        },
                columnDefs: [{
                orderable: false,
                        className: 'select-checkbox',
                        targets: 0
                }, {
                orderable: false,
                        searchable: false,
                        targets: - 1
                }],
                select: {
                style:    'multi+shift',
                        selector: 'td:first-child'
                },
                order: [],
                scrollX: true,
                pageLength: 100,
                dom: 'lBfrtip<"actions">',
                buttons: [
                {
                extend: 'copy',
                        className: 'btn-default',
                        text: copyButtonTrans,
                        exportOptions: {
                        columns: ':visible'
                        }
                },
                {
                extend: 'csv',
                        className: 'btn-default',
                        text: csvButtonTrans,
                        exportOptions: {
                        columns: ':visible'
                        }
                },
                {
                extend: 'excel',
                        className: 'btn-default',
                        text: excelButtonTrans,
                        exportOptions: {
                        columns: ':visible'
                        }
                },
                {
                extend: 'pdf',
                        className: 'btn-default',
                        text: pdfButtonTrans,
                        exportOptions: {
                        columns: ':visible'
                        }
                },
                {
                extend: 'print',
                        className: 'btn-default',
                        text: printButtonTrans,
                        exportOptions: {
                        columns: ':visible'
                        }
                },
                {
                extend: 'colvis',
                        className: 'btn-default',
                        text: colvisButtonTrans,
                        exportOptions: {
                        columns: ':visible'
                        }
                }
                ]
        });
        $.fn.dataTable.ext.classes.sPageButton = '';
});
        </script>
        @yield('scripts')

        <script>
            $(function(){
            $('.areas,.costcener,.legal,.supplies,.supplies,.status,.client').DataTable({
            "autoWidth": false
            });
            $(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
            $('#area').select2();
            });
            $(".monthPicker").datepicker({

            dateFormat: 'yy-mm-23',
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    onClose: function(dateText, inst) {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).val($.datepicker.formatDate('yy-mm-23', new Date(year, month, 1)));
                    }
            });
            function ptr_(){
            //change the font-size
            $("#Receipt").css({fontSize: '12px'});
            $("#Receipt").css('margin-left', '0');
            $("#Receipt").css('padding', '0');
            window.print(); //trigger the print dialog

            $("#Receipt").modal('hide'); //dismiss modal
            }

        </script>
    </body>

</html>
