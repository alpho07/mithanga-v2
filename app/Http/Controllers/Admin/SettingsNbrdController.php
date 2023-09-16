<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SettingsNbrd;

/**
 * Class SettingsNbrdController
 * @package App\Http\Controllers
 */
class SettingsNbrdController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $settingsNbrds = SettingsNbrd::paginate();

        return view('settings-nbrd.index', compact('settingsNbrds'))
                        ->with('i', (request()->input('page', 1) - 1) * $settingsNbrds->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $settingsNbrd = new SettingsNbrd();
        return view('settings-nbrd.create', compact('settingsNbrd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        request()->validate(SettingsNbrd::$rules);

        $settingsNbrd = SettingsNbrd::create($request->all());

        return redirect()->route('settings_nbrd.index')
                        ->with('success', 'SettingsNbrd created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $settingsNbrd = SettingsNbrd::find($id);

        return view('settings-nbrd.show', compact('settingsNbrd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $settingsNbrd = SettingsNbrd::find($id);

        return view('settings-nbrd.edit', compact('settingsNbrd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  SettingsNbrd $settingsNbrd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SettingsNbrd $settingsNbrd) {
        request()->validate(SettingsNbrd::$rules);

        $settingsNbrd->update($request->all());

        return redirect()->route('settings_nbrd.index')
                        ->with('success', 'SettingsNbrd updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $settingsNbrd = SettingsNbrd::find($id)->delete();

        return redirect()->route('settings_nbrd.index')
                        ->with('success', 'SettingsNbrd deleted successfully');
    }

}
