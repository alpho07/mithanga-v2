<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

/**
 * Class AreaController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_(Request $r) {
        $date = date('Y-m-d');
        $dmonth = date('Y-m');
        $q = '';
        $areas = Area::all();
        $clients = Client::all();

        if ($r->filled('q')) {
            $q = '?q=tenants';
            $salestoday = DB::select("SELECT SUM(amount) amount FROM transactions WHERE DATE(date)='$date' AND client_id  LIKE '%PVA%' AND type='credit'")[0]->amount;
            $salesmonthly = DB::select("SELECT SUM(amount) amount FROM transactions WHERE DATE(date) LIKE '%$dmonth%' AND client_id  LIKE '%PVA%' AND type='credit'")[0]->amount;
        } else {
            $salestoday = DB::select("SELECT SUM(amount) amount FROM transactions WHERE DATE(date)='$date' AND client_id  NOT LIKE '%PVA%' AND type='credit'")[0]->amount;
            $salesmonthly = DB::select("SELECT SUM(amount) amount FROM transactions WHERE DATE(date) LIKE '%$dmonth%' AND client_id  NOT LIKE '%PVA%' AND type='credit'")[0]->amount;
        }
        return view('dashboard.index_', compact('areas', 'clients', 'salestoday', 'salesmonthly','q'));
    }

    public function index() {
        $q='';
        $areas = Area::all();
        $clients = Client::all();
        $date = date('Y-m-d');
        $dmonth = date('Y-m');
        $salestoday = DB::select("SELECT SUM(amount) amount FROM transactions WHERE DATE(date)='$date'")[0]->amount;
        $salesmonthly = DB::select("SELECT SUM(amount) amount FROM transactions WHERE DATE(date) LIKE '%$dmonth%'")[0]->amount;
        return view('dashboard.index', compact('areas', 'clients', 'salestoday', 'salesmonthly','q'));
    }

    function loadConsumptionByMonths() {
        $res['period'] = [];
        $res['consumed'] = [];

        $data = DB::select("SELECT SUM(units) consumption, CONCAT(DATE_FORMAT(DATE(date),'%b'),'-',YEAR(DATE(date))) period, YEAR(DATE(date)) data_year, DATE_FORMAT(DATE(date),'%b') data_month  
                    FROM vw_transactions 
                    GROUP BY data_year,data_month  
                    ORDER BY FIELD(DATE_FORMAT(DATE(date),'%b') ,'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec')");

        foreach ($data as $r) :
            array_push($res['period'], $r->period);
            array_push($res['consumed'], floatval($r->consumption));
        endforeach;

        return $res;
    }

    function loadAreaConsumption() {
        $res['period'] = [];
        $res['consumed'] = [];
        $data = DB::select("SELECT area,SUM(units) consumption, CONCAT(DATE_FORMAT(DATE(date),'%b'),'-',YEAR(DATE(date))) period, YEAR(DATE(date)) data_year, DATE_FORMAT(DATE(date),'%b') data_month  
                            FROM vw_transactions 
                            GROUP BY data_year,data_month ,area 
                            ORDER BY consumption DESC");

        foreach ($data as $r) :
            array_push($res['period'], $r->area);
            array_push($res['consumed'], floatval($r->consumption));
        endforeach;

        return $res;
    }

    function loadAllIncome(Request $r) {
        if ($r->filled('q')) {
          
           
            $query = DB::select("SELECT CONCAT('Total Income - ',DATE_FORMAT(DATE(date),'%b'),'-',YEAR(DATE(date))) category,ROUND(SUM(amount),2) amount, CONCAT(DATE_FORMAT(DATE(date),'%b'),'-',YEAR(DATE(date))) period, YEAR(DATE(date)) data_year, DATE_FORMAT(DATE(date),'%b') data_month  
                        FROM vw_transactions 
                        WHERE description NOT LIKE 'CASH%' AND description NOT LIKE 'BANK%' 
                        AND description IS NOT NULL 
                        AND description !=' ' 
                        AND description NOT LIKE 'PAY%'
                        AND description NOT LIKE 'M-PESA%' 
                        AND client_id LIKE '%PVA%'
                        AND type='credit'
                        GROUP BY data_year,data_month ,category
                        ORDER BY amount DESC");
        } else {
         
            $query = DB::select("SELECT CONCAT('Total Income - ',DATE_FORMAT(DATE(date),'%b'),'-',YEAR(DATE(date))) category,ROUND(SUM(amount),2) amount, CONCAT(DATE_FORMAT(DATE(date),'%b'),'-',YEAR(DATE(date))) period, YEAR(DATE(date)) data_year, DATE_FORMAT(DATE(date),'%b') data_month  
                        FROM vw_transactions 
                        WHERE description NOT LIKE 'CASH%' AND description NOT LIKE 'BANK%' 
                        AND description IS NOT NULL 
                        AND description !=' ' 
                        AND description NOT LIKE 'PAY%'
                        AND description NOT LIKE 'M-PESA%'  
                        AND client_id NOT LIKE '%PVA%'
                        AND type='credit'
                        GROUP BY data_year,data_month ,category
                        ORDER BY amount DESC");
        }
        return $query;
    }

    function loadConsumptionByMonths_($m, $y) {
        $res['period'] = [];
        $res['consumed'] = [];

        $data = DB::select("SELECT SUM(units) consumption, CONCAT(DATE_FORMAT(DATE(date),'%b'),'-',YEAR(DATE(date))) period, YEAR(DATE(date)) data_year, DATE_FORMAT(DATE(date),'%b') data_month  
                    FROM vw_transactions 
                    WHERE  DATE_FORMAT(DATE(date),'%b')='$m' AND YEAR(DATE(date))='$y'
                    GROUP BY data_year,data_month  
                    ORDER BY FIELD(DATE_FORMAT(DATE(date),'%b') ,'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec')");

        foreach ($data as $r) :
            array_push($res['period'], $r->period);
            array_push($res['consumed'], floatval($r->consumption));
        endforeach;

        return $res;
    }

    function loadAreaConsumption_($m, $y) {
        $res['period'] = [];
        $res['consumed'] = [];
        $data = DB::select("SELECT area,SUM(units) consumption, CONCAT(DATE_FORMAT(DATE(date),'%b'),'-',YEAR(DATE(date))) period, YEAR(DATE(date)) data_year, DATE_FORMAT(DATE(date),'%b') data_month  
                            FROM vw_transactions 
                              WHERE  DATE_FORMAT(DATE(date),'%b')='$m' AND YEAR(DATE(date))='$y'
                            GROUP BY data_year,data_month ,area 
                            ORDER BY FIELD(DATE_FORMAT(DATE(date),'%b') ,'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'),consumption DESC");

        foreach ($data as $r) :
            array_push($res['period'], $r->area);
            array_push($res['consumed'], floatval($r->consumption));
        endforeach;

        return $res;
    }

    function loadAllIncome_($m, $y) {

        return DB::select("SELECT UPPER(description) category,SUM(amount) amount, CONCAT(DATE_FORMAT(DATE(date),'%b'),'-',YEAR(DATE(date))) period, YEAR(DATE(date)) data_year, DATE_FORMAT(DATE(date),'%b') data_month  
                        FROM vw_transactions 
                        WHERE description NOT LIKE 'CASH%' AND description NOT LIKE 'BANK%' 
                        AND description IS NOT NULL 
                        AND description !=' '
                        AND description NOT LIKE 'PAY%'
                        AND description NOT LIKE 'M-PESA%'
                        AND  DATE_FORMAT(DATE(date),'%b')='$m' AND YEAR(DATE(date))='$y'
                        GROUP BY data_year,data_month ,category
                        ORDER BY amount DESC");
    }
}
