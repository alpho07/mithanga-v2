<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

/**
 * Class StatusController
 * @package App\Http\Controllers
 */
class StatusController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $statuses = Status::paginate();

        return view('status.index', compact('statuses'))
                        ->with('i', (request()->input('page', 1) - 1) * $statuses->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $status = new Status();
        return view('status.create', compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        request()->validate(Status::$rules);

        $status = Status::create($request->all());

        return redirect()->route('status.index')
                        ->with('success', 'Status created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $status = Status::find($id);

        return view('status.show', compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $status = Status::find($id);

        return view('status.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Status $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status, $id) {
        $status = Status::find($id);
        request()->validate(Status::$rules);

        $status->update($request->all());

        return redirect()->route('status.index')
                        ->with('success', 'Status updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $status = Status::find($id)->delete();

        return redirect()->route('status.index')
                        ->with('success', 'Status deleted successfully');
    }

}
