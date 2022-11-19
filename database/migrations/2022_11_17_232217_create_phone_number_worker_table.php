<?php

use App\Models\PhoneNumber;
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
        Schema::create('phone_number_worker', function (Blueprint $table) {
            $table->foreignIdFor(Worker::class)->constrained();
            $table->foreignIdFor(PhoneNumber::class)->constrained();
            $table->timestamp('validated_at')->nullable();
            $table->unique(['phone_number_id', 'worker_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_number_worker');
    }
};
