<?php

namespace App\Http\Middleware;

use App\Models\Vote;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class VotationInCourse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $vote = Vote::find(1);

        if($vote->state_id != 2) {
            return Response::json([
                'message' => 'Votation is not in course',
            ], 404);
        }

        return $next($request);
    }
}
