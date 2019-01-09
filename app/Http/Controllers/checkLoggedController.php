<?php

namespace App\Http\Controllers;

use App\r_affiliate_info;
use App\r_product_info;
use App\r_product_type;
use App\r_tax_table_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class checkLoggedController extends Controller
{
    //

    public function index()
    {

    }

    public function checkLogged()
    {
        $prodInfo = r_product_info::with('rAffiliateInfo','rProductType','rTaxTableProfile')->get();
        if (null !== Auth::user()) {
            if (Auth::user()->role == 'admin') {
                return redirect('admin/dashboard');
            } else if (Auth::user()->role == 'member') {
                return redirect('member/dashboard');

            } else {
                Auth::logout();
                return abort(500);
            }
        } else {
            return view('welcome',compact('prodInfo'));
        }
    }
}
