<?php

namespace App\Http\Controllers;

use App\r_tax_table_profile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaxPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tax = r_tax_table_profile::all();
        return view('admin/shop/tax',compact('tax'));
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
        $tax = new r_tax_table_profile();
        $tax->TAXP_NAME = $request->taxname;
        $tax->TAXP_DESC = $request->taxdesc;
        $tax->TAXP_RATE = $request->taxrate;
        $tax->TAXP_TYPE = $request->input('taxtype');
        $tax->save();

        return redirect('admin/shop/tax')->with('success','Tax record was inserted successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tax = r_tax_table_profile::all();
        return  new JsonResource($tax->where('TAXP_ID',$id));
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
        $tax = r_tax_table_profile::where('TAXP_ID',$id)->first();

        $tax->TAXP_NAME = $request->taxname;
        $tax->TAXP_DESC = $request->taxdesc;
        $tax->TAXP_RATE = $request->taxrate;
        $tax->TAXP_TYPE = $request->input('taxtype');
        $tax->save();

        return redirect('admin/shop/tax')->with('success','Tax record was updated successfully');
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

    public function actDeact(Request $request){

        $tax = r_tax_table_profile::where('TAXP_ID',$request->id)->first();

        if($request->type == 0){
            $tax->TAXP_DISPLAY_STATUS = 0;
            $tax->save();
            redirect('admin/shop/tax')->with('success','Tax record was deactivated successfully');
        }else if($request->type == 1){
            $tax->TAXP_DISPLAY_STATUS = 1;
            $tax->save();
            redirect('admin/shop/tax')->with('success','Tax record was activated successfully');
        }
    }
}
