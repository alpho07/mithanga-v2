<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

/**
 * Class AreaController
 * @package App\Http\Controllers
 */
class AreaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r) {
        if($r->filled('q')){
           $areas = Area::where('a_type','t')->get();
        }else{
            $areas = Area::where('a_type','b')->get();
        }      
        
        return view('area.index', compact('areas'))->with('i');
    }

    function generateReferral() {
        $user_id = '1';
        $ref_2 =  '/join/' . sha1(date('Y-d-m'));

        DB::insert(DB::raw("INSERT INTO ref_links (client_id,ref_link) VALUE('$user_id','$ref_2')"));

        echo 'Inserted';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $area = new Area();
        return view('area.create', compact('area'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        request()->validate(Area::$rules);

        $area = Area::create($request->all());

        return redirect()->route('areas.index')
                        ->with('success', 'Area created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $area = Area::find($id);

        return view('area.show', compact('area'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $area = Area::find($id);

        return view('area.edit', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Area $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area, $id) {
        $area = Area::find($id);
        request()->validate(Area::$rules);
        $area->fill($request->all())->save();

        return redirect()->route('areas.index')
                        ->with('success', 'Area updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $area = Area::find($id)->delete();

        return redirect()->route('areas.index')
                        ->with('success', 'Area deleted successfully');
    }

    function area_report($period) {
        $date = date_create($period);
        $period1 = strtoupper(date_format($date, "F-Y"));

        $result = DB::select(DB::raw("SELECT a.id,a.name,COUNT(c.id) clients, SUM(mr.consumed_units) units_consumed, (a.rate * SUM(mr.consumed_units)) + (COUNT(mr.consumed_units='0') * 100) invoiced,COUNT(mr.consumed_units='0')  flat_rate
                                        FROM areas a
                                        INNER JOIN clients c ON c.area = a.id
                                        LEFT JOIN vm_meter_readings mr ON a.id = mr.area_id
                                        WHERE mr.reading_date >= DATE_FORMAT( '$period' - INTERVAL 1 MONTH, '%Y-%m-23' ) 
                                        AND  mr.reading_date <= DATE_FORMAT('$period', '%Y-%m-23' )
                                        GROUP BY a.id"));
        //dd($result);
        return view('area.report', compact('period1', 'result', 'period'));
    }

}
