<?php

namespace App\Http\Controllers;

use App\r_affiliate_info;
use App\user;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersManagementPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aff = r_affiliate_info::all();
        $user = user::all();
        return view('admin.users.manage',compact('aff','user'));
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

        $user = new user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->AFF_ID = $request->input('affiliates');
        $user->save();

        return redirect('admin/users/manage')->with('success','User record was inserted successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $user = user::all();
        return  new JsonResource($user->where('id',$id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user =  user::all()->where('id',$id);
        $user->name = $request->name;
        $user->email = $request->email;
        ($request->password)?$user->password = bcrypt($request->password):'';
        $user->AFF_ID = $request->input('affiliates');
        $user->save();

        return redirect('admin/users/manage')->with('success','User record was updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
