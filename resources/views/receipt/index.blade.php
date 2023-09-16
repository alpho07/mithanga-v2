<!DOCTYPE html>
<html lang="en" >

    <head>

        <meta charset="UTF-8">


        <link href="{{url('print.css')}}" rel="stylesheet" />
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{url('print.js')}}"></script>

        <title>Fiancial | Receipt</title>

    </head>

    <body translate="no" >
        <span id='prINT'>
        <a class="btn btn-sm btn-primary" href="{{url('payment')}}">< BACK</a>
        <button class="btn btn-warning btn-sm" id="PRINTER">PRINT</button>
        </span>


        <div id="invoice-POS">

            <center>
                <h2 id="SamTITLE" style=" "> {{trans('panel.site_title')}} CUSTOMER RECEIPT</h2>
            </center>



            <div id="">
                <div class="">                  
                    <span style="font-size: 14px; font-weight: bold;"> 
                        P.O. Box 0000</br>
                        Tel:- 00000000</br>
                        Email:-financial@gmail.com</br>
                    </span>
                </div>
            </div><!--End Invoice Mid-->

            <div id="bot " style="margin-top: 5px;">

                <div id="table">
                    <table>                

                        <tr class="">
                            <td class=""><span class="itemtext">Receipt No :- {{$transactions[0]->id}}</span></td>
                        </tr>
                        <tr class="">
                            <td class=""><span class="itemtext">Receipt Date :- {{explode(' ', $transactions[0]->date)[0]}} </span></td>
                        </tr>
                        <tr class="">
                            <td class=""><span class="itemtext">Receipt Time :- {{explode(' ', $transactions[0]->date)[1]}}</span></td>
                        </tr>
                        <tr class="">
                            <td class=""><span class="itemtext">Total Received : {{number_format($transactions[0]->amount,2)}}</span></td>
                        </tr>


                        <tr class="">
                            <td class=""><p> </p></td>
                        </tr>

                        <tr class="">
                            <td class=""><span style="margin-top: 3px;" class="itemtext">Account Number:     {{$transactions[0]->client_id}}</span></td>
                        </tr>
                        <tr class="">
                            <td class=""><span class="itemtext">Account Name:       {{$transactions[0]->account_name}}</span></td>
                        </tr>
                        @php
                        $allsum=0;
                        if($arrears[0]->balance < 0){
                        $bal = $arrears[0]->balance * -1;
                        }else{
                        $bal = 0;
                        }

                        
                        @endphp
                        @if((int)$bal < 0)
                        <td class=""><span class="itemtext">ARREARS:      Kshs {{ number_format($bal,2)}}</span></td>
                        @endif

                        @if(count($bills) > 0)
                        <tr class="">
                            <td class=""></td>
                        </tr>
                        @foreach ($bills as $b)
                        <tr class="">
                            <td class=""><span class="itemtext">{{($b->items=='DISCONNECTION UNITS') ? 'WATER CHARGES' : $b->items }}:      Kshs {{number_format($b->amount,2)}}</span></td>
                        </tr>
                        @endforeach
                        @endif
                        <tr class="">
                            <td class="" style="height: 10px;"></td>
                        </tr>
                        <tr class="">
                            <td class=""><span class="itemtext">Amount Due:  Kshs {{$dupe}}</span></td>
                        </tr>                     

                        <tr class="">
                            <td class=""><span class="itemtext">Payment Mode:      {{$transactions[0]->mode}}</span></td>
                        </tr>
                        <tr class="">
                            <td class=""><p> </p></td>
                        </tr>

                        <tr class="">                    
                            <td class=""><span class="itemtext">{{strtoupper($words).' SHILLINGS ONLY'}}</span></td>
                        </tr>
                        <tr class="">
                            <td class=""><span class="itemtext">You can pay your bills through Paybill No.:- 823496</span></td>
                        </tr>
                        <tr class="">
                            <td class="" style="height: 16px;"></td>
                        </tr>
                        <tr class="">
                            <td class=""><span class="itemtext">Disconnection for non-payment is 10<sup>th</sup> of every month</span></td>
                        </tr>
                        <tr class="">
                            <td class=""><span class="itemtext">Reconnection Charges are Kshs. 1,155.00</span></td>
                        </tr>
                        <tr class="">
                            <td class="" style="height: 16px;"></td>
                        </tr>
                        <tr class="">
                            <td class=""><span class="itemtext">We thank you for giving us an opportunity to serve you.</span></td>
                        </tr>
                
                        <tr class="">
                            <td class=""><span class="itemtext">You were served by:- {{strtoupper($transactions[0]->staff)}}</span></td>
                        </tr>
                    </table>
                    <p class="" style="margin-top:400px;">Official Stamp..........................................</p>
                </div><!--End Table-->


            </div><!--End InvoiceBot-->
        </div><!--End Invoice-->

        <script>

$(function () {
    $('#PRINTER').click(function () {
        $('#prINT').hide();
        $('#invoice-POS').printThis({
            importCSS: false,
            loadCSS: "{{url('print.css')}}",
        });
    })
})

function PrintElem(elem)
{
    $(elem).css({fontSize: '12px'});
    $(elem).css('margin-left', '0');
    $(elem).css('padding', '0');

    Popup($(elem).html());
}

function Popup(data)
{
    var mywindow = window.open('', 'my div', 'height=auto,width=400px;');
    mywindow.document.write('<html><head><title></title>');
    mywindow.document.write('<link rel="stylesheet" href="{{url("print.css")}}" type="text/css" />');
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');

    mywindow.print();
    mywindow.close();

    return true;
}

function printDiv()
{

    var divToPrint = document.getElementById('invoice-POS');

    var newWin = window.open('', 'Print-Window');

    newWin.document.open();
    newWin.document.write('<link rel="stylesheet" href="{{url("print.css")}}" type="text/css" />');
    newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

    newWin.document.close();

    setTimeout(function () {
        //newWin.close();
    }, 10);

}
        </script>




    </body>

</html>