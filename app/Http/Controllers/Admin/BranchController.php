<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class BranchController
 * @package App\Http\Controllers
 */
class BranchController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bank='', $name='') {
        if (request()->filled('bank')) {
            $bank = request()->bank;
            $name = request()->name;
        }
        $branches = Branch::where('bank_id', $bank)->get();
        return view('branch.index', compact('branches', 'name', 'bank'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($bank, $name) {
        $branch = new Branch();
        return view('branch.create', compact('branch', 'bank', 'name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $bank, $name) {
        request()->validate(Branch::$rules);

        $branch = Branch::create($request->all());

        return redirect()->route('branch.index', ['bank' => $bank, 'name' => $name])
                        ->with('success', 'Branch created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $branch = Branch::find($id);

        return view('branch.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $bank, $name) {
        $branch = Branch::find($id);

        return view('branch.edit', compact('branch', 'bank', 'name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch, $id, $bank, $name) {
        $branch = Branch::find($id);
        request()->validate(Branch::$rules);

        $branch->update($request->all());

        return redirect()->route('branch.index', ['bank' => $bank, 'name' => $name])
                        ->with('success', 'Branch updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id, $bank, $name) {
        $branch = Branch::find($id)->delete();

        return redirect()->route('branch.index', ['bank' => $bank, 'name' => $name])
                        ->with('success', 'Branch deleted successfully');
    }

}
