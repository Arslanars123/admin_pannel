<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerfieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customerfields', function (Blueprint $table) {
            $table->id();
            $table->string('english_label')->nullable();
            $table->string('italian_label')->nullable();
            $table->string('field_type')->nullable();
            $table->string('field_name')->nullable();
            $table->string('is_mandatory')->nullable();
            $table->integer('order')->nullable();
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
        Schema::dropIfExists('customerfields');
    }
}
