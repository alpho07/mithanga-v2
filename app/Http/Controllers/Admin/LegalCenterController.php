<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalCenter;
use App\Models\Mop;
use App\Models\Bank;
use Illuminate\Http\Request;
use DB;

/**
 * Class LegalCenterController
 * @package App\Http\Controllers
 */
class LegalCenterController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $legalCenters = LegalCenter::paginate();

        return view('legal-center.index', compact('legalCenters'))
                        ->with('i', (request()->input('page', 1) - 1) * $legalCenters->perPage());
    }

    function legal() {
        $transactions = DB::select(DB::raw("SELECT * From vw_legalcenter order by id desc"));
        $i = 1;
        return view('legal-center.legal', compact('transactions', 'i'));
    }

    public function new() {
        $transaction = [];
        $legal = LegalCenter::all();
        $banks = \App\Models\Bank::all();
        $clients = DB::select("SELECT * FROM vw_clients order by id asc");
        return view('legal-center.createlegal', compact('clients', 'legal', 'transaction', 'banks'));
    }

    function saveLegalCost(Request $r) {
        $tadate = date('Y-m-d H:i:s');
        DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,reference,comments,lc) VALUES ('$r->client_id','$r->description','$tadate','debit','$r->amount','$tadate','$r->legal_remarks','1')");
        return redirect()->route('legal.index')->with('success', 'Legal Cost Added');
    }

    function legalDelete($id) {
        DB::delete("DELETE FROM transactions WHERE id='$id'");
        return redirect()->route('legal.index')->with('success', 'Legal Cost Removed');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $legalCenter = new LegalCenter();
        return view('legal-center.create', compact('legalCenter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        request()->validate(LegalCenter::$rules);

        $legalCenter = LegalCenter::create($request->all());

        return redirect()->route('legal-centers.index')
                        ->with('success', 'LegalCenter created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $legalCenter = LegalCenter::find($id);

        return view('legal-center.show', compact('legalCenter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $legalCenter = LegalCenter::find($id);

        return view('legal-center.edit', compact('legalCenter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  LegalCenter $legalCenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LegalCenter $legalCenter, $id) {
        $legalCenter = LegalCenter::find($id);
        request()->validate(LegalCenter::$rules);

        $legalCenter->update($request->all());

        return redirect()->route('legal-centers.index')
                        ->with('success', 'LegalCenter updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $legalCenter = LegalCenter::find($id)->delete();

        return redirect()->route('legal-centers.index')
                        ->with('success', 'LegalCenter deleted successfully');
    }

}
