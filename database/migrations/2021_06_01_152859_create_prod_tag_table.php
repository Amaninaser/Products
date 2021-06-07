<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_tag', function (Blueprint $table) {
            $table->foreignId('prod_id')->constrained('prods','id')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags','id')->cascadeOnDelete();
            $table->primary(['prod_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prod_tag');
    }
}
