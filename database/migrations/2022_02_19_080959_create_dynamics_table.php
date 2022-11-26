<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamics', function (Blueprint $table) {
            $table->id();
            $table->text('main_logo')->nullable();
            $table->text('main_logo_title')->nullable();
            $table->string('hotels_accounts')->nullable();
            $table->string('hotels_info_fields')->nullable();
            $table->string('customers_fields')->nullable();
            $table->string('products_fields')->nullable();
            $table->string('services_fields')->nullable();
            $table->string('customers')->nullable();
            $table->string('categories')->nullable();
            $table->string('hotel_information')->nullable();
            $table->string('ratings')->nullable();
            $table->string('chat')->nullable();
            $table->string('services_reservations_calender')->nullable();
            $table->string('bookings')->nullable();
            $table->string('services_reservations')->nullable();
            $table->string('english_label')->nullable();
            $table->string('italian_label')->nullable();
            $table->string('is_mandatory')->nullable();
            $table->string('field_type')->nullable();
            $table->string('summary')->nullable();
            $table->text('copyright')->nullable();
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
        Schema::dropIfExists('dynamics');
    }
}
