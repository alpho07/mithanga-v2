<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Area;
use App\Models\Status;
use Illuminate\Http\Request;
use DB;
use AfricasTalking\SDK\AfricasTalking;
use Yajra\Datatables\Datatables;
use Response;

/**
 * Class ClientController
 * @package App\Http\Controllers
 */
class ReceiptController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pid, $clent_id) {
        $transaction = DB::table('vw_payments')->where('client_id', $clent_id)->where('id', $pid)->get();

        $words = $this->convertNumberToWord($transaction[0]->amount);
        $due = DB::table('vw_balances')->where('client_id', $clent_id)->get();

        $date = date('Y-m-d');
        // $opening_balance_ = DB::select(DB::raw("SELEC SUM(IF(type='debit',amount,-amount)) balance,client_id FROM transactions WHERE date < '$date' AND client_id='$clent_id' GROUP BY client_id"));
        $bills_ = DB::select(DB::raw("SELECT * FROM transactions WHERE type='debit' AND date >= '$date' AND client_id='$clent_id' AND description NOT LIKE 'CA%'"));
        $bills_2 = DB::select(DB::raw("SELECT * FROM transactions WHERE id='$pid' AND description NOT LIKE 'CA%'"));
        $receipt_details = DB::select(DB::raw("SELECT item items,SUM(amount) amount FROM vw_receipt_items WHERE trans_id='$pid' GROUP BY item"));    


        return view('receipt.index', ['transactions' => $transaction, 'dupe' => (@$due[0]->balance > 0) ? '(' . @$due[0]->balance . ')' : str_replace('-','',@$due[0]->balance), 'words' => $words, 'bills' => $receipt_details, 'arrears' => $due, 'bils_2' => $bills_2]);
    }

    function convertNumberToWord($num = false) {
        $num = str_replace(array(',', ' '), '', trim($num));
        if (!$num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
            } else {
                $tens = (int) ($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && (int) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode(' ', $words);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $area = Area::all();
        $status = Status::all();
        return view('client.create', ['area' => $area, 'status' => $status]);
    }

    public function avatar($fileId) {
        $path = storage_path('app/public/' . $fileId);
        $headers = ['Content-Type:application/image'];
        return Response::download($path, $fileId, $headers);
    }

    function sendSampleText($message, $number) {
        $username = 'alpho07'; // use 'sandbox' for development in the test environment
        $apiKey = '89d148b1c97450883698fc0c6c35f78fab73bb7e0a4998e24fbdf1cd5245d6a1'; // use your sandbox app API key for development in the test environment
        $AT = new AfricasTalking($username, $apiKey);

// Get one of the services
        $sms = $AT->sms();
        $new = substr($number, 1);
        $recipients = "+254" . $new;

// Use the service
        $result = $sms->send([
            'to' => $recipients,
            'message' => $message
        ]);

        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $url = '';
        request()->validate(Client::$rules);

        $client = Client::create($request->all());
        $id = DB::select(DB::raw("SELECT MAX(id) id FROM clients"));
        $cid = $id[0]->id;


        if ($request->hasFile('avatar')) {
            $request->validate([
                'file' => 'mimes:jpeg,png,jpg|max:2048',
            ]);
            $fileName = $cid . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(storage_path() . '/app/public', $fileName);
            $url = $fileName;
            DB::table('clients')->where('id', $cid)->update(['avatar' => "$url"]);
        }

        $date = date('Y-m-d H:i:s');
        DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units) VALUES ('$cid','Application Fee','$date','debit','1155','0')");
        DB::insert("INSERT INTO meter_readings (client_id,reading_date,current_reading) VALUES ('$cid','$date','0')");
        $message = "Dear " . strtoupper($request->account_name) . " Your A/C is " . $id[0]->id . "  We are pleased to welcome you as a new client. We feel honored that you have chosen us to fill your water service needs, and we are eager to be of service. WE MAKE IT SAFE BECAUSE WATER IS LIFE. THANK YOU AND WELCOME!";
        $this->sendSampleText($message, $request->phone_no);
        return redirect()->route('client.index')
                        ->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $client = DB::select(DB::raw("SELECT c.*, a.name area_name,s.status status_name FROM clients c INNER JOIN areas a ON c.area = a.id INNER JOIN statuses s ON c.status = s.id WHERE c.id='$id'"));
        $area = Area::all();
        $status = Status::all();
        $reding = DB::select(DB::raw("SELECT  `fn_prv_reading`('$id')` reading"));
        $balance = DB::select(DB::raw("SELECT `fn_get_balance`('$id')` balance"));
        return view('client.show', ['area' => $area, 'status' => $status, 'client' => $client, 'balance' => $balance[0]->balance, 'reading' => $reding[0]->reading]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $client = DB::select(DB::raw("SELECT c.*, a.name area_name,s.status status_name FROM clients c INNER JOIN areas a ON c.area = a.id INNER JOIN statuses s ON c.status = s.id WHERE c.id='$id'"));
        $area = Area::all();
        $status = Status::all();
        return view('client.edit', ['area' => $area, 'status' => $status, 'client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Client $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        if ($request->hasFile('avatar')) {
            $request->validate([
                'file' => 'mimes:jpeg,png,jpg|max:2048',
            ]);
            $fileName = $id . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(storage_path() . '/app/public', $fileName);
            $url = $fileName;
            DB::table('clients')->where('id', $id)->update(['avatar' => "$url"]);
        }


        $client = Client::find($id);
        $client->area = $request->area;
        $client->phone_no = $request->phone_no;
        $client->account_name = $request->account_name;
        $client->national_id = $request->national_id;
        $client->email = $request->email;
        $client->plot_number = $request->plot_number;
        $client->account_open_date = $request->account_open_date;
        $client->meter_number = $request->meter_number;
        $client->status = $request->status;
        $client->connection_date = $request->connection_date;
        $client->vaccation_date = $request->vaccation_date;
        $client->reconnection_date = $request->reconnection_date;
        $client->connection_date = $request->connection_date;
        $client->comment = $request->comment;
        $client->kra_pin = $request->kra_pin;
        $client->update();

        if ($request->status == '2') {
            
        }

        if ($request->status == '3') {
            
        }


        return redirect()->route('client.index')->with('success', 'Client updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $client = Client::find($id)->delete();

        return redirect()->route('client.index')
                        ->with('success', 'Client deleted successfully');
    }

}
