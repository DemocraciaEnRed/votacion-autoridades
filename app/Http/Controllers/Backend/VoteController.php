<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditVoteRequest;
use App\Models\User;
use App\Models\Vote;
use App\Models\VoteState;
use App\Notifications\ResultsReady;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VoteController extends Controller
{
    /** HELPER FUNCTIONS */

    public function getStatesSelect() {
        $return = [];
        $states = VoteState::orderBy('order', 'asc')
            ->get();

        foreach($states as $state) {
            $return[$state->id] = $state->name;
        }

        return $return;
    }

    /** END HELPER FUNCTIONS */

    public function __construct () {
        $this->middleware('permission:ver estado de votacion,backend', ['only' => ['index']]);
        $this->middleware('permission:ver estado de votacion,backend', ['only' => ['show']]);
        $this->middleware('permission:ver estado de votacion,backend', ['only' => ['edit']]);
        $this->middleware('permission:editar estado de votacion,backend', ['only' => ['update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vote = Vote::first();

        if(empty($vote)) {
            $vote = Vote::create([

            ]);
        }

        return $this->edit($vote);
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
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function show(Vote $vote)
    {
        return $this->edit($vote);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function edit(Vote $vote)
    {
        return view('backend.votes.edit')->with([
            'states' => $this->getStatesSelect(),
            'element' => $vote,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function update(EditVoteRequest $request, Vote $vote)
    {
        $vote->state_id = $request->input('state_id');
        $vote->day_start = $request->input('day_start');
        $vote->day_finish = $request->input('day_finish');
        $vote->day_close_inscriptions = $request->input('day_close_inscriptions');

        if ($vote->save()) {

            return Redirect::action('\App\Http\Controllers\Backend\VoteController@edit', [$vote])->withAlert([
                'title' => 'Éxito',
                'text' => 'Votación actualizada',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\VoteController@edit', [$vote])->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vote $vote)
    {
        //
    }

    public function sendMailResults (Vote $vote) {

        $users = User::where('active', 1)
            ->get();

        foreach($users as $user) {
            $user->notify(new ResultsReady($user));
        }

        $vote->mail_results_sended = 1;
        $vote->save();
        
        return Redirect::action('\App\Http\Controllers\Backend\VoteController@edit', [$vote])->withAlert([
            'title' => 'Éxito',
            'text' => 'Emails enviados con éxito',
            'icon' => 'success',
            'confirm_button_text' => 'Cerrar'
        ]);
    }
}
