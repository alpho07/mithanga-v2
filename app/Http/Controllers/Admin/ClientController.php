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
use PDF;

/**
 * Class ClientController
 * @package App\Http\Controllers
 */
class ClientController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('client.index');
    }

    public function tenants() {
        return view('client.tenants');
    }

    public function home_page() {
        return view('client.home_page');
    }

    function loadClients() {
        $clients = DB::select(DB::raw("SELECT c.*, a.name area_name,s.status status_name FROM clients c LEFT JOIN areas a ON c.area = a.id LEFT JOIN statuses s ON c.status = s.id WHERE c.borehole_tenant=0"));
        return Datatables::of($clients)
                        ->smart(true)
                        ->make(true);
    }

    function loadTenants() {
        $clients = DB::select(DB::raw("SELECT c.*, a.name area_name,s.status status_name FROM clients c LEFT JOIN areas a ON c.area = a.id LEFT JOIN statuses s ON c.status = s.id WHERE c.borehole_tenant=1"));
        return Datatables::of($clients)
                        ->smart(true)
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPDF($id) {
        $area = Area::find($id)->name;
        $i = 0;
        $clients = DB::select("SELECT * FROM vw_clients  WHERE area_id='$id' order by id ASC");
        $pdf = PDF::loadView('area.client_report', compact('area', 'clients', 'i'));
        return $pdf->download($area . '_clients.pdf');
    }

    public function create() {
        $area = Area::all();
        $status = Status::all();
        $account = ''; //DB::select(DB::raw("SELECT MAX(id) id FROM clients"))[0]->id + 1;
        $unusedids = DB::select(DB::raw("SELECT id+1 ids FROM clients WHERE id NOT IN (SELECT id-1 FROM clients ) ORDER BY 1"));
        return view('client.create', ['area' => $area, 'status' => $status, 'account' => $account, 'unusedids' => $unusedids]);
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

        //$url = '';
        //$uids = $request->uid;
        request()->validate(Client::$rules);
        //if (empty($uids)) {
        if (isset($request['meter_number'])) {
            $request['id'] = $request['meter_number'];
            $request['status'] = 1;
            unset($request['meter_number']);
        }
        

        
         if (strpos(\strtolower($request['id']), 'pva') !== false) {
              $request['borehole_tenant'] = 1;
         }else{
              $request['borehole_tenant'] = 0;
         }
                 //dd($request->all());

        // dd($request->all());
        $client = Client::create($request->all());
        //} else {
        //  $client = Client::create(array_merge($request->all(), ['id' => $uids]));
        //}
        /* $id = DB::select(DB::raw("SELECT MAX(id) id FROM clients"));
          $cid = $id[0]->id;
          $amount = '0.00';

          if ($request->hasFile('avatar')) {
          $request->validate([
          'file' => 'mimes:jpeg,png,jpg|max:2048',
          ]);
          $fileName = $cid . '.' . $request->avatar->getClientOriginalExtension();
          $request->avatar->move(storage_path() . '/app/public', $fileName);
          $url = $fileName;
          DB::table('clients')->where('serial', $cid)->update(['avatar' => "$url"]);
          } */
        $id = $request['id'];
        $date = date('Y-m-d H:i:s');
        //DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units) VALUES ('$cid','Application Fee','$date','debit','$amount','0')");
        if (strpos(\strtolower($id), 'pva') !== false) {
            
        } else {
            DB::insert("INSERT INTO meter_readings (client_id,reading_date,current_reading) VALUES ('$id','$date','0')");
        }
        // $message = "Dear " . strtoupper($request->account_name) . " Your A/C is " . $id[0]->id . "  We are pleased to welcome you as a new client. We feel honored that you have chosen us to fill your water service needs, and we are eager to be of service. WE MAKE IT SAFE BECAUSE WATER IS LIFE. THANK YOU AND WELCOME!";
        // $this->sendSampleText($message, $request->phone_no);
        return redirect()->route('client.create')->with('success', 'Customer created successfully. Ad another....');
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
        if (strpos(\strtolower($id), 'pva') !== false) {
            $reding = 0;
            $balance = 0;
            $reading_date = DB::select(DB::raw("SELECT reading_date FROM meter_readings WHERE client_id='$id' ORDER BY id DESC LIMIT 1"));
        } else {
            $reding = DB::select(DB::raw("SELECT  fn_prv_reading($id) reading"));
            $balance = DB::select(DB::raw("SELECT fn_get_balance($id) balance"));
            $reading_date = DB::select(DB::raw("SELECT reading_date FROM meter_readings WHERE client_id='$id' ORDER BY id DESC LIMIT 1"));
        }
        // $date1 = date_create($reading_date[0]->reading_date);
        //$rrd= date_format($date1, "nS M, Y");
        return view('client.show', ['area' => @$area, 'status' => @$status, 'client' => @$client, 'balance' => @$balance[0]->balance, 'reading' => @$reding[0]->reading, 'rd' => @$reading_date[0]->reading_date]);
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
