<?php

namespace App\Http\Controllers;

use App\Developers;
use Illuminate\Http\Request;

class DevelopersController extends Controller
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
        $dev = new Developers();
        $dev->first_name = $request->fname;
        $dev->last_name = $request->lname;
        $dev->email = $request->email;
        $dev->phone_num = $request->phone;
        $dev->address = $request->address;
        //$dev->model = $request->model;

        // for avatar
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $imageName = $request->image->getClientOriginalName();
            Storage::disk('public')->put('images/'.$imageName, file_get_contents($image));

            // save avatar image into database
            $dev->avatar = $imageName;
        }

        $dev->save();

        //return $dev;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Developers  $developers
     * @return \Illuminate\Http\Response
     */
    public function show(Developers $developers)
    {
        $data = $developers::all();
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Developers  $developers
     * @return \Illuminate\Http\Response
     */
    public function edit(Developers $developers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Developers  $developers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Developers $developers, $id)
    {
        $dev = $developers::where('id',$id)->first();
        $dev->first_name = $request->get('val_1');
        $dev->last_name = $request->get('val_2');
        $dev->email = $request->get('val_3');
        $dev->phone_num = $request->get('val_4');
        $dev->address = $request->get('val_5');
        //$dev->avatar = $request->get('val_6');
        $dev->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Developers  $developers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Developers $developers, $id)
    {
        $dev = $developers::find($id)->delete();
    }

    public function delete_developers(Developers $developers, $id)
    {
       $single_user_id = explode(',' , $id);

       foreach($single_user_id as $id) {
            $developers::findOrFail($id)->delete();
       }

    }
}
