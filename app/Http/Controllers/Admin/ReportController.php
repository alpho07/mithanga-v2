<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Area;
use DB;

/**
 * Class PaymentController
 * @package App\Http\Controllers
 */
class ReportController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function waterbill(Request $r) {
        $area = $r->get('area');
        $selector = $r->get('people');
        $criteria = $r->get('selector');
        $cid = $r->get('cid');
        $areag = '';
        $selectorf = '';
        $used_like_date = '';
        $day = date('j');

        if ($day < 31) {
            $used_like_date = date("Y-m", strtotime("previous month"));
        } else {
            $used_like_date = date("Y-m");
        }

        $query = '';

        $areas = Area::all();
        $clients = Client::all();
        $data = DB::select(DB::raw("SELECT * FROM settings_dpms"));

        if ($criteria == 'area') {
            foreach ($area as $a) {
                $areag .= "'" . $a . "'" . ',';
            }
            $areaf = '(' . rtrim($areag, ',') . ')';
            DB::statement("CREATE OR REPLACE VIEW vw_bills as SELECT * FROM vm_meter_readings WHERE area_id IN $areaf AND reading_date LIKE '%$used_like_date%' ");
            return redirect()->to('billLoader');
        } else if ($criteria == 'person') {

            foreach ($selector as $a) {
                $selectorf .= "'" . $a . "'" . ',';
            }
            $selectorf = '(' . rtrim($selectorf, ',') . ')';
            DB::statement("CREATE OR REPLACE VIEW vw_bills as SELECT * FROM vm_meter_readings WHERE client_id IN $selectorf AND reading_date LIKE '%$used_like_date%'");
            return redirect()->to('billLoader');
        } else if ($criteria == 'account') {
            DB::statement("CREATE OR REPLACE VIEW vw_bills as SELECT * FROM vm_meter_readings WHERE client_id = '$cid' AND reading_date LIKE '%$used_like_date%' ORDER BY id DESC LIMIT 1");
            return redirect()->to('billLoader');
        } else {
            $balance = DB::select(DB::raw("SELECT balance FROM vw_balances WHERE client_id='1'"));
            $billing = DB::select(DB::raw("SELECT * FROM vm_meter_readings WHERE client_id='1' ORDER BY id DESC LIMIT 1"));
            $data2 = DB::table('vm_meter_readings')->where('client_id', $cid)->paginate(1)->appends(request()->query());
            return view('reports.waterbill', compact('data', 'balance', 'billing', 'data2', 'areas', 'clients', 'cid', 'clients', 'area'))->with('i', (request()->input('page', 1) - 1) * $data2->perPage());
        }
    }

    function billLoader() {
        $areas = Area::all();
        $clients = Client::all();
        $cid = '';
        $area = '';
        $data = DB::select(DB::raw("SELECT * FROM settings_dpms"));
        $balance = DB::select(DB::raw("SELECT balance FROM vw_balances WHERE client_id='1'"));
        $billing = DB::select(DB::raw("SELECT * FROM vm_meter_readings WHERE client_id='1' ORDER BY id DESC LIMIT 1"));
        $data2 = DB::table('vw_bills')->paginate(1)->appends(request()->query());
        return view('reports.waterbills2', compact('data', 'balance', 'billing', 'data2', 'areas', 'clients', 'cid', 'clients', 'area'))->with('i', (request()->input('page', 1) - 1) * $data2->perPage());
    }

    public function waterbillbyaccount(Request $r) {
        $area = $r->input->get('area');
        foreach ($area as $a) {
            echo $a . '<br>';
        }

        /*
          $selected = $r->selected;
          $area = $r->area;
          $client = $r->client;
          $account = $cid = $r->account;

          $query = '';
          $area_s = '';
          $account_s = '';

          if ($selected == 'area') {
          foreach ($area as $a) {
          $area_s .= "'" . $a . "'" . ",";
          }
          $ids = '(' . rtrim($area_s, ',') . ')';
          $query .= " AND area_id IN $ids";
          } else if ($selected == 'person') {
          foreach ($client as $b) {
          $account_s .= "'" . $b . "'" . ",";
          }
          $ids2 = '(' . rtrim($account_s, ',') . ')';
          $query .= " AND client_id IN $ids2";
          } else if ($selected == 'account') {
          $query .= " AND client_id ='$account'";
          } */


        /* $client = $cid = @$_GET['cid'];
          //$client = @$_GET['client'];
          $area = @$_GET['area'];
          $query = '';

          $areas = Area::all();
          $clients = Client::all();
          $data = DB::select(DB::raw("SELECT * FROM settings_dpms"));



          $query .= " AND client_id ='$cid'";

          $raw = preg_replace('/AND/', '', $query, 1);



          $billing = DB::select(DB::raw("SELECT * FROM vm_meter_readings WHERE client_id='$cid'"));
          $balance = DB::select(DB::raw("SELECT balance FROM vw_balances WHERE client_id='$cid'"));
          $data2 = DB::table('vm_meter_readings')->whereRaw($raw)->paginate(1)->appends(request()->query());
          if ($data2->count() > 0) {
          return view('reports.waterbill', compact('data', 'balance', 'billing', 'data2', 'areas', 'clients', 'cid', 'client', 'area'))->with('i', (request()->input('page', 1) - 1) * $data2->perPage());
          } else {
          return redirect()->back()->with('error', 'Record Not found');
          } */
    }

    function areas() {
        return Area::all();
    }

    function people() {
        return Client::all();
    }

    function balances(Request $r) {
        $q = '';
        if ($r->filled('q')) {
            $q = '?q=tenants';
            $balances_ = DB::select("SELECT * FROM temp_balances WHERE area_name LIKE '%M0000%' ORDER BY balance ASC");
        } else {
            $q = '';
            $balances_ = DB::select("SELECT * FROM  temp_balances WHERE  area_name NOT LIKE '%M0000%' ORDER BY balance ASC");
        }
        $areas = Area::all();
        //DB::statement("DROP TABLE IF EXISTS temp_balances;CREATE TABLE temp_balances as SELECT * FROM vw_final_balances");

        return view('reports.balances', compact('areas', 'balances_', 'q'));
    }

    function balances_client(Request $r) {
        $areas = Area::all();
        //DB::statement("DROP TABLE IF EXISTS temp_balances_clients;CREATE TABLE temp_balances_clients as SELECT * FROM vw_balances");
        $data = [];
        foreach ($areas as $a) :
            $area = Area::find($a);
            $q = '';
            if ($r->filled('q')) {
                $q = '?q=tenants';
                $clients = DB::select("SELECT * FROM temp_balances_clients WHERE area='$a->id' AND area_name LIKE '%M0000%' ORDER BY id ASC");
                $balance = DB::select("SELECT SUM(balance) balance FROM temp_balances_clients WHERE area='$a->id' area_name LIKE '%M0000%'  ORDER BY id ASC");
                $fidata = ['area' => $a->name, 'balance' => $balance[0]->balance, 'clients' => $clients];
                array_push($data, $fidata);
            } else {
                $clients = DB::select("SELECT * FROM temp_balances_clients WHERE area='$a->id' AND area_name NOT LIKE '%M0000%'  ORDER BY id ASC");
                $balance = DB::select("SELECT SUM(balance) balance FROM temp_balances_clients WHERE area='$a->id' AND area_name LIKE '%M0000%'  ORDER BY id ASC");
                $fidata = ['area' => $a->name, 'balance' => $balance[0]->balance, 'clients' => $clients];
                array_push($data, $fidata);
            }


        endforeach;

        return view('reports.client_balances', compact('data', 'q'));
    }

    function clients_with_balances(Request $r) {

        //$clients = DB::select("SELECT * FROM temp_balances_clients WHERE area='$a->id' ORDER BY id ASC");
        $q = '';
        if ($r->filled('q')) {
            $q = '?q=tenants';
            $data = DB::select("SELECT id,area,area_name,account_name,phone_no,account_open_date,id meter_number,plot_number,status,connection_date,vaccation_date,reconnection_date,meter_reading_date,avatar,national_id,comment,email,created_at,updated_at,kra_pin,client_id,credit,debit,balance FROM temp_balances_clients WHERE balance < 0  AND area_name LIKE '%M0000%' GROUP BY client_id ORDER BY balance,id ASC");
        } else {
            $data = DB::select("SELECT * FROM temp_balances_clients WHERE balance < 0  AND area_name NOT LIKE '%M0000%' GROUP BY client_id ORDER BY balance,id ASC");
        }
        //return $data;


        return view('reports.client_with_balances', compact('data', 'q'));
    }

    function clients_with_no_balances(Request $r) {

        //$clients = DB::select("SELECT * FROM temp_balances_clients WHERE area='$a->id' ORDER BY id ASC");
        $q = '';
        if ($r->filled('q')) {
            $q = '?q=tenants';
            $data = DB::select("SELECT id,area,area_name,account_name,phone_no,account_open_date,id meter_number,plot_number,status,connection_date,vaccation_date,reconnection_date,meter_reading_date,avatar,national_id,comment,email,created_at,updated_at,kra_pin,client_id,credit,debit,balance FROM temp_balances_clients WHERE balance >= 0 AND area_name LIKE '%M0000%' GROUP BY client_id ORDER BY balance,id ASC");
        } else {
            $data = DB::select("SELECT * FROM temp_balances_clients WHERE balance >= 0 AND area_name NOT LIKE '%M0000%' GROUP BY client_id ORDER BY balance,id ASC");
        }
        // return $data;

        return view('reports.client_with_balances', compact('data','q'));
    }

    function history() {
        $cid = @$_GET['client'];
        $date = @$_GET['date'];
        $query = '';
        if (!empty($cid)) {
            $query .= " AND client_id ='$cid'";
        }
        if (!empty($date)) {
            $query .= " AND reading_date <='$date'";
        }

        $raw = preg_replace('/AND/', '', $query, 1);
        $areas = Area::all();
        $clients = DB::select("SELECT * FROM vw_clients");

        if (!empty($query)) {
            $client = DB::select("SELECT * FROM vw_clients WHERE id='$cid'");
            $balances = DB::select("SELECT *  FROM vm_meter_readings WHERE $raw");
        } else {
            $client = DB::select("SELECT * FROM vw_clients WHERE id='1'");
            $balances = DB::select("SELECT * FROM vm_meter_readings WHERE client_id='1'");
        }
        return view('reports.history', compact('areas', 'balances', 'client', 'date', 'cid', 'clients'));
    }

    function sales_revenue(Request $r) {
        $areas = Area::all();

        $report_type = $r->input('report_type');
        $datecriteria = $r->input('datecriteria');
        $dc = $datecriteria;
        $receiptno = $r->input('receiptno');
        $vh = $receiptno;
        $date = $r->input('date');
        $datefrom = $r->input('datefrom');
        $dateto = $r->input('dateto');
        $voteheadselection = $r->input('voteheadselection');
        $vhs = $voteheadselection;

        if ($datecriteria == 'datesingle') {
            $ds = "style=display:block";
            $dr = "style=display:none";
        } else {
            $ds = "style=display:none";
            $dr = "style=display:block";
        }

        if ($report_type == 'votehead') {
            $vs = "style=display:block";
        } else {
            $vs = "style=display:none";
        }

        if ($report_type == 'receipt') {
            $vd = "style=display:block";
        } else {
            $vd = "style=display:none";
        }

        if ($report_type == 'detail') {
            $q = '';
            if ($datecriteria == 'datesingle') {
                $q = " DATE_FORMAT(date,'%Y-%m-%d') = '$date' ";
                $pe = ' FOR ' . \Carbon\Carbon::parse($date)->format('l F dS, Y ');
            } else {
                $q = " DATE_FORMAT(date,'%Y-%m-%d') >= '$datefrom' AND DATE_FORMAT(date,'%Y-%m-%d') <= '$dateto' ";
                $pe = ' BETWEEN ' . \Carbon\Carbon::parse($datefrom)->format('l F dS, Y ') . ' AND ' . \Carbon\Carbon::parse($dateto)->format('l F dS, Y ');
            }
            $result = DB::select("SELECT * FROM vw_payments WHERE $q");
            $totals = DB::select("SELECT mode,SUM(amount) amount FROM vw_payments WHERE $q GROUP BY mode");
            return view('reports.sales_revenue_detail', compact('result', 'totals', 'pe', 'report_type', 'dc', 'ds', 'dr', 'date', 'datefrom', 'dateto', 'vs', 'vh', 'vd', 'vhs'));
        } else if ($report_type == 'summary') {
            $q = '';
            if ($datecriteria == 'datesingle') {
                $q = " DATE_FORMAT(date,'%Y-%m-%d') = '$date' ";
                $pe = ' FOR ' . \Carbon\Carbon::parse($date)->format('l F dS, Y ');
            } else {
                $q = " DATE_FORMAT(date,'%Y-%m-%d') >= '$datefrom' AND DATE_FORMAT(date,'%Y-%m-%d') <= '$dateto' ";
                $pe = ' BETWEEN ' . \Carbon\Carbon::parse($datefrom)->format('l F dS, Y ') . ' AND ' . \Carbon\Carbon::parse($dateto)->format('l F dS, Y ');
            }
            $result = DB::select("SELECT * FROM vw_payments WHERE $q GROUP BY amount ");
            //$totals = DB::select("SELECT mode,SUM(amount) amount FROM vw_payments WHERE $q GROUP BY mode");
            return view('reports.sales_revenue_summary', compact('result', 'pe', 'report_type', 'dc', 'ds', 'dr', 'date', 'datefrom', 'dateto', 'vs', 'vh', 'vd', 'vhs'));
        } else if ($report_type == 'receipt') {
            $receiptno = $r->input('receiptno');
            $receip = DB::select("SELECT * FROM vw_payments WHERE id ='$receiptno'");
            if (count($receip) > 0) {
                return redirect()->to('client-info-receipt/' . $receip[0]->id . '/' . $receip[0]->client_id);
            } else {
                return redirect()->back()->with('error', 'Receipt Number(' . $receiptno . ') is invalid');
            }
        } else if ($report_type == 'votehead') {
            $voteheadselection = $r->input('voteheadselection');
            $q = '';
            if ($voteheadselection == 'ADVANCE PAY') {
                if ($datecriteria == 'datesingle') {
                    $q = " DATE_FORMAT(date,'%Y-%m-%d') = '$date' AND balance > 0";
                    $pe = strtoupper($voteheadselection) . ' FOR ' . \Carbon\Carbon::parse($date)->format('l F dS, Y ');
                } else {
                    $q = " DATE_FORMAT(date,'%Y-%m-%d') >= '$datefrom' AND DATE_FORMAT(date,'%Y-%m-%d') <= '$dateto' AND  balance > 0 ";
                    $pe = strtoupper($voteheadselection) . ' ADVANCE PAY BETWEEM ' . \Carbon\Carbon::parse($datefrom)->format('l F dS, Y ') . ' AND ' . \Carbon\Carbon::parse($dateto)->format('l F dS, Y ');
                }
                $result = DB::select("SELECT * FROM vw_arrears_advance WHERE $q ");
                //$totals = DB::select("SELECT mode,SUM(amount) amount FROM vw_payments WHERE $q GROUP BY mode")
            } else if ($voteheadselection == 'ARREARS') {
                if ($datecriteria == 'datesingle') {
                    $q = " DATE_FORMAT(date,'%Y-%m-%d') = '$date' AND balance < 0";
                    $pe = strtoupper($voteheadselection) . ' FOR ' . \Carbon\Carbon::parse($date)->format('l F dS, Y ');
                } else {
                    $q = " DATE_FORMAT(date,'%Y-%m-%d') >= '$datefrom' AND DATE_FORMAT(date,'%Y-%m-%d') <= '$dateto' AND  balance < 0 ";
                    $pe = strtoupper($voteheadselection) . ' ADVANCE PAY BETWEEM ' . \Carbon\Carbon::parse($datefrom)->format('l F dS, Y ') . ' AND ' . \Carbon\Carbon::parse($dateto)->format('l F dS, Y ');
                }
                $result = DB::select("SELECT * FROM vw_arrears_advance WHERE $q ");
            } else if ($voteheadselection == 'WATER CHARGES') {

                if ($datecriteria == 'datesingle') {
                    $q = " DATE_FORMAT(date,'%Y-%m-%d') = '$date'  AND description LIKE 'WATER%'";
                    $pe = strtoupper($voteheadselection) . ' RECEIPT FOR ' . \Carbon\Carbon::parse($date)->format('l F dS, Y ');
                } else {
                    $q = " DATE_FORMAT(date,'%Y-%m-%d') >= '$datefrom' AND DATE_FORMAT(date,'%Y-%m-%d') <= '$dateto' AND description LIKE 'WATER%'";
                    $pe = strtoupper($voteheadselection) . ' RECEIPT BETWEEM ' . \Carbon\Carbon::parse($datefrom)->format('l F dS, Y ') . ' AND ' . \Carbon\Carbon::parse($dateto)->format('l F dS, Y ');
                }
                $result = DB::select("SELECT * FROM vw_transactions WHERE $q ");
            } else {
                if ($datecriteria == 'datesingle') {
                    $q = " DATE_FORMAT(date,'%Y-%m-%d') = '$date'  AND description LIKE '%$voteheadselection%'";
                    $pe = strtoupper($voteheadselection) . ' RECEIPT FOR ' . \Carbon\Carbon::parse($date)->format('l F dS, Y ');
                } else {
                    $q = " DATE_FORMAT(date,'%Y-%m-%d') >= '$datefrom' AND DATE_FORMAT(date,'%Y-%m-%d') <= '$dateto' AND description LIKE '%$voteheadselection%'";
                    $pe = strtoupper($voteheadselection) . ' RECEIPT BETWEEM ' . \Carbon\Carbon::parse($datefrom)->format('l F dS, Y ') . ' AND ' . \Carbon\Carbon::parse($dateto)->format('l F dS, Y ');
                }
                $result = DB::select("SELECT * FROM vw_payments WHERE $q ");
                //$totals = DB::select("SELECT mode,SUM(amount) amount FROM vw_payments WHERE $q GROUP BY mode");
            }
            return view('reports.votehead', compact('result', 'pe', 'report_type', 'dc', 'ds', 'dr', 'date', 'datefrom', 'dateto', 'vs', 'vh', 'vd', 'vhs'));
        } else {
            $report_type = 'detail';
            $ds = "style=display:block";
            $dr = "style=display:none";
            $dc = 'datesingle';

            $vs = "style=display:none";
            return view('reports.sales_revenue', compact('report_type', 'ds', 'dr', 'dc', 'vd', 'vs'));
        }
    }

    function no_water_debits() {
        $areas1 = @$_GET['area'];
        $area2 = Area::all();
        if (!empty($areas1)) {
            foreach ($areas1 as $a) :
                echo $a;
            endforeach;
        }

        return view('reports.no_water_index', compact('area2'));
    }

    function no_water_debit_post(Request $r) {
        $areas1 = $r->area;
        $str = '';
        $data = [];
        $date = date('Y-m-d');
        $date2 = date('Y-m');
        $area2 = Area::all();
        DB::statement("DROP TABLE  IF EXISTS temp_no_water ; CREATE TABLE temp_no_water SELECT c.id account,c.area_id, c.account_name,IF(t.consumed_units IS NULL,0,t.consumed_units) units,IF(t.consumed_units=0 OR t.consumed_units IS NULL,'100',t.consumed_units * c.rate) invoiced,t.reading_date
                    FROM vw_clients c 
                    LEFT JOIN vm_meter_readings t ON c.id = t.client_id
                    AND DATE_FORMAT(t.reading_date,'%Y-%m-%d') >= CONCAT(LEFT('$date' - INTERVAL 1 MONTH,7),'-23')  AND DATE_FORMAT(t.reading_date,'%Y-%m-%d') <='$date2-23'
                    group by c.id");

        foreach ($areas1 as $a) :
            $areas = Area::find($a);
            $clients = DB::select("SELECT * FROM temp_no_water WHERE area_id='$a' AND reading_date IS NULL ORDER BY account DESC");
            $fidata = ['area' => $areas->name, 'clients' => $clients];
            array_push($data, $fidata);
        endforeach;
        return view('reports.no_water_debits', compact('areas', 'data', 'area2'));
    }

    function reading_sheets() {
        $area = Area::all();
        $data = [];
        $i = 0;
        foreach ($area as $a) :
            $clients = ['area' => $a->name, 'clients' => DB::select(DB::raw("SELECT * FROM vw_clients WHERE area_id='$a->id'"))];
            array_push($data, $clients);
        endforeach;

        return view('reports.readingsheet', compact('data', 'i'));
    }

    function area_report() {
        $period = @$_GET['period'];
        $type = @$_GET['type'];

        $date = date_create($period);
        $period1 = strtoupper(date_format($date, "F-Y"));

        if ($type == 'AREA') {
            $result = DB::select(DB::raw("SELECT a.id,a.name,COUNT(c.id) clients, SUM(mr.consumed_units) units_consumed, (a.rate * SUM(mr.consumed_units)) + (COUNT(mr.consumed_units='0') * 100) invoiced,COUNT(mr.consumed_units='0')  flat_rate
                                        FROM areas a
                                        INNER JOIN clients c ON c.area = a.id
                                        LEFT JOIN vm_meter_readings mr ON a.id = mr.area_id
                                        WHERE mr.reading_date >= DATE_FORMAT( '$period' - INTERVAL 1 MONTH, '%Y-%m-23' ) 
                                        AND  mr.reading_date <= DATE_FORMAT('$period', '%Y-%m-23' )
                                        GROUP BY a.id"));
            //dd($result);
            return view('reports.acreport', compact('period1', 'result', 'period', 'type'));
        } else {

            DB::statement("DROP TABLE  IF EXISTS temp_consumption ; CREATE TABLE temp_consumption SELECT c.id account,c.area_id, c.account_name,IF(t.consumed_units IS NULL,0,t.consumed_units) units,IF(t.consumed_units=0 OR t.consumed_units IS NULL,'100',t.consumed_units * c.rate) invoiced,t.reading_date
                    FROM vw_clients c 
                    LEFT JOIN vm_meter_readings t ON c.id = t.client_id
                    AND DATE_FORMAT(t.reading_date,'%Y-%m-%d') >= CONCAT(LEFT('$period' - INTERVAL 1 MONTH,7),'-23')  AND DATE_FORMAT(t.reading_date,'%Y-%m-%d') <='$period'
                    group by c.id");

            $area = Area::all();
            $data = [];
            $i = 0;
            foreach ($area as $a) :
                $clients = ['area' => $a->name, 'clients' => DB::select(DB::raw("SELECT * FROM temp_consumption WHERE area_id='$a->id'"))];
                array_push($data, $clients);
            endforeach;
            //dd($result);
            return view('reports.screport', compact('period1', 'data', 'period', 'type'));
        }
    }

    function meter_changes() {
        $period = @$_GET['period'];
        $type = @$_GET['type'];

        $clients = Client::all();

        $date = date_create($period);
        $period1 = strtoupper(date_format($date, "F-Y"));
        $period_filter = strtoupper(date_format($date, "Y-m"));

        $result = DB::select("SELECT c.id account,c.account_name,c.area_name,mc.change_date,mc.reading
                        FROM vw_clients c
                        INNER JOIN meter_changes mc ON c.id = mc.client_id
                        WHERE DATE_FORMAT(mc.change_date,'%Y-%m') LIKE '%$period_filter%'");

        //dd($result);
        return view('reports.mchanges', compact('period1', 'result', 'period', 'type', 'clients'));
    }

    function history_report() {
        $period = @$_GET['period'];
        $type = @$_GET['type'];
        $clients = Client::all();
        $single = Client::find($type);
        $date = date_create($period);
        $period1 = strtoupper(date_format($date, "F-Y"));

        $result = DB::select(DB::raw("SELECT * FROM vm_meter_readings WHERE client_id='$type' AND DATE_FORMAT(reading_date,'%Y-%m-%d') <='$period' ORDER BY id ASC"));

        return view('reports.hreport', compact('period1', 'result', 'period', 'type', 'clients', 'single'));
    }

    public function income_expenditure() {
        $from = @$_GET['from'];
        $to = @$_GET['to'];
        $range_in = " DATE_FORMAT(date,'%Y-%m-%d') >= '$from' AND DATE_FORMAT(date,'%Y-%m-%d') <= '$to'";
        $range_ex = " DATE_FORMAT(created_at,'%Y-%m-%d') >= '$from' AND DATE_FORMAT(created_at,'%Y-%m-%d') <= '$to'";

        /* INCOME */
        $arrears = DB::select("SELECT SUM(balance) amount FROM vw_balances WHERE balance > 0");
        $application = DB::select("SELECT SUM(amount) amount FROM vw_transactions  WHERE description LIKE '%Application%'");
        $water_charges = DB::select("SELECT SUM(amount) amount FROM vw_transactions  WHERE description LIKE '%Application%' OR description LIKE '%standing%';");
        $adjustments = DB::select("SELECT SUM(amount) amount FROM vw_transactions  WHERE description LIKE '%Debited%'");
        $miscallenous = DB::select("SELECT SUM(amount) amount FROM vw_transactions  WHERE description LIKE 'ill%' OR description like '%Meter%'");

        /* EXPENSES */
        $expenses = DB::select("SELECT ec.name, SUM(amount) amount
                    FROM expenses e 
                    INNER JOIN expense_categories ec ON e.expense_category_id = ec.id 
                    GROUP BY ec.name");

        // dd($application);

        return view('reports.income_expenditure', compact('from', 'to', 'arrears', 'application', 'water_charges', 'adjustments', 'miscallenous', 'expenses'));
    }
}
