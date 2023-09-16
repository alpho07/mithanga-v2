<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CostCenter;
use Illuminate\Http\Request;

/**
 * Class CostCenterController
 * @package App\Http\Controllers
 */
class CostCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $costCenters = CostCenter::paginate();

        return view('cost-center.index', compact('costCenters'))
            ->with('i', (request()->input('page', 1) - 1) * $costCenters->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $costCenter = new CostCenter();
        return view('cost-center.create', compact('costCenter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(CostCenter::$rules);

        $costCenter = CostCenter::create($request->all());

        return redirect()->route('cost-centers.index')
            ->with('success', 'CostCenter created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $costCenter = CostCenter::find($id);

        return view('cost-center.show', compact('costCenter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $costCenter = CostCenter::find($id);

        return view('cost-center.edit', compact('costCenter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  CostCenter $costCenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CostCenter $costCenter, $id)
    {
        $costCenter = CostCenter::find($id);
        request()->validate(CostCenter::$rules);

        $costCenter->update($request->all());

        return redirect()->route('cost-centers.index')
            ->with('success', 'CostCenter updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $costCenter = CostCenter::find($id)->delete();

        return redirect()->route('cost-centers.index')
            ->with('success', 'CostCenter deleted successfully');
    }
}
