<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Area;
use App\Models\Status;
use Illuminate\Http\Request;
use DB;
use AfricasTalking\SDK\AfricasTalking;


/**
 * Class ClientController
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{

    function index()
    {
        return 'Mithanga services API Version 1.0';
    }

    function loadClients()
    {
        $clients =  DB::table('vw_clients as c')
            ->leftJoin('meter_readings as m', function ($join) {
                $join->on('c.id', '=', 'm.client_id')
            ->where(DB::raw("DATE_FORMAT(m.reading_date, '%Y-%m')"), '=','2023-08' /*date('Y-m')*/);
            })
            ->select('c.id', 'c.area_id', 'c.account_name', 'c.phone_no', 'c.area_name', 'c.rate', 'c.previous_reading', 'c.balance')
            ->selectRaw('IF(m.client_id IS NOT NULL, 1, 0) as status')
            ->get();
        $totalClients = $clients->count();
        return [
            'total' => $totalClients,
            'data' => $clients,
            'status' => 'Success'
        ];
    }

    function saveData()
    {
    }



    function save_reading(Request $r)
    {

        $previous_reading = DB::select("SELECT current_reading FROM meter_readings WHERE client_id='$r->id' ORDER BY id DESC LIMIT 1");
        
        if (!empty($previous_reading)) {           
            $pr = $previous_reading[0]->current_reading;
        } else {
            $pr = 0;
        }

        //$rate = Area::find($r->area_id)['rate'];
        $current_reading = $r->current_reading;
        $consumed = $current_reading - $pr;
        $total_cost = $consumed * 120;
        $date =  date('Y-m-d H:i:s');
        DB::insert("INSERT INTO meter_readings (client_id,reading_date,current_reading,previous_reading) VALUES ('$r->id','$date','$r->current_reading',$pr)");
        $date = '2023-08-31';//;date('Y-m-d H:i:s');
        $date1 = date_create($date);
        $date2 = date_format($date1, "M - Y");

        $total_cost = $consumed * 120;

        $description = "WATER - $date2";
        $ref = 'REF' . date('Ymd-His');

        DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,units,last_read,previous_read,reference) VALUES ('$r->id','$description','$date','debit','$total_cost','$consumed','$current_reading','$pr','$ref')");
        DB::update("UPDATE meter_readings SET bill_run='1' WHERE client_id = '$r->id';");
       
        $this->sendSampleText($r->id);


        return ['success' => 'Meter Reading Registered Successfully for account ' . $r->id];
    }

    function sendSampleText($client_id)
    {
        $reading1 = DB::table('vm_meter_readings')->where('client_id', $client_id)->orderBy('id','desc')->limit(2)->get();
        $reading2 = DB::table('vw_balances')->where('meter_number', $client_id)->latest('id')->first();
        $rate = 120;

        if ($reading2->balance < 0) {
            $arrears = ($reading2->balance * -1);
        } else {
            $arrears =0;
        }

        if (isset($reading1[1])) {
            // The index exists in the array
            $previous = $reading1[1]->current_reading;
            
        } else {
            // The index doesn't exist in the array
            $previous =  $reading1[0]->current_reading;
        }



        $main_message = 'Dear ' . $reading1[0]->account_name . "\n" .
            'Your ' . $reading1[0]->area_name . ' borehole water bill as at ' . date('d/m/Y') . "\n" .
            'Curr Read: ' . $reading1[0]->current_reading . ' units' . "\n" .
            'Prev Read: ' . $previous . ' units' . "\n" .
            'Consumption: ' . ($reading1[0]->current_reading - $previous) . ' units' . "\n" .
            'Total Due: ksh.' . number_format((($reading1[0]->current_reading - $previous) * $rate), 2) . "\n" .
            'ARREARS: ksh. ' .  number_format(( $arrears - (($reading1[0]->current_reading - $previous) * $rate)),2) . '/-' . "\n" .
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
        $recipients = //DB::table('demo_phone')->latest('id')->first()->phone; // . $new;

        // Use the service
        $result = $sms->send([
            'to' => $reading1[0]->phone_no, //$recipients,
            'message' => $main_message,
            'from'=>'POSTVIEW'
        ]); 

        // DB::table('sms_tracking_table')->insert([
        //     'to' => $recipients,
        //     'account_name' => $reading1[0]->account_name,
        //     'area' => $reading1[0]->area_name,
        //     'message' => $main_message,
        //     'date_time' => date('Y-m-d H:i:s'),
        //     'meter_number' => $client_id,
        //     'send_status' =>  $result['status'],
        //     'receive_status' => ''
        // ]);

        //return $result;
    }


    function loadClientsByArea($aid)
    {
        return Client::select('id', 'account_name')->where('area', $aid)->get();
    }
}
