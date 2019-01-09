<?php

use Illuminate\Database\Seeder;
use App\r_affiliate_info;

class affiliates extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        r_affiliate_info::truncate();

        $aff = new r_affiliate_info();
        $aff->AFF_CODE="Symp-0001";
        $aff->AFF_NAME="Sympies";
        $aff->AFF_DESC="Sympies Description";
        $aff->AFF_PAYMENT_INSTRUCTION="Instruction";
        $aff->AFF_PAYMENT_MODE="Bank";
        $aff->save();

        $aff = new r_affiliate_info();
        $aff->AFF_CODE="IslandR-0002";
        $aff->AFF_NAME="Island Rose";
        $aff->AFF_DESC="Island Rose Description";
        $aff->AFF_PAYMENT_INSTRUCTION="Instruction";
        $aff->AFF_PAYMENT_MODE="Bank";
        $aff->save();
    }
}
