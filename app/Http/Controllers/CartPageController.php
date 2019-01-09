<?php

namespace App\Http\Controllers;

use App\r_product_info;
use App\t_order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Exists;

class CartPageController extends Controller
{
    //

    public function index()
    {
        $countCart = 0;

        $cart = Session::get('cart');
        $prodInfo = r_product_info::with('rAffiliateInfo','rProductType','rTaxTableProfile')->get();

        return view('welcome',compact('prodInfo','cart','countCart'));
    }

    public  function  view_cart(){
        $countCart = 0;

        $cart = Session::get('cart');
        $prodInfo = r_product_info::with('rAffiliateInfo','rProductType','rTaxTableProfile')->get();

        return view('viewCart',compact('prodInfo','cart','countCart'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = DB::select('SELECT * FROM R_PRODUCT_INFOS where PROD_ID='.$id);

        $cart = Session::get('cart');

        if(!array_key_exists ($id,(array)$cart)){
            $cart[$product[0]->PROD_ID] = array(
                "id" => $product[0]->PROD_ID,
                "prodname" => $product[0]->PROD_NAME,
                "prodprice" => $request->price,
                "prodimg" => $product[0]->PROD_IMG,
                "qty" => 1,
            );
        }else{
            $cart[$id]['qty']++;
        }

        Session::put('cart', $cart);
//        dd(Session::get('cart'));
        return redirect()->back()->with('success','Product Sucessfully Added to Cart');
    }


    public function updateCart($id,$qty)
    {
        $cart = Session::get('cart');


            if ($qty > 0)
                $cart[$id]['qty'] += $qty;
             else
                unset($cart[$id]);
        Session::put('cart', $cart);
        return redirect()->back();
    }

    public function deleteCart($id)
    {
        $cart = Session::get('cart');
        unset($cart[$id]);
        Session::put('cart', $cart);
        return redirect()->back();
    }
}
