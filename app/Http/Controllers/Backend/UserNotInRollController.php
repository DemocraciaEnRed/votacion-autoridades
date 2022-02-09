<?php

namespace App\Http\Controllers\Backend;

use App\Exports\UserNotInRollExport;
use App\Http\Controllers\Controller;
use App\Models\UserNotInRoll;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserNotInRollController extends Controller
{
    public function __construct () {
        $this->middleware('permission:exportar personas no censadas,backend', ['only' => ['export']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\UserNotInRoll  $userNotInRoll
     * @return \Illuminate\Http\Response
     */
    public function show(UserNotInRoll $userNotInRoll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserNotInRoll  $userNotInRoll
     * @return \Illuminate\Http\Response
     */
    public function edit(UserNotInRoll $userNotInRoll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserNotInRoll  $userNotInRoll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserNotInRoll $userNotInRoll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserNotInRoll  $userNotInRoll
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserNotInRoll $userNotInRoll)
    {
        //
    }

    public function export () {
        $userNotInRolls = UserNotInRoll::all();

        return Excel::download(new UserNotInRollExport($userNotInRolls), 'Users not in roll.xlsx');
    }
}
