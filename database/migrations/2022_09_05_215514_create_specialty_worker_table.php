<?php

use App\Models\Specialty;
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
        Schema::create('specialty_worker', function (Blueprint $table) {
            $table->foreignIdFor(Specialty::class)->constrained();
            $table->foreignIdFor(Worker::class)->constrained();

            $table->unique(['specialty_id', 'worker_id'], 'specialty_worker_foreigns_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialty_worker');
    }
};
