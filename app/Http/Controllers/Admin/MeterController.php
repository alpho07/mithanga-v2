<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Area;
use App\Models\Status;
use Illuminate\Http\Request;
use DB;
use AfricasTalking\SDK\AfricasTalking;
use PDF;

/**
 * Class ClientController
 * @package App\Http\Controllers
 */
class MeterController extends Controller {

    private $ref = '';
    private $cd = '';

    public function __construct() {
        $this->ref = date('YmdHis');
        $this->cd = '1868-' . date('YmdHis');
    }

    public function change() {
        $clients = DB::select("SELECT * FROM vw_clients");
        return view('meter.create', compact('clients'));
    }

    function registerChange(Request $r) {
        $res = DB::select("SELECT id,current_reading FROM meter_readings WHERE client_id='$r->client_id' ORDER BY id DESC LIMIT 1");
        $id = $res[0]->id;
        $date = $r->change_date . ' ' . date('H:i:s');
        DB::statement("INSERT INTO meter_changes (client_id,change_date,reading) VALUE('$r->client_id','$date','$r->reading')");
        //DB::statement("DELETE FROM meter_readings  WHERE id='$id'");
        DB::update("UPDATE meter_readings SET current_reading='$r->reading',bill_run='1' WHERE id='$id'");
        //DB::statement("INSERT INTO meter_readings (client_id,reading_date,current_reading) VALUE('$r->client_id','$date','$r->reading')");
        return redirect()->back()->with('message', 'Meter changing data saved');
    }

    function loadLastReading($id) {
        $res = DB::select("SELECT current_reading FROM meter_readings WHERE client_id='$id' ORDER BY id DESC LIMIT 1");
        if (count($res) > 0) {
            return $res;
        } else {
            return ['0' => ['current_reading' => 'No Previous Readings found']];
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $area = Area::all();
        if (request()->filled('selection_date')) {
            $criteria = substr(request()->selection_date, 0, -3);
        } else {
            $criteria = date('Y-m');
        }
        $first_client = DB::select(DB::raw("SELECT MIN(id) id FROM clients"));
        $ccid = $first_client[0]->id;
        $area_id = DB::select(DB::raw("SELECT area FROM clients WHERE id='$ccid'"))[0]->area;
        $readings = DB::select(DB::raw("SELECT * FROM vm_meter_readings WHERE reading_date like '%$criteria%'"));
        return view('meter.index', ['area' => $area, 'readings' => $readings, 'i' => 1, 'criteria' => $criteria, 'fc' => $first_client, 'aid' => $area_id]);
    }

    public function scheduler() {

        $area = Area::all();
        if (request()->filled('selection_date')) {
            $criteria = substr(request()->selection_date, 0, -3);
        } else {
            $criteria = date('Y-m');
        }

        $readings = DB::select(DB::raw("SELECT * FROM vw_bills_bills WHERE scheduler ='1'"));
        return view('meter.scheduler', ['area' => $area, 'readings' => $readings, 'i' => 1, 'criteria' => $criteria]);
    }

    function schedule_cns(Request $r) {
        $date = $r->selection_date;
        $name = $r->name;
        DB::update(DB::raw("UPDATE transactions SET scheduler='1' WHERE DATE_FORMAT(date,'%Y-%m-%d') > '2022-01-25'"));
        return redirect()->back()->with(['message' => 'Client Billing notification Schedule set']);
    }

    function loadlast($id) {
        return DB::select(DB::raw("select * from vm_meter_readings where client_id='$id' ORDER by id desc limit 1;"));
    }

    public function notification_center($id, $date) {

        $area = Area::all();
        //$new_date = substr($date, 0, -3);

        $first_client = DB::select(DB::raw("SELECT MIN(id) id FROM clients"));
        $ccid = $first_client[0]->id;
        $area_id = DB::select(DB::raw("SELECT area FROM clients WHERE id='$ccid'"))[0]->area;
        $readings = DB::select(DB::raw("SELECT * FROM vm_meter_readings WHERE reading_date like '%$date%' and area_id='$id' group by area_id"));
        return view('notification.index', ['area' => $area, 'readings' => $readings, 'i' => 1, 'area_' => $id, 'date' => $date, 'fc' => $first_client, 'aid' => $area_id]);
    }

    public function register($id, $aid) {
        $pv_status = '';
        $nt_status = '';
        $total = DB::select(DB::raw("SELECT COUNT(id) total FROM vw_clients WHERE area_id='$aid'"))[0]->total;
        $pbal = DB::select(DB::raw("SELECT balance  FROM vw_balances  WHERE id='$id'"))[0]->balance;

        $pmrr = DB::select(DB::raw("SELECT current_reading  FROM meter_readings  WHERE client_id='$id' ORDER BY id DESC LIMIT 1"));
        if (count($pmrr) > 0) {
            $pmr = $pmrr[0]->current_reading;
        } else {
            $pmr = '';
        }
        $i = 1;
        $previous = DB::select(DB::raw("SELECT id FROM vw_clients WHERE id < $id AND area_id='$aid' ORDER BY id  DESC LIMIT 1"));
        if (empty($previous)) {
            $pv = $id;
            $pv_status = "disabled=disabled " . "style=display:none;";
            $alert = '';
            $i = 1;
        } else {
            $pv = $previous[0]->id;
            $i = $i - 1;
        }

        $next = DB::select(DB::raw("SELECT id FROM vw_clients WHERE id > $id AND area_id='$aid' ORDER BY id ASC LIMIT 1"));
        if (empty($next)) {
            $nt = $id;
            $nt_status = "disabled=disabled " . "style=display:none;";
            $i = $id;
        } else {
            $nt = $next[0]->id;
            $i = $i + 1;
        }
        $client = DB::select(DB::raw("SELECT * FROM vw_clients WHERE id='$id' AND area_id='$aid'"));
        $area = Area::all();
        $area_name = Area::find($aid)->rate;
        return view('meter.meter_reading', [
            'client' => $client,
            'area' => $area,
            'area_name' => $area_name,
            'p' => $pv,
            'n' => $nt,
            'nts' => $nt_status,
            'pvs' => $pv_status,
            'aid' => $aid,
            'i' => $i,
            'total' => $total,
            'bal' => $pbal ? $pbal : '0.00',
            'prevr' => $pmr
        ]);
    }

    function getFid($id) {
        echo DB::select(DB::raw("SELECT MIN(id) id FROM clients WHERE area ='$id'"))[0]->id;
    }

    function load_sheet($area_id) {
        $area = Area::find($area_id);
        $i = 0;
        $clients = DB::select(DB::raw("SELECT * FROM vw_clients WHERE area_id='$area_id'"));
        return view('meter.load_sheet', compact('clients', 'i', 'area', 'area_id'));
    }

    function download_sheet($area_id) {
        $area = Area::find($area_id);
        $i = 0;
        $clients = DB::select(DB::raw("SELECT * FROM vw_clients WHERE area_id='$area_id'"));
        //return view('meter.download_sheet', compact('clients', 'i', 'area'));
        $pdf = PDF::loadView('meter.download_sheet', compact('clients', 'i', 'area'));
        return $pdf->download($area->name . '_READING-SHEET.pdf');
    }

    function load_staement($client_id) {
        $area = Area::find($area_id);
        $i = 0;
        $clients = DB::select(DB::raw("SELECT * FROM vw_clients WHERE area_id='$area_id'"));
        return view('meter.load_sheet', compact('clients', 'i', 'area'));
    }

    function save_reading(Request $r, $cid, $id, $aid) {
        $previous_reading = DB::select("SELECT current_reading FROM meter_readings WHERE client_id='$cid' ORDER BY id DESC LIMIT 1");
        if (count($previous_reading) <= 0) {
            $pr = $previous_reading = 0;
        } else {
            $pr = $previous_reading[0]->current_reading;
        }
        $rate = Area::find($aid)['rate'];
        $current_reading = $r->current_reading;
        $consumed = $current_reading - $pr;
        $total_cost = $consumed * $rate;
        $date = $r->reading_date . ' ' . date('H:i:s');
        DB::insert("INSERT INTO meter_readings (client_id,reading_date,current_reading) VALUES ('$cid','$date','$r->current_reading')");

        if ($pr == $r->current_reading) {
            $description = "WATER - " . date('M Y');
            DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units,last_read,reference,sc) VALUES ('$cid','$description','$date','debit','100','0',$current_reading,'$this->ref','yes')");
            $tid_ = DB::select(DB::raw("SELECT MAX(id) id FROM transactions"))[0]->id;
            DB::update("UPDATE meter_readings SET standing_charge='1' WHERE id = '$tid_';");
        } else {
            DB::insert("INSERT INTO meter_readings (client_id,reading_date,current_reading) VALUES ('$cid','$date','$r->current_reading')");
        }
        //DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units,'bill_run') VALUES ('$cid','Water Bill','$date','debit','$total_cost','$consumed','1')");

        return redirect()->route('meter.reading.m', ['id' => $id, 'aid' => $aid])->with('success', 'Meter Reading Registered Successfully for account ' . $cid);
    }

    function disconnect(Request $r) {
        $date = date('Y-m-d H:i:s');
        $ref = '';
        $query = DB::insert("INSERT INTO meter_readings (client_id,reading_date,current_reading,discon) VALUES ('$r->cid','$date','$r->current_reading','d')");
        //DB::insert("INSERT INTO transactions (client_id,description,date,type,amount) VALUES ('$r->cid','DISCONNECTION FEE','$date','debit','1155')");
        DB::table('clients')->where('id', "$r->cid")->update(['status' => 2]);

        $query2 = DB::select(DB::raw("SELECT * FROM vm_meter_readings  WHERE bill_run='0'"));

        foreach ($query2 as $q) :

            $id = $q->id;
            $cid = $q->client_id;
            $date = $q->reading_date;
            $date1 = date_create($date);
            $date2 = date_format($date1, "M-Y");
            $consumed = ($q->consumed_units) ? $q->consumed_units : 0;
            $current_reading = ($q->current_reading) ? $q->current_reading : 0;
            $total_cost = ($q->water_charges) ? $q->water_charges : 0;
            if ($q->discon == 'd') {
                $description = 'DISCONNECTION UNITS';
            } else {
                $description = "WATER CHARGES";
            }
            $ref = date('Ymd') . ((date('YmdHis') * 50) . $id);
            DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units,last_read,reference) VALUES ('$cid','$description','$date','debit','$total_cost','$consumed','$current_reading','$ref')");
            DB::update("UPDATE meter_readings SET bill_run='1' WHERE id = '$id';");
        endforeach;

        if ($query) {
            return ['status' => 'true'];
        } else {
            return ['status' => 'false'];
        }
    }

    function reconnect(Request $r) {
        $date = date('Y-m-d H:i:s');
        //$query = DB::insert("INSERT INTO meter_readings (client_id,reading_date,current_reading) VALUES ('$r->cid','$date','$r->current_reading')");
        $query = DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,reference) VALUES ('$r->cid','Reconnection Fee','$date','debit','$r->amount','$this->cd')");
        DB::table('clients')->where('id', "$r->cid")->update(['status' => 1]);
        if ($query) {
            return ['status' => 'true'];
        } else {
            return ['status' => 'false'];
        }
    }

    function runBill() {
        //DB::raw("TRUNCATE  transactions");
        // $period = ['2019-11','2019-11','2021-01','2021-02','2021-03','2021-04','2021-05','2021-06','2021-07','2021-08','2021-09','2021-10','2021-11','2021-12','2022-01','2022-02'];
        //foreach ($period as $p):
        $query = DB::select(DB::raw("SELECT * FROM vm_meter_readings  WHERE bill_run='0'"));

        // dd($query);
        $total = count($query);
        $message = $total > 0 ? $total . ' Bill(s) Sucessfully run and generated' : 'No pending bill(s) to process';
        foreach ($query as $q) :

            $id = $q->id;
            $cid = $q->client_id;
            $date = $q->reading_date;
            $date1 = date_create($date);
            $date2 = date_format($date1, "M - Y");
            $consumed = ($q->consumed_units) ? $q->consumed_units : 0;
            $current_reading = ($q->current_reading) ? $q->current_reading : 0;
            $total_cost = ($q->water_charges) ? $q->water_charges : 0;
            if ($q->discon == 'd') {
                $description = 'DISCONNECTION UNITS';
            } else {
                $description = "WATER - $date2";
            }
            DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units,last_read,reference) VALUES ('$cid','$description','$date','debit','$total_cost','$consumed','$current_reading','$this->ref')");
            DB::update("UPDATE meter_readings SET bill_run='1' WHERE id = '$id';");
        endforeach;
        //endforeach;
        //$this->addStandingCharges();
        return redirect()->route('billing.index')->with('success', $message);
    }

    function addStandingCharges() {
        $query = DB::select(DB::raw("SELECT * FROM vm_meter_readings  WHERE consumed_units='0' AND standing_charge='0'"));
        foreach ($query as $q) :
            $id = $q->id;
            $cid = $q->client_id;
            $date = date('Y-m-d H:i:s');
            $current_reading = ($q->current_reading) ? $q->current_reading : 0;
            $consumed = ($q->consumed_units) ? $q->consumed_units : 0;
            $total_cost = '100';
            $description = "WATER - " . date('M Y');
            DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units,last_read,reference) VALUES ('$cid','$description','$date','debit','$total_cost','$consumed',$current_reading,'$this->ref')");
            DB::update("UPDATE meter_readings SET standing_charge='1' WHERE id = '$id';");
        endforeach;
    }

    public function loadClient($id) {
        return DB::table('clients')->where('area', $id)->get();
    }

    function meter_reading(Request $r) {
        DB::insert("REPLACE INTO meter_readings (client_id,reading_date,current_reading) VALUES ('$r->client_id','$r->reading_date','$r->current_reading')");
        return redirect()->route('meter.index')->with('success', 'Meter Reading Registered Successfully!');
    }

    function sendNotification(Request $r) {
        $checked = $r->checked;

        if (empty($checked)) {
            echo 'Please go back and select atleast 1 customer ';
            die;
        } else {
            foreach ($checked as $ch) :
                $this->sendSampleText($ch);
            endforeach;
        }
        if ($r->filled('q')) {
            return redirect()->route('client.with_balances',['q' => 'tenants'])->with('success', count($checked) . ' Messages successfully Dispatched!');
        } else {
            return redirect()->route('client.with_balances')->with('success', count($checked) . ' Messages successfully Dispatched!');
        }
    }

    function sendSampleText($client_id) {


        if (strpos(\strtolower($client_id), 'pva') !== false) {
            $reading2 = DB::table('vw_balances')->where('id', $client_id)->latest('id')->first();

            $main_message = 'Dear ' . $reading2->account_name . "\n" .
                    'Your current Rent ARREARS is ksh. ' . number_format(abs($reading2->balance), 2) . '/-' . ". Please \n" .
                    'Pay via MPESA Only:' . "\n" .
                    'Paybill no: 4085189' . "\n" .
                    'Account number: ' . $client_id . "\n" .
                    'POSTVIEW APARTMENTS.' . "\n" .
                    'James 0723653255.' . "\n" .
                    'Thank you!.';

            $username = 'postviewhse'; // use 'sandbox' for development in the test environment
            $apiKey = '9e3ce58521f32e559a13a038082ef5fd9c8f02c2db155bb737823db56309caee'; // use your sandbox app API key for development in the test environment
            //$username = 'boreholeh2o';
            //$apiKey = '4613d345882869887031e7091f828fe3dd848a7b6cb68035fd788c5dc4ecc56e';

            $AT = new AfricasTalking($username, $apiKey);

            // Get one of the services
            $sms = $AT->sms();
            //$new = substr('0715882227', 1);
            $recipients = $reading2->phone_no; // DB::table('demo_phone')->latest('id')->first()->phone; // . $new;
            // Use the service
            $result = $sms->send([
                'to' => $recipients, //$recipients,
                'message' => $main_message,
                'from' => 'POSTVIEW'
            ]);

            DB::table('sms_tracking_table')->insert([
                'to' => $recipients,
                'account_name' => $reading2->account_name,
                'area' => $reading2->area_name,
                'message' => $main_message,
                'date_time' => date('Y-m-d H:i:s'),
                'meter_number' => $client_id,
                'send_status' => $result['status'],
                'receive_status' => ''
            ]);

            return $result;
        } else {
            $reading1 = DB::table('vm_meter_readings')->where('client_id', $client_id)->orderBy('id', 'desc')->limit(2)->get();
            $reading2 = DB::table('vw_balances')->where('meter_number', $client_id)->latest('id')->first();
            $rate = 120;

            if ($reading2->balance < 0) {
                $arrears = ($reading2->balance * -1);
            } else {
                $arrears = 0;
            }

            if (isset($reading1[1])) {
                // The index exists in the array
                $previous = $reading1[1]->current_reading;
            } else {
                // The index doesn't exist in the array
                $previous = $reading1[0]->current_reading;
            }



            $main_message = 'Dear ' . $reading1[0]->account_name . "\n" .
                    'Your ' . $reading1[0]->area_name . ' borehole water bill as at ' . '31/08/2023' . "\n" .
                    'Curr Read: ' . $reading1[0]->current_reading . ' units' . "\n" .
                    'Prev Read: ' . $previous . ' units' . "\n" .
                    'Consumption: ' . ($reading1[0]->current_reading - $previous) . ' units' . "\n" .
                    'Total Due: ksh.' . number_format((($reading1[0]->current_reading - $previous) * $rate), 2) . "\n" .
                    'ARREARS: ksh. ' . number_format(( $arrears - (($reading1[0]->current_reading - $previous) * $rate)), 2) . '/-' . "\n" .
                    'Total to pay: ksh.' . number_format($arrears, 2) . '/-' . "\n" .
                    'Pay via MPESA Only:' . "\n" .
                    'Paybill no: 4085189' . "\n" .
                    'Account number: ' . $client_id . "\n" .
                    'POSTVIEW APARTMENTS.' . "\n" .
                    'James 0723653255.' . "\n" .
                    'Thank you!.';

            $username = 'postviewhse'; // use 'sandbox' for development in the test environment
            $apiKey = '9e3ce58521f32e559a13a038082ef5fd9c8f02c2db155bb737823db56309caee'; // use your sandbox app API key for development in the test environment
            //$username = 'boreholeh2o';
            //$apiKey = '4613d345882869887031e7091f828fe3dd848a7b6cb68035fd788c5dc4ecc56e';

            $AT = new AfricasTalking($username, $apiKey);

            // Get one of the services
            $sms = $AT->sms();
            //$new = substr('0715882227', 1);
            $recipients = $reading2->phone_no; // DB::table('demo_phone')->latest('id')->first()->phone; // . $new;
            // Use the service
            $result = $sms->send([
                'to' => $recipients, //$recipients,
                'message' => $main_message,
                'from' => 'POSTVIEW'
            ]);

            DB::table('sms_tracking_table')->insert([
                'to' => $recipients,
                'account_name' => $reading1[0]->account_name,
                'area' => $reading1[0]->area_name,
                'message' => $main_message,
                'date_time' => date('Y-m-d H:i:s'),
                'meter_number' => $client_id,
                'send_status' => $result['status'],
                'receive_status' => ''
            ]);

            return $result;
        }
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

    function updateReadings(Request $r) {
        DB::insert(DB::raw("UPDATE meter_readings SET reading_date='$r->reading_date',current_reading='$r->current_reading' WHERE id='$r->id_'"));
        return redirect()->route('meter.index')->with('success', 'Update Successfull');
    }

    function getClientPage($cid) {
        $client = Client::find($cid);
        if (empty($client)) {
            return '0';
        } else {
            return $client;
        }
    }

    function updateTransaction() {

        DB::insert("REPLACE INTO transactions (client_id,description,date,type,amount) VALUES ('$r->client_id','$r->reading_date','$r->current_reading')");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        request()->validate(Client::$rules);

        $client = Client::create($request->all());
        $id = DB::select(DB::raw("SELECT MAX(id) id FROM clients"));
        $message = "Dear " . strtoupper($request->account_name) . " Your A/C is " . $id[0]->id . "  We are pleased to welcome you as a new client. We feel honored that you have chosen us to fill your water service needs, and we are eager to be of service. WE MAKE IT SAFE BECAUSE WATER IS LIFE. THANK YOU AND WELCOME!";
        $message2 = 'Dear ANIRITA POUL FARM LIMITED A/C 4615 your bill as at 26-Apr-20  Prev Read 158 Curr Read 310 Consumption 152 Arrears 0.00 Amount Paid 15,200.00 Current Bill 15,200.00 Total Amount 0.00. Due date is 10-May-20. Reconnection Fee is 1155. Bills payable through Paybill No 823496. WE MAKE IT SAFE BECAUSE WATER IS LIFE. THANK YOU. OPT OUT *456*9*5#';
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

        return view('client.show', ['area' => $area, 'status' => $status, 'client' => $client]);
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
        $client->update();

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
