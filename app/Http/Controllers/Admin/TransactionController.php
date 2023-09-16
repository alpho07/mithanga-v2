<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use DB;
use PDF;
use Session;
use Illuminate\Support\Facades\Cache;

/**
 * Class TransactionController
 * @package App\Http\Controllers
 */
class TransactionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $transactions = DB::select(DB::raw("SELECT * From vw_bills_bills order by date,id desc LIMIT 250"));
        $i = 1;
        return view('transaction.index', compact('transactions', 'i'));
    }

    public function disconnected() {
        $transactions = DB::select(DB::raw("SELECT * From vm_meter_readings WHERE discon='d' order by id desc"));
        $i = 1;
        return view('transaction.index_disconnected', compact('transactions', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $transaction = new Transaction();
        $clients = DB::select("SELECT * FROM vw_clients");
        return view('transaction.create', compact('clients', 'transaction'));
    }

    public function statement($start, $end) {
        $clients = Cache::remember('users', 86400, function () {
                    return DB::select("SELECT * FROM vw_clients order by id ASC");
                });

        $from = $start;
        $to = $end;
        return view('statement.index', compact('clients', 'from', 'to'));
    }

    function get(Request $r) {
        $client_id = $r->client_id;
        $from = $r->from;
        $to = $r->to;
        Session::put('pdf_client_id', $client_id);
        Session::put('pdf_from', $from);
        Session::put('pdf_to', $to);

        $clients = Cache::remember('users', 86400, function () {
                    return DB::select("SELECT * FROM vw_clients order by id ASC");
                });

        $clients_narrowed = DB::select("SELECT * FROM vw_clients where id='$client_id'");
        $debit_amount = '';
        $credit_amount = '';
        $account_balance = '';
        $account_balance_ = [];
        $opening_balance = 0;
        //$deb1 = DB::select(DB::raw("SELECT SUM(amount) balance,client_id FROM vw_transactions WHERE date < '$from' AND client_id='$client_id' AND type='debit' GROUP BY client_id")); 
        $deb1 = DB::select(DB::raw("SELECT SUM(IF(type='debit',amount,-amount)) balance,client_id FROM transactions WHERE date < '$from' AND client_id='$client_id' GROUP BY client_id"));
        //$cred1 = DB::select(DB::raw("SELECT SUM(amount) balance,client_id FROM vw_transactions WHERE date < '$from' AND client_id='$client_id' AND type='credit' GROUP BY client_id")); 
        if (count($deb1) <= 0) {
            $opening_balance = 0;
        } else {
            $bal = $deb1[0]->balance;
            if (isset($bal)) {
                $opening_balance = $bal;
            } else {
                $opening_balance = 0;
            }
        }
        $statement = DB::select("SELECT *,DATE_FORMAT(date,'%d-%M-%Y') transaction_date FROM vw_transactions WHERE client_id='$client_id' AND DATE(date) >= '$from' AND DATE(date) <= '$to'   ORDER BY date asc");
        return view('statement.getstatement', compact('clients', 'statement', 'debit_amount', 'credit_amount', 'opening_balance', 'account_balance', 'from', 'to', 'client_id', 'clients_narrowed'));
    }

    // Generate PDF
    public function createPDF() {
        // retreive all records from db
        $client_id = Session::get('pdf_client_id');
        $from = Session::get('pdf_from');
        $to = Session::get('pdf_to');
        $clients = DB::select("SELECT * FROM vw_clients order by id ASC");
        $clients_narrowed = DB::select("SELECT * FROM vw_clients where id='$client_id'");
        $debit_amount = '';
        $credit_amount = '';
        $account_balance = '';
        $account_balance_ = [];
        $opening_balance_ = DB::select(DB::raw("SELECT SUM(IF(type='debit',-amount,amount)) balance,client_id FROM transactions WHERE date <= '$from' AND client_id='$client_id' GROUP BY client_id"));
        if (isset($opening_balance_[0]->balance)) {
            $opening_balance = $opening_balance_[0]->balance;
        } else {
            $opening_balance = 0;
        }
        $statement = DB::select("SELECT *,DATE_FORMAT(date,'%d-%M-%Y') transaction_date FROM vw_transactions WHERE client_id='$client_id' AND DATE(date) >= '$from' AND DATE(date) <= '$to'   ORDER BY id asc");
        //return view('statement.getstatement', compact('clients', 'statement', 'debit_amount', 'credit_amount', 'opening_balance', 'account_balance', 'from', 'to', 'client_id', 'clients_narrowed'));
        // share data to view
        //view()->share('statement.getstatement', compact('clients', 'statement', 'debit_amount', 'credit_amount', 'opening_balance', 'account_balance', 'from', 'to', 'client_id', 'clients_narrowed'));
        $pdf = PDF::loadView('statement.printstatement', compact('clients', 'statement', 'debit_amount', 'credit_amount', 'opening_balance', 'account_balance', 'from', 'to', 'client_id', 'clients_narrowed'));

        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
        // dd($pdf);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        request()->validate(Transaction::$rules);

        $transaction = Transaction::create($request->all());

        return redirect()->route('billing.index')
                        ->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $transaction = Transaction::find($id);

        return view('transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $transaction = Transaction::find($id);

        return view('transaction.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction) {
        request()->validate(Transaction::$rules);

        $transaction->update($request->all());

        return redirect()->route('bill.index')
                        ->with('success', 'Transaction updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $transaction = Transaction::find($id)->delete();

        return redirect()->route('bill.index')
                        ->with('success', 'Transaction deleted successfully');
    }

    function receipt() {
        return view('transaction.receipt');
    }

}
