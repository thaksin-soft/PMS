<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIcPurchasingInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ic_purchasing_inventory', function (Blueprint $table) {
            $table->string('doc_no', 30)->primary();
            $table->dateTime('in_date');
            $table->dateTime('ch_date');
            $table->integer('ch_status');
            $table->integer('up_status');
            $table->integer('creater');
            $table->integer('approver');
            $table->integer('uploader');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ic_purchasing_inventory');
    }
}