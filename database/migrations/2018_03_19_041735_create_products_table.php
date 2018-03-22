<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');

            $table->string('title');
            $table->integer('price')->nullable();
            $table->integer('cost')->nullable();
            $table->text('description')->nullable();
            $table->text('code')->nullable();
            $table->text('sku')->nullable();
            $table->integer('volume')->nullable();
            $table->integer('weight')->nullable();
//            $table->mediumText('short_description')->nullable();
            $table->string('photo')->nullable();
//            $table->mediumText('ean13')->nullable();
            $table->boolean('active')->default(true);
            $table->enum('condition', ['new', 'used', 'refurbished'])->default('new');
//            $table->integer('brand_id')->unsigned()->nullable();
//            $table->foreign('brand_id')->references('id')->on('brands');
//            $table->integer('supplier_id')->unsigned()->nullable();
//            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->integer('days_to_deliver')->unsigned();
            $table->integer('available_quantity')->unsigned()->default(0);
            $table->enum('unit_of_measure', ['piece'])->default('piece');
//            $table->integer('unit_of_measure_id')->unsigned();
//            $table->integer('category_id')->unsigned();
//            $table->foreign('category_id')->references('id')->on('categories');

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
        Schema::dropIfExists('products');
    }
}
