<?php

use App\Models\HiredWork;
use App\Models\Review;
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
        Schema::create('review_hired_work_contractor', function (Blueprint $table) {
            $table->foreignIdFor(Review::class)->constrained();
            $table->foreignIdFor(HiredWork::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_hired_work_contractor');
    }
};
