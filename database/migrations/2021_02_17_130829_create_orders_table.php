<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('orderno')->nullable();
            $table->decimal('total',6,2);
            $table->decimal('discount',6,2);
            $table->decimal('payed',6,2);
            $table->boolean('order_type')->default(0)->comment('[0 => adi, 1 => tecili]');
            $table->enum('payment_type',['cash','online','payment_in_door']);
            $table->tinyInteger('type')->comment('1 => birbasa, 2 => sebetden birbasa, 3=> sebetden');
            $table->longText('address')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
