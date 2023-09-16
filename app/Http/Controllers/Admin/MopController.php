<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class MopController
 * @package App\Http\Controllers
 */
class MopController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $mops = Mop::paginate();

        return view('mop.index', compact('mops'))
                        ->with('i', (request()->input('page', 1) - 1) * $mops->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $mop = new Mop();
        return view('mop.create', compact('mop'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        request()->validate(Mop::$rules);

        $mop = Mop::create($request->all());

        return redirect()->route('mops.index')
                        ->with('success', 'Mode of Payment created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $mop = Mop::find($id);

        return view('mop.show', compact('mop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $mop = Mop::find($id);

        return view('mop.edit', compact('mop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Mop $mop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mop $mop, $id) {
        $mop = Mop::find($id);
        request()->validate(Mop::$rules);
        $mop->update($request->all());

        return redirect()->route('mops.index')
                        ->with('success', 'Mode of payment updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $mop = Mop::find($id)->delete();

        return redirect()->route('mops.index')
                        ->with('success', 'Mode of payment deleted successfully');
    }

}
