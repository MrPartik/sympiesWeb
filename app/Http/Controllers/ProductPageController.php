<?php

namespace App\Http\Controllers;
use MagpieApi;
use App\r_affiliate_info;
use App\r_inventory_info;
use App\r_product_info;
use App\r_product_type;
use App\r_tax_table_profile;
use App\t_product_variance;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use Psy\Util\Json;
use Illuminate\Support\Facades\DB;

class ProductPageController extends Controller
{

    public function index()
    {

        $aff = r_affiliate_info::all();
        $prodType =  r_product_type::all();
        $taxProf =  r_tax_table_profile::all();
        $prodInfo = r_product_info::with('rAffiliateInfo','rProductType','rTaxTableProfile')->get();
        if(Auth::user()->role=="admin")
            return view('admin.shop.product',compact('prodType','taxProf','prodInfo','aff'));
        else if(Auth::user()->role=="member")
            return view('member.shop.product',compact('prodType','taxProf','prodInfo','aff'));
        else
            return abort(500);

        if(File::exists(public_path('uploads/' . $prodInfo->PROD_IMG))) {
            File::delete(public_path('uploads/' . $prodInfo->PROD_IMG));
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $prodInfo = new r_product_info();
        $inv = new r_inventory_info();

        $imageFile = $request->file('prodimg');
//        $imageNames = '';
//        $incr = 0;
//        if (isset($imageFile)) {
//            foreach ($imageFile as $image) {
//                $imageName = $request->prodcode.'-' .$incr.'.' . $image->getClientOriginalExtension();
//                if (!file_exists('uploads/'))
//                    mkdir('uploads/', 666, true);
//                ini_set('memory_limit', '512M');
//                Image::make($image)->save(public_path('uploads/' . $imageName));
//                $imageNames .= 'uploads/'.$imageName.',';
//                $incr++;
//            }
//            $prodInfo->PROD_IMG = $imageNames;
//        }

        if (isset($imageFile)) {
            $imageName = $request->prodcode.'.'.$imageFile->getClientOriginalExtension();
            if (!file_exists('uploads/'))
                    mkdir('uploads/', 666, true);
                ini_set('memory_limit', '512M');
                Image::make($imageFile)->save(public_path('uploads/' . $imageName));
            $prodInfo->PROD_IMG ='uploads/' . $imageName;;
        }
        $prodInfo->PROD_CODE = $request->prodcode;
        $prodInfo->PROD_NAME = $request->prodname;
        $prodInfo->PROD_BASE_PRICE = $request->baseprice;
        $prodInfo->PROD_QTY = $request->inv_qty;
        $prodInfo->PROD_CRITICAL = $request->inv_critical;
        $prodInfo->PRODT_ID = $request->input('prodtype');

        $prodInfo->PROD_DESC = $request->proddesc;
        $prodInfo->PROD_NOTE = $request->prodnote;
        $prodInfo->AFF_ID = Auth::user()->AFF_ID;
        $prodInfo->PROD_DESC = $request->proddesc;


        if(Auth::user()->role=="admin"){
            try {
                $prodInfo->PROD_MARKUP = $request->prodmarkup;
                $prodInfo->TAXP_ID = $request->input('prodtax');
                $prodInfo->PROD_REBATE = $request->prodrebate;
                $prodInfo->PROD_IS_APPROVED = 1;
                $prodInfo->PROD_APPROVED_AT = Carbon::now();
                $prodInfo->save();
                if(!trim($request->inv_qty)==""){
                    $inv->INV_QTY = $request->inv_qty;
                    $inv->INV_TYPE = 'CAPITAL';
                    $inv->PROD_ID = $prodInfo->PROD_ID;
                    $inv->save();
                }
                return redirect('admin/shop/product')->with('success', 'Successfully record is updated!');
            }catch (\Exception $e){
                return redirect('admin/shop/product')->with('error',$e->getCode());
            }
        }else if(Auth::user()->role=="member"){
           try {
               $prodInfo->save();

               return redirect('member/shop/product')->with('success', 'Successfully record is inserted!');
           }catch (\Exception $e){
               return redirect('member/shop/product')->with('error',$e->getCode());
           }
        }

        else
            return abort(500);
        if(!trim($request->inv_qty)==""){
            $inv->INV_QTY = $request->inv_qty;
            $inv->INV_TYPE = 'CAPITAL';
            $inv->PROD_ID = $prodInfo->PROD_ID;
            $inv->save();
        }

    }

    public function show($id)
    {
        $prodInfo = r_product_info::with('rAffiliateInfo','rProductType')
            ->get(['PROD_CODE','PROD_ID','PROD_BASE_PRICE','PRODT_ID','PROD_DESC'
                ,'PROD_IMG','PROD_NAME','PROD_REBATE','TAXP_ID','PROD_MARKUP','PROD_NOTE','PROD_QTY','PROD_CRITICAL'])
            ->where('PROD_ID',$id)->toArray();
        $image = DB::Select('select PROD_IMG from r_product_infos where PROD_ID ='.$id)[0]->PROD_IMG;

        $img = array(['IMG'=>asset(($image)?$image:'uPackage.png')]);
        return  new JsonResource(array_merge($prodInfo,$img));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $prodInfo = r_product_info::where('PROD_ID',$id)->first();
        $imageFile=$request->file('prodimg');
//        $imageNames = '';
//        $incr = 0;
//        if (isset($imageFile)) {
//            foreach ($imageFile as $image) {
//                $imageName = $request->prodcode.'-' .$incr.'.' . $image->getClientOriginalExtension();
//                if (!file_exists('uploads/'))
//                    mkdir('uploads/', 666, true);
//                ini_set('memory_limit', '512M');
//                Image::make($image)->save(public_path('uploads/' . $imageName));
//                $imageNames .= 'uploads/'.$imageName.',';
//                $incr++;
//            }
//            $prodInfo->PROD_IMG = $imageNames;
//        }
        if (isset($imageFile)) {
            $imageName = $request->prodcode.'.'.$imageFile->getClientOriginalExtension();
            if (!file_exists('uploads/'))
                mkdir('uploads/', 666, true);
            ini_set('memory_limit', '512M');
            Image::make($imageFile)->save(public_path('uploads/' . $imageName));
            $prodInfo->PROD_IMG ='uploads/' . $imageName;
        }
        $prodInfo->PROD_CODE = $request->prodcode;
        $prodInfo->PROD_NAME = $request->prodname;
        $prodInfo->PROD_BASE_PRICE = $request->baseprice;
        $prodInfo->PROD_CRITICAL = $request->inv_critical;
        $prodInfo->PRODT_ID = $request->input('prodtype');

        $prodInfo->PROD_DESC = $request->proddesc;
        $prodInfo->PROD_NOTE = $request->prodnote;
        $prodInfo->AFF_ID = Auth::user()->AFF_ID;
        $prodInfo->PROD_DESC = $request->proddesc;

        if(Auth::user()->role=="admin"){
            try {
                $prodInfo->PROD_MARKUP = $request->prodmarkup;
                $prodInfo->PROD_REBATE = $request->prodrebate;
                $prodInfo->PROD_IS_APPROVED = 1;
                $prodInfo->save();
                return redirect('admin/shop/product')->with('success', 'Successfully record is updated!');
            }catch (\Exception $e){
                return redirect('admin/shop/product')->with('error',$e->getCode());
            }

        }else if(Auth::user()->role=="member"){
            try {
                $prodInfo->save();
                return redirect('member/shop/product')->with('success', 'Successfully record is updated!');
            }catch (\Exception $e){
                return redirect('member/shop/product')->with('error',$e->getMessage());
            }
        }
        else
            return abort(500);
    }

    public function destroy($id)
    {
    }

    public function actDeact(Request $request)
    {
        $prodInfo = r_product_info::where('PROD_ID', $request->id)->first();

        if($request->type == 0) {
            $prodInfo->PROD_DISPLAY_STATUS = 0;
            $prodInfo->updated_at = Carbon::now();
            $prodInfo->save();
            redirect()->back()->with('success','Product record was deactivated successfully');
        }else if($request->type ==1 ){
            $prodInfo->PROD_DISPLAY_STATUS = 1;
            $prodInfo->updated_at = Carbon::now();
            $prodInfo->save();
            redirect()->back()->with('success','Product record was activated successfully');
        }
    }

    public  function appDisapprove(Request $request){

        $prodInfo = r_product_info::where('PROD_ID', $request->id)->first();

        if($request->type == 0) {
            $prodInfo->PROD_IS_APPROVED = 0;
            $prodInfo->PROD_APPROVED_AT = Carbon::now();
            $prodInfo->updated_at = Carbon::now();
            $prodInfo->save();
            return redirect('admin/shop/product')->with('success','Product record rejected!');
        }else if($request->type ==1 ){

            $prodInfo->PROD_MARKUP = $request->prodmarkup;
            $prodInfo->PROD_REBATE = $request->prodrebate;
            $prodInfo->TAXP_ID = $request->input('prodtax');
            $prodInfo->PROD_IS_APPROVED = 1;
            $prodInfo->PROD_APPROVED_AT = Carbon::now();
            $prodInfo->updated_at = Carbon::now();
            $prodInfo->save();
            return redirect('admin/shop/product')->with('success','Product record approved!');

        }
    }

    public function export()
    {
        return Excel::download(new ProductExport, 'Products.xlsx');
    }

    public function addProductVar(Request $request){

        try{
            for($i=0; $i <=count(array($request->prodvarname));$i++){
                $prodVar = new t_product_variance();
                $imageFile = $request->file('prodvarimg')[$i];
                $prodVar->PROD_ID = $request->prodID;
                $prodVar->PRODV_NAME = $request->prodvarname[$i];
                $prodVar->PRODV_DESC = $request->prodvardesc[$i];
                $prodVar->PRODV_ADD_PRICE = $request->addprice[$i];
                $prodVar->PRODV_IMG = $request->prodvarimg[$i];
                if (isset($imageFile)) {
                    $imageName = 'PROD_VARIANCE'.$request->prodID.'-'.t_product_variance::all()->count().'.'.$imageFile->getClientOriginalExtension();
                    if (!file_exists('uploads/'))
                        mkdir('uploads/', 666, true);
                    ini_set('memory_limit', '512M');
                    Image::make($imageFile)->save(public_path('uploads/' . $imageName));
                    $prodVar->PRODV_IMG ='uploads/' . $imageName;
                }
                $prodVar->save();
            }
            return redirect()->back()->with('success', 'Successfully product variance record is/are added!');
        }catch (\Exception $e){
            return redirect()->back()->with('error',$e->getCode());
        }
    }
    public function ProductVar(Request $request){

        try{
            $lastID= array();
            for($i=0; $i < count($request->get('prodvarname'));$i++){
                if($request->prodVarID[$i] == 0) {
                    $prodVar = new t_product_variance();
                    $inv = new r_inventory_info();
                    $prodVar->PRODV_QTY = $request->inv_qty[$i];
                    if(!trim($request->inv_qty[$i])==""){
                        $inv->INV_QTY = $request->inv_qty[$i];
                        $inv->INV_TYPE = 'CAPITAL';
                        $inv->PROD_ID = $request->prodID;
                    }
                }
                else if($request->prodVarID[$i] != 0) {
                    $prodVar = t_product_variance::where('PRODV_ID', $request->prodVarID[$i])->first();

                }
                $prodVar->PROD_ID = $request->prodID;
                $prodVar->PRODV_NAME = $request->prodvarname[$i];
                $prodVar->PRODV_DESC = $request->prodvardesc[$i];
                $prodVar->PRODV_ADD_PRICE = $request->addprice[$i];
                if (isset($request->file('prodvarimg')[$i])) {
                    $imageFile = $request->file('prodvarimg')[$i];
                    $imageName = 'PROD_VARIANCE'.$request->prodID.'-'.t_product_variance::all()->count().'.'.$imageFile->getClientOriginalExtension();
                    if (!file_exists('uploads/'))
                        mkdir('uploads/', 666, true);
                    ini_set('memory_limit', '512M');
                    Image::make($imageFile)->save(public_path('uploads/' . $imageName));
                    $prodVar->PRODV_IMG ='uploads/' . $imageName;
                }
                $prodVar->save();
                $inv->PRODV_ID = $prodVar->PRODV_ID;
                $inv->save();
                array_push($lastID,$prodVar->PRODV_ID);
                array_push($lastID,$request->prodVarID[$i]);
            }
            t_product_variance::whereNotIn('PRODV_ID',$lastID)->Where('PROD_ID','=',$request->prodID)->delete();
            return redirect()->back()->with('success', 'Successfully product variance record is/are updated!');
        }catch (\Exception $e){
//            return redirect()->back()->with('error',$e->getCode());
            return $e->getMessage().$e->getLine().count($request->get('prodVarID'));
        }

    }
    public function showProductVar($id){
        $prodInfo = t_product_variance::with('rProductInfo')
            ->get();
        return  new JsonResource($prodInfo->where('PROD_ID',$id));
    }

    public function showProduct($id){
        $prodInfo = r_product_info::all();
        return  new JsonResource($prodInfo->where('PROD_ID',$id));
    }

    public function deleteAllProductVar(Request $request){
        t_product_variance::where('PROD_ID',$request->id)->delete();
        redirect()->back()->with('success', 'Successfully all product variance record deleted!');
    }
}
