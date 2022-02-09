<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadUserPhotoRequest;
use App\Models\UserPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserPhotoController extends Controller
{
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
     * @param  \App\Models\UserPhoto  $userPhoto
     * @return \Illuminate\Http\Response
     */
    public function show(UserPhoto $userPhoto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserPhoto  $userPhoto
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPhoto $userPhoto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserPhoto  $userPhoto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserPhoto $userPhoto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserPhoto  $userPhoto
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPhoto $userPhoto)
    {
        if($userPhoto->delete()) {
            return Response::json([
                'message' => 'Photo deleted with success',
            ]);
        }

        return Response::json([
            'message' => 'Error for delete',
        ], 500);
    }

    public function upload (UploadUserPhotoRequest $request) {
        $paths = [];

        foreach($request->file('photos') as $photo) {

            // $imageIntervention = Image::make($image);
            // $imageIntervention->resize(600, 600);

            // $uploadPath = 'uploads';
            // $pathFile = 'img/user_photos/'.$image->hashName();
            // $imageIntervention->save(public_path($uploadPath.'/'.$pathFile));

            // $paths[] = $pathFile;

            $paths[] = $photo->store('img/user_photos', 'public_uploads');

        }

        return Response::json($paths);
    }
}
