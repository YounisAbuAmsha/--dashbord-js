<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title' , 100);
            $table->boolean('active')->default(true);

            // create foreign key :
            // 1-
            // 1.1 - create new column with same data type
            $table->foreignId('user_id');
            // 1.2- create foreign key index
            $table->foreign('user_id')->on('users')->references('id');

            // 2-
            // $table->foreignId('user_id')->constrained();

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
        Schema::dropIfExists('categories');
    }
};
