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
        Schema::create('worker_specialties', function (Blueprint $table) {
            $table->foreignIdFor(Worker::class)->constrained();
            $table->foreignIdFor(Specialty::class)->constrained();
            $table->unique(['worker_id', 'specialty_id'], 'worker_specialty_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worker_specialties');
    }
};
