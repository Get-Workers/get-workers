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
        Schema::create('works', function (Blueprint $table) {
            $table->id('id');
            $table->uuid('uuid');
            $table->foreignId('worker_id');
            $table->foreignId('unity_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->time('time')->nullable();
            $table->unsignedInteger('price')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('works');
    }
};
