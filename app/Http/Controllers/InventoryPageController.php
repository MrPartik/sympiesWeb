<?php

namespace App\Http\Controllers;

use App\r_inventory_info;
use App\r_product_info;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class InventoryPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $inv = r_inventory_info::with('rProductInfo','tProductVariance')->get();
        $prodInfo = r_product_info::all()->where('PROD_DISPLAY_STATUS',1);

        return view('admin.inventory.addInventory',compact('inv','prodInfo'));
    }

    public function remaining(){
        $inv = r_inventory_info::with('rProductInfo','tProductVariance')->get();
        $prodInfo = r_product_info::all();


        return view('admin.inventory.remainingInventory',compact('inv','prodInfo'));
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
        try {
            if($request->type==0){
                if($request->prodType == 0){
                    $prodInfo = new r_inventory_info();
                    $prodInfo->PROD_ID = $request->input('prodName');
                    $prodInfo->INV_QTY = $request->prodqty;
                    $prodInfo->INV_TYPE = 'ADD';
                    $prodInfo->save();
                }else if($request->prodType == 1){
                    for($i=0; $i<count($request->prodVarID);$i++){
                        if($request->inv_qty[$i]){
                            $prodInfo = new r_inventory_info();
                            $prodInfo->PROD_ID = $request->input('prodName');
                            $prodInfo->PRODV_ID = $request->prodVarID[$i];
                            $prodInfo->INV_QTY = $request->inv_qty[$i];
                            $prodInfo->INV_TYPE = 'ADD';
                            $prodInfo->save();
                        }
                    }
                }

            }else if($request->type==1){
                if($request->prodType == 0){
                    $prodInfo = new r_inventory_info();
                    $prodInfo->PROD_ID = $request->input('prodName');
                    $prodInfo->INV_QTY = $request->prodqty;
                    $prodInfo->INV_TYPE = 'DISPOSE';
                    $prodInfo->save();
                }else if($request->prodType == 1){
                    for($i=0; $i<count($request->prodVarID);$i++){
                        if($request->inv_qty[$i]){
                            $prodInfo = new r_inventory_info();
                            $prodInfo->PROD_ID = $request->input('prodName');
                            $prodInfo->PRODV_ID = $request->prodVarID[$i];
                            $prodInfo->INV_QTY = $request->inv_qty[$i];
                            $prodInfo->INV_TYPE = 'DISPOSE';
                            $prodInfo->save();
                        }
                    }
                }
            }
            return redirect()->back()->with('success', 'Successfully record is upadted!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prodInfo =  r_product_info::all()->where('PROD_ID',$id)->first();
        $invInfo =  r_inventory_info::with('rProductInfo','tProductVariance','tOrderItem')->where('PROD_ID',$id)->get();

        return  (isset($invInfo)&&isset($prodInfo))?view('admin.inventory.historyInventory',compact('invInfo','id','prodInfo')):abort('404');
//        return $invInfo;
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
