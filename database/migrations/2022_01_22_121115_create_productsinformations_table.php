<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsinformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productsinformations', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_id')->nullable();
            $table->string('category_id')->nullable();

            $table->string('name_en')->nullable();
            $table->string('name_it')->nullable();
            $table->text('image')->nullable();
            $table->integer('price')->nullable();
            $table->longText('images')->nullable();
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
        Schema::dropIfExists('productsinformations');
    }
}
