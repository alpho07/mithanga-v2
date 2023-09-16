<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\MpesaTransaction;
use App\Models\Transaction;
use App\Models\Mop;
use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;
use DB;

/**
 * Class TransactionController
 * @package App\Http\Controllers
 */
class PaymentController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paybills(Request $r) {
        $q = '';
        if ($r->filled('q')) {
            $q = '?q=tenants';
            $transactions = MpesaTransaction::where('stray_status', 1)
                    ->where('BillRefNumber', 'LIKE', '%pva%')
                    ->orderBy('id', 'desc')
                    ->paginate(20);
        } else {
            $transactions = MpesaTransaction::where('stray_status', 1)
                    ->where('BillRefNumber', 'NOT LIKE', '%pva%')
                    ->orderBy('id', 'desc')
                    ->paginate(20);
        }

        $i = 1;

        return view('payment.mpesa', compact('transactions', 'i', 'q'));
    }

    public function paybills_stray(Request $r) {
        $q = '';
        if ($r->filled('q')) {
            $q = '?q=tenants';
            $transactions = MpesaTransaction::where('stray_status', 0)
                    ->where('BillRefNumber', 'LIKE', '%pva%')
                    ->orderBy('id', 'desc')
                    ->paginate(20);
        } else {

            $transactions = MpesaTransaction::where('stray_status', 0)
                    ->where('BillRefNumber', 'NOT LIKE', '%pva%')
                    ->orderBy('id', 'desc')
                    ->paginate(20);
        }
        $i = 1;

        return view('payment.mpesa_stray', compact('transactions', 'i', 'q'));
    }

    function sendBalance($client_id, $amount) {
        if (strpos(\strtolower($client_id), 'pva') !== false) {
            $reading2 = DB::table('vw_balances')->where('id', $client_id)->latest('id')->first();

            $main_message = 'Dear ' . $reading2->account_name . "\n" .
                    'Your payment of KES. ' . number_format($amount, 2) . ' has been received and updated ' . "\n" .
                    'Your current ARREARS is ksh. ' . number_format(abs($reading2->balance), 2) . '/-' . "\n" .
                    'Pay via MPESA Only:' . "\n" .
                    'Paybill no: 4085189' . "\n" .
                    'Account number: ' . $client_id . "\n" .
                    'POSTVIEW APARTMENTS.' . "\n" .
                    'James 0723653255.' . "\n" .
                    'Thank you!.';
        } else {
            $reading2 = DB::table('vw_balances')->where('meter_number', $client_id)->latest('id')->first();

            $main_message = 'Dear ' . $reading2->account_name . "\n" .
                    'Your payment of KES. ' . number_format($amount, 2) . ' has been received and updated ' . "\n" .
                    'Your current ARREARS is ksh. ' . number_format(abs($reading2->balance), 2) . '/-' . "\n" .
                    'Pay via MPESA Only:' . "\n" .
                    'Paybill no: 4085189' . "\n" .
                    'Account number: ' . $client_id . "\n" .
                    'POSTVIEW APARTMENTS.' . "\n" .
                    'James 0723653255.' . "\n" .
                    'Thank you!.';
        }

        $username = 'postviewhse'; // use 'sandbox' for development in the test environment
        $apiKey = '9e3ce58521f32e559a13a038082ef5fd9c8f02c2db155bb737823db56309caee'; // use your sandbox app API key for development in the test environment
        //$username = 'boreholeh2o';
        //$apiKey = '4613d345882869887031e7091f828fe3dd848a7b6cb68035fd788c5dc4ecc56e';

        $AT = new AfricasTalking($username, $apiKey);

        // Get one of the services
        $sms = $AT->sms();
        //$new = substr('0715882227', 1);
        //$recipients = DB::table('demo_phone')->latest('id')->first()->phone; // . $new;
        // Use the service
        $result = $sms->send([
            'to' => $reading2->phone_no,
            'message' => $main_message,
            'from' => 'POSTVIEW'
        ]);

        return $result;
    }

    public function search(Request $request) {
        $search = $request->input('search');

        $transactions = MpesaTransaction::where('TransID', 'like', "%$search%")
                ->orWhere('TransactionType', 'like', "%$search%")
                ->paginate(10); // Paginate with 10 items per page

        return view('payment.mpesa', compact('transactions'));
    }

    function getClients() {
        $clients = DB::select("SELECT id, CONCAT(id,' - ', account_name) name FROM clients ORDER BY id ASC");
        return $clients;
    }

    function save_payment_modified(Request $r) {
        $account_name = $r->accountName;
        $new_account = $r->new_account;
        $amount = $r->amount;
        $account = $r->accountNumber;
        $trans_code = $r->transcode;
        $date = date('Y-m-d H:i:s');

        DB::table('mpesa_transactions')->where('TransID', $trans_code)->update([
            'BillRefNumber' => $account . ' -> ' . $new_account,
            'stray_status' => 1
        ]);

        DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,reference,comments) VALUES ('$new_account','Bill payment(stray) redirected to correct account','$date','credit','$amount','$trans_code','$account_name')");

        return redirect()->route('mobile_transactions.stray')->with('success', 'Stray payment successfully redirected to correct account');
    }

    public function index() {
        $transactions = DB::select(DB::raw("SELECT * From vw_payments order by id desc"));
        $i = 1;
        return view('payment.index', compact('transactions', 'i'));
    }

    public function invoice() {
        $invoices = DB::select(DB::raw("SELECT * From vw_invoices order by id desc"));
        $payments = DB::select(DB::raw("SELECT * From vw_payment order by id desc"));
        $i = 1;
        $mop = Mop::all();
        $banks = \App\Models\Bank::all();
        return view('payment.invoice', compact('invoices', 'i', 'mop', 'banks', 'payments'));
    }

    function loadPaymentDetails($ref) {
        return DB::select(DB::raw("SELECT * From vw_payment WHERE reference='$ref' order by id desc"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_invoice() {
        $supplier = \App\Models\Supplier::all();
        $cost_center = \App\Models\CostCenter::all();
        return view('payment.create_invoice', compact('supplier', 'cost_center'));
    }

    public function create() {
        $transaction = new Payment();
        $mop = Mop::all();
        $banks = \App\Models\Bank::all();
        $clients = DB::select("SELECT * FROM vw_clients order by id asc");
        return view('payment.create', compact('clients', 'transaction', 'mop', 'banks'));
    }

    public function adjust() {
        $transaction = new Payment();
        $mop = Mop::all();
        $banks = \App\Models\Bank::all();
        $clients = DB::select("SELECT * FROM vw_clients order by id asc");
        return view('payment.create_adj', compact('clients', 'transaction', 'mop', 'banks'));
    }

    function saveAdjustments(Request $r) {
        $reason = $r->adjustment_type == 'debit' ? 'Account Debited' : 'Account Cedited';
        $ref = date('YmdHis') . '-' . $r->adjustment_type;
        $tadate = date('Y-m-d H:i:s');
        DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,reference,comments) VALUES ('$r->client_id','$reason','$tadate','$r->adjustment_type','$r->amount','$ref','$r->comment')");
        return redirect()->route('payment.index')->with('success', 'Payment Successfully Adjustent On Account Successful');
    }

    function saveInvoice(Request $r) {
        $date = date('Y-m-d H:i:s');
        $total = 0;
        for ($i = 0; $i < count($r->cost_center); $i++) {
            $cs = $r->cost_center[$i];
            $amount = $r->amount_invoiced[$i];
            DB::insert("INSERT INTO invoice_details (item,reference,amount) VALUES ('$cs','$r->reference','$amount')");
            $total = $total + $r->amount_invoiced[$i];
        }
        DB::insert("INSERT INTO invoices (supplier,cost_center,reference,amount_invoiced,remarks,date) VALUES ('$r->supplier','-','$r->reference','$total','$r->remarks','$date')");

        return redirect()->route('invoicing.index')->with('success', 'Invoice Successfully Created');
    }

    function saveInvoicePayment(Request $r) {
        $date = date('Y-m-d H:i:s');
        DB::update("UPDATE invoices SET paid=paid+$r->amount WHERE reference='$r->reference'");
        DB::insert("INSERT INTO payment (reference,bank,mode,amount,date_paid) VALUES ('$r->reference','$r->bank','$r->mode','$r->amount','$date')");
        return redirect()->route('invoicing.index')->with('success', 'Invoice Payment Successfull');
    }

    function deleteInvoiceMicro($id, $reference) {
        $amount = DB::select("SELECT amount FROM payment WHERE id='$id'")[0]->amount;
        //DB::update("UPDATE invoices SET amount_invoiced=amount_invoiced + $amount WHERE reference='$reference'");
        DB::update("UPDATE invoices SET paid=paid - $amount WHERE reference='$reference'");
        DB::delete("DELETE FROM payment WHERE id='$id'");
        return ['message' => 'Deleted'];
    }

    public function showInvoice($cid, $ref) {
        $i = 0;
        $supplier = DB::select(DB::raw("SELECT * FROM suppliers WHERE id='$cid'"));
        $invoice = DB::select(DB::raw("SELECT * FROM invoices WHERE reference='$ref'"));
        $details = DB::select(DB::raw("SELECT * FROM vw_invdetails WHERE reference='$ref'"));
        return view('payment.index_show', compact('details', 'invoice', 'supplier', 'ref', 'i'));
    }

    public function editInvoice($cid, $ref) {

        $suppliers = \App\Models\Supplier::all();
        $cost_center = \App\Models\CostCenter::all();
        $supplier = DB::select(DB::raw("SELECT * FROM suppliers WHERE id='$cid'"));
        $invoice = DB::select(DB::raw("SELECT * FROM vw_invoices WHERE reference='$ref'"));
        $details = DB::select(DB::raw("SELECT * FROM vw_invdetails WHERE reference='$ref'"));
        return view('payment.edit_invoice', compact('details', 'invoice', 'supplier', 'cid', 'ref', 'cost_center', 'suppliers'));
    }

    function saveInvoiceEdit(Request $r, $cid, $ref) {
        DB::delete("DELETE FROM invoices WHERE reference='$ref'");
        DB::delete("DELETE FROM invoice_details WHERE reference='$ref'");
        $date = date('Y-m-d H:i:s');
        $total = 0;
        for ($i = 0; $i < count($r->cost_center); $i++) {
            $cs = $r->cost_center[$i];
            $amount = $r->amount_invoiced[$i];
            DB::insert("INSERT INTO invoice_details (item,reference,amount) VALUES ('$cs','$r->reference','$amount')");
            $total = $total + $r->amount_invoiced[$i];
        }
        DB::insert("INSERT INTO invoices (supplier,cost_center,reference,amount_invoiced,remarks,date) VALUES ('$r->supplier','-','$r->reference','$total','$r->remarks','$date')");

        return redirect()->route('invoicing.edit', ['cid' => $cid, 'ref' => $ref])->with('success', 'Invoice Successfully Edited');
    }

    function deleteInvoice($ref) {
        DB::delete("DELETE FROM invoices WHERE reference='$ref'");
        DB::delete("DELETE FROM invoice_details WHERE reference='$ref'");
        return redirect()->route('invoicing.index')->with('success', 'Invoice Successfully Deleted');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //dd($request->all());
        $check = $clientid = $request->client_id;
        $amount = $request->amount;
        $date = date('YmdHis');
        $date1 = date('Y-m-d H:i:s');

        $client = @$request->client_id;
        $mop = @$request->mop;

        request()->validate(Transaction::$rules);
        $transaction = Transaction::create($request->all());

        $pid = DB::select("SELECT MAX(id) id FROM transactions ")[0]->id;

        $last_credit = DB::select("SELECT * FROM transactions WHERE client_id='$clientid' AND type NOT IN('credit') AND dnp='0' ORDER BY id ASC");

        foreach ($last_credit as $c):
            $desc = $c->description;
            $amount1 = $c->amount;
            DB::insert("INSERT INTO  receipt_details (items,amount,datetime,trans_id) VALUES('$desc','$amount1','$date1','$pid')");
        endforeach;
        DB::update("UPDATE transactions  SET dnp='1' WHERE client_id = '$clientid'");
        //$update_id = @$last_credit[0]->id;

        return redirect()->route('client.receipt', ['pid' => $pid, 'client_id' => $client])
                        ->with('success', 'Payment Successfully Saved');
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

    function loadClientInformation($pid, $clent_id) {
        $transaction = DB::table('vw_payments')->where('client_id', $clent_id)->where('id', $pid)->get();
        $due = DB::table('vw_balances')->where('client_id', $clent_id)->get();
        return ['transactions' => $transaction, 'due' => $due];
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

    function loadBranches($bank) {
        return \App\Models\Branch::where('bank_id', $bank)->get();
    }

    function receipt() {
        return view('transaction.receipt');
    }
}
