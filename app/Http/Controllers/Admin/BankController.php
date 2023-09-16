<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class BankController
 * @package App\Http\Controllers
 */
class BankController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $banks = Bank::paginate();

        return view('bank.index', compact('banks'))
                        ->with('i', (request()->input('page', 1) - 1) * $banks->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $bank = new Bank();
        return view('bank.create', compact('bank'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        request()->validate(Bank::$rules);

        $bank = Bank::create($request->all());

        return redirect()->route('bank.index')
                        ->with('success', 'Bank created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $bank = Bank::find($id);

        return view('bank.show', compact('bank'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $bank = Bank::find($id);

        return view('bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank, $id) {
        $bank = Bank::find($id);
        request()->validate(Bank::$rules);

        $bank->update($request->all());

        return redirect()->route('bank.index')
                        ->with('success', 'Bank updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $bank = Bank::find($id)->delete();

        return redirect()->route('bank.index')
                        ->with('success', 'Bank deleted successfully');
    }

}
