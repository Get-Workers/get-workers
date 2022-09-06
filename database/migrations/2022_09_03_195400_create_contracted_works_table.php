<?php

use App\Models\Contractor;
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
        Schema::create('contracted_works', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignIdFor(Work::class)->constrained();
            $table->foreignIdFor(Contractor::class)->constrained();
            $table->unsignedInteger('price')->nullable();
            $table->unsignedInteger('value_paid')->nullable();
            $table->timestamp('initiated_at')->nullable();
            $table->timestamp('done_at')->nullable();
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
        Schema::dropIfExists('contracted_works');
    }
};
