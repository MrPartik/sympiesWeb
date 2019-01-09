<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("T_ORDER_ITEMS",function(Blueprint $table){
            $table->engine = "INNODB";

            $table->increments("ORDI_ID");
            $table->unsignedInteger("ORD_ID");
            $table->unsignedInteger("PROD_ID");
            $table->integer("ORDI_QTY")->default(1);
            $table->double("ORDI_SOLD_PRICE",10,2);
            $table->string("ORDI_VOUCHER_CODE",20)->nullable();
            $table->timestamps();

            $table->foreign("ORD_ID")->references("ORD_ID")->on("T_ORDERS")
                ->onUpdate("cascade")
                ->onDelete("no action");
            $table->foreign("PROD_ID")->references("PROD_ID")->on("R_PRODUCT_INFOS")
                ->onUpdate("cascade")
                ->onDelete("no action");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('T_ORDER_ITEMS');
    }
}
