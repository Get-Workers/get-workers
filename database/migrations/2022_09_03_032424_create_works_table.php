<?php

use App\Models\Unity;
use App\Models\Worker;
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
            $table->id();
            $table->uuid();
            $table->foreignIdFor(Worker::class)->constrained();
            $table->foreignIdFor(Unity::class)->nullable()->constrained()->nullOnDelete();
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
