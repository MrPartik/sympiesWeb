<?php

use Illuminate\Database\Seeder;
use App\r_product_info;
use App\r_product_type;
use App\r_tax_table_profile;

class productInfo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        r_product_type::truncate();
        $prodType = new r_product_type();
        $prodType->PRODT_TITLE = "Food";
        $prodType->PRODT_DESC = "Description";
        $prodType->save();

        $prodType = new r_product_type();
        $prodType->PRODT_TITLE = "Flowers";
        $prodType->PRODT_DESC = "Description";
        $prodType->save();

        $prodType = new r_product_type();
        $prodType->PRODT_TITLE = "Chocolates";
        $prodType->PRODT_DESC = "Description";
        $prodType->save();


        $prodType = new r_product_type();
        $prodType->PRODT_TITLE = "Almond Chocolate";
        $prodType->PRODT_DESC = "Description";
        $prodType->PRODT_PARENT=3;
        $prodType->save();

        $prodType = new r_product_type();
        $prodType->PRODT_TITLE = "Camia Flowers";
        $prodType->PRODT_DESC = "Description";
        $prodType->PRODT_PARENT=2;
        $prodType->save();

        $prodType = new r_product_type();
        $prodType->PRODT_TITLE = "Flowers Bouquet";
        $prodType->PRODT_DESC = "Description";
        $prodType->PRODT_PARENT=2;
        $prodType->save();

        $prodType = new r_product_type();
        $prodType->PRODT_TITLE = "Chocolates";
        $prodType->PRODT_DESC = "Description";
        $prodType->PRODT_PARENT=3;
        $prodType->save();

        $prodType = new r_product_type();
        $prodType->PRODT_TITLE = "Orange Juice";
        $prodType->PRODT_DESC = "Description";
        $prodType->PRODT_PARENT=1;
        $prodType->save();


        r_tax_table_profile::truncate();
        $taxProf = new r_tax_table_profile();
        $taxProf->TAXP_NAME="Fixed Tax Rate";
        $taxProf->TAXP_DESC="Based on amount rate";
        $taxProf->TAXP_TYPE=1;
        $taxProf->TAXP_RATE=20.00;
        $taxProf->save();

        $taxProf = new r_tax_table_profile();
        $taxProf->TAXP_NAME="V.A.T  ";
        $taxProf->TAXP_DESC="Value Added Tax";
        $taxProf->TAXP_TYPE=0;
        $taxProf->TAXP_RATE=10.00;
        $taxProf->save();


        r_product_info::truncate();

        $prodInfo = new r_product_info();
        $prodInfo->AFF_ID = 2;
        $prodInfo->TAXP_ID = 1;
        $prodInfo->PROD_DESC = "Product Description";
        $prodInfo->PROD_IMG = null;
        $prodInfo->PROD_REBATE = 5;
        $prodInfo->PROD_MARKUP = 5;
        $prodInfo->PROD_CODE = "PROD-00002-1";
        $prodInfo->PROD_NAME = "Roses and Chocolates";
        $prodInfo->PROD_BASE_PRICE =500;
        $prodInfo->PROD_IMG=null;
        $prodInfo->PROD_IS_APPROVED =0;
        $prodInfo->save();


        $prodInfo = new r_product_info();
        $prodInfo->AFF_ID = 2;
        $prodInfo->TAXP_ID = 1;
        $prodInfo->PROD_DESC = "Product Description";
        $prodInfo->PROD_IMG = null;
        $prodInfo->PROD_REBATE = 5;
        $prodInfo->PROD_MARKUP = 5;
        $prodInfo->PROD_CODE =  "PROD-00002-2";
        $prodInfo->PROD_NAME = "Chocolates";
        $prodInfo->PROD_BASE_PRICE =250;
        $prodInfo->PROD_IS_APPROVED =1;
        $prodInfo->PROD_APPROVED_AT='2018-08-15';

        $prodInfo->save();


        $prodInfo = new r_product_info();
        $prodInfo->AFF_ID = 2;
        $prodInfo->TAXP_ID = 1;
        $prodInfo->PROD_DESC = "Product Description";
        $prodInfo->PROD_IMG = null;
        $prodInfo->PROD_REBATE = 5;
        $prodInfo->PROD_MARKUP = 5;
        $prodInfo->PROD_CODE =  "PROD-00002-3";
        $prodInfo->PROD_NAME = "Almond Chocolate";
        $prodInfo->PROD_BASE_PRICE =1000;
        $prodInfo->save();


        $prodInfo = new r_product_info();
        $prodInfo->AFF_ID = 1;
        $prodInfo->TAXP_ID = 1;
        $prodInfo->PROD_DESC = "Product Description";
        $prodInfo->PROD_IMG = null;
        $prodInfo->PROD_REBATE = 5;
        $prodInfo->PROD_MARKUP = 5;
        $prodInfo->PROD_CODE =  "PROD-00001-1";
        $prodInfo->PROD_NAME = "Almond Chocolate";
        $prodInfo->PROD_BASE_PRICE =1000;
        $prodInfo->save();


    }
}
