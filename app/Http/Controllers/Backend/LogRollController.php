<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LogRoll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LogRollController extends Controller
{
    public function __construct () {
        $this->middleware('permission:ver logs padrones,backend', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $elements = LogRoll::latest()
                ->with([
                    'roll' => function($query) {
                        $query->withTrashed();
                    }
                ])
                ->get();

            return Datatables::of($elements)
                ->addColumn('date', function(LogRoll $logRoll) {

                    return '<span style="display: none">'.Carbon::parse($logRoll->created_at)->setTimezone('America/Bogota')->format('YmdHis').'</span>
                                        '.Carbon::parse($logRoll->created_at)->setTimezone('America/Bogota')->format('d/m/Y H:i');
                })
                ->editColumn('action_log', function(LogRoll $logRoll) {
                    return $logRoll->action;
                })
                ->editColumn('administrator', function(LogRoll $logRoll) {
                    return $logRoll->administrator->name;
                })
                ->editColumn('previous_name', function(LogRoll $logRoll) {
                    return $logRoll->previous_name;
                })
                ->editColumn('previous_last_name', function(LogRoll $logRoll) {
                    return $logRoll->previous_last_name;
                })
                ->editColumn('previous_dni', function(LogRoll $logRoll) {
                    return $logRoll->previous_dni;
                })
                ->editColumn('name', function(LogRoll $logRoll) {
                    return $logRoll->name;
                })
                ->editColumn('last_name', function(LogRoll $logRoll) {
                    return $logRoll->last_name;
                })
                ->editColumn('dni', function(LogRoll $logRoll) {
                    return $logRoll->dni;
                })
                ->addColumn('action', function(LogRoll $logRoll) {

                    $editBtn = '<a href="'. action('\App\Http\Controllers\Backend\RollController@edit', $logRoll->roll) .'" class="edit btn btn-success btn-sm">Ver censo</a>';
//                    $deleteBtn = '<form method="POST" action="'.action('\App\Http\Controllers\Backend\RollController@destroy',
//                            $roll).'">'.csrf_field().'<input type="hidden" name="_method" value="DELETE"><button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want delete this roll?\')">Delete</button></form>';

                    $action = $editBtn;

                    return $action;
                })
                ->rawColumns(['date', 'action'])
                ->make(true);
        }

        return view('backend.log_rolls.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LogRoll  $logRoll
     * @return \Illuminate\Http\Response
     */
    public function show(LogRoll $logRoll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LogRoll  $logRoll
     * @return \Illuminate\Http\Response
     */
    public function edit(LogRoll $logRoll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LogRoll  $logRoll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogRoll $logRoll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogRoll  $logRoll
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogRoll $logRoll)
    {
        //
    }
}
