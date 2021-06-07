<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->nullable()->constrained('categories','id')->nullOnDelete();
            $table->foreignId('store_id')->constrained('stores','id')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedFloat('price')->default(0);
            $table->unsignedFloat('sale_price')->default(0);
            $table->unsignedInteger('quantity')->default(0);
            $table->enum('status',['in-stock' ,'sold-out' ,'draft']);
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('sales')->default(0);
            $table->unsignedFloat('rating')->default(0);
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
        Schema::dropIfExists('prods');
    }
}
