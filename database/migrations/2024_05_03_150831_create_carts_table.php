<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('name_product_cart')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('total_price_cart')->nullable();
            $table->enum('status_cart', ['wait', 'process', 'done'])->default('wait');
            $table->integer('quantity_cart')->nullable();
            $table->string('variant_cart')->nullable();
            $table->string('size_cart')->nullable();
            $table->string('category_cart')->nullable();
            $table->text('image_cart')->nullable();
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
        Schema::dropIfExists('carts');
    }
}
