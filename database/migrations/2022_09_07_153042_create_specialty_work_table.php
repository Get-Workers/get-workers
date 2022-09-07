<?php

use App\Models\Specialty;
use App\Models\Work;
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
        Schema::create('specialty_work', function (Blueprint $table) {
            $table->foreignIdFor(Specialty::class)->constrained();
            $table->foreignIdFor(Work::class)->constrained();

            $table->unique(['specialty_id', 'work_id'], 'specialty_work_foreigns_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialty_work');
    }
};
