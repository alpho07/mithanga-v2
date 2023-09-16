<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SettingsDpm;

/**
 * Class SettingsDpmController
 * @package App\Http\Controllers
 */
class SettingsDpmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settingsDpms = SettingsDpm::paginate();

        return view('settings-dpm.index', compact('settingsDpms'))
            ->with('i', (request()->input('page', 1) - 1) * $settingsDpms->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settingsDpm = new SettingsDpm();
        return view('settings-dpm.create', compact('settingsDpm'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(SettingsDpm::$rules);

        $settingsDpm = SettingsDpm::create($request->all());

        return redirect()->route('settings_dpm.index')
            ->with('success', 'SettingsDpm created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $settingsDpm = SettingsDpm::find($id);

        return view('settings-dpm.show', compact('settingsDpm'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $settingsDpm = SettingsDpm::find($id);

        return view('settings-dpm.edit', compact('settingsDpm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  SettingsDpm $settingsDpm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SettingsDpm $settingsDpm, $id)
    {
        $settingsDpm = SettingsDpm::find($id);
        request()->validate(SettingsDpm::$rules);

        $settingsDpm->update($request->all());

        return redirect()->route('settings_dpm.index')
            ->with('success', 'SettingsDpm updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $settingsDpm = SettingsDpm::find($id)->delete();

        return redirect()->route('settings_dpm.index')
            ->with('success', 'SettingsDpm deleted successfully');
    }
}
