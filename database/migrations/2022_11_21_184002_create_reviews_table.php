<?php

use App\Models\Contractor;
use App\Models\HiredWork;
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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(HiredWork::class)->constrained();
            $table->foreignIdFor(Worker::class)->nullable()->index();
            $table->foreignIdFor(Contractor::class)->nullable()->index();
            $table->string('title', 150);
            $table->text('description');
            $table->unsignedTinyInteger('rating');
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
        Schema::dropIfExists('reviews');
    }
};
