<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->boolean('visible');
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->integer('qty')->nullable();
            $table->text('description');
            $table->decimal('price',6,2);
            $table->boolean('daily_opportunity')->default(0);
            $table->tinyInteger('featured')->default(0)->comment('0 => normal, 1 => yeni, 2 => ikinci el');
            $table->integer('sale_count')->default(0);
            $table->boolean('discount_type')->nullable()->comment('[0 => percent , 1 => price]');
            $table->decimal('discount_price',6,2)->nullable();
            $table->longText('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
