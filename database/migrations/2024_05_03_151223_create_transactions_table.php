<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->bigInteger('total_transaction')->nullable();
            $table->string('courier')->nullable();
            $table->string('service')->nullable();
            $table->string('description')->nullable();
            $table->bigInteger('cost')->nullable();
            $table->string('estimated')->nullable();
            $table->string('status_transaction')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('order_id')->nullable();
            $table->text('token_payment')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
