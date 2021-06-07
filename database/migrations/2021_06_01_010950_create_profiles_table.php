<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained('users','id')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->string('phone');
            $table->date('Brithday');
            $table->enum('Gender',['Male','Female']);
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
        Schema::dropIfExists('profiles');
    }
}
