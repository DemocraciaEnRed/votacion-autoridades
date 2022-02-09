<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditHomeRequest;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function __construct () {
        $this->middleware('permission:ver home,backend', ['only' => ['index', 'show', 'edit']]);
        $this->middleware('permission:editar home,backend', ['only' => ['update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $home = Home::first();

        if(empty($home)) {

            $home = Home::create([

            ]);
        }

        return $this->edit($home);
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
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function show(Home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function edit(Home $home)
    {
        return view('backend.homes.edit')->with([
            'element' => $home,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function update(EditHomeRequest $request, Home $home)
    {
        $home->extra_information = $request->input('extra_information');
        $home->filename = $request->input('filename');
        if($request->hasFile('file')) {
            $path = $request->file('file')->store('img/home', 'public_uploads');
            $home->file = $path;
        }

        if ($home->save()) {

            return Redirect::action('\App\Http\Controllers\Backend\HomeController@edit', [$home])->withAlert([
                'title' => 'Éxito',
                'text' => 'Home actualizada',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\HomeController@edit', [$home])->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function destroy(Home $home)
    {
        //
    }
}
