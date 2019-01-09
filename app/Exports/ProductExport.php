<?php

namespace App\Exports;

use App\r_product_info;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //


        return  r_product_info::with('rAffiliateInfo','rProductType')
            ->get(['PROD_CODE','PROD_ID','PROD_BASE_PRICE','PRODT_ID','PROD_SIZE','PROD_DESC','PROD_COLOR'
                ,'PROD_IMG','PROD_NAME','PROD_REBATE']);
    }
}
