<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RProductInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("R_PRODUCT_INFOS",function(Blueprint $table){
            $table->engine = 'INNODB';

            $table->increments("PROD_ID");
            $table->unsignedInteger("PRODT_ID")->nullable();
            $table->unsignedInteger("AFF_ID");
            $table->unsignedInteger("TAXP_ID")->nullable();
            $table->text("PROD_DESC")->nullable();
            $table->text("PROD_NOTE")->nullable();
            $table->text("PROD_IMG")->nullable();
            $table->double("PROD_REBATE",10,2)->default(0);
            $table->double("PROD_MARKUP",10,2)->default(0);
            $table->string("PROD_CODE",20)->unique();
            $table->string("PROD_NAME",100);
            $table->integer('PROD_QTY')->default(500);
            $table->integer('PROD_CRITICAL')->default(100);
            $table->double("PROD_BASE_PRICE",10,2);
            $table->string("PROD_SALES_TAX",20)->default('Exclusive');
            $table->boolean("PROD_IS_APPROVED")->nullable();
            $table->dateTime("PROD_APPROVED_AT")->nullable();
            $table->boolean("PROD_DISPLAY_STATUS")->default(1);
            $table->timestamps();

            $table->foreign("PRODT_ID")->references("PRODT_ID")->on("R_PRODUCT_TYPES")
                ->onUpdate("cascade")
                ->onDelete("no action");
            $table->foreign("AFF_ID")->references("AFF_ID")->on("R_AFFILIATE_INFOS")
                ->onUpdate("cascade")
                ->onDelete("no action");
            $table->foreign("TAXP_ID")->references("TAXP_ID")->on("R_TAX_TABLE_PROFILES")
                ->onUpdate("cascade")
                ->onDelete("No Action");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('R_PRODUCT_INFOS');
    }
}
