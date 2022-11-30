<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $filename = str(__FILE__)->replace([__DIR__, '.php'], '');
        $sql = File::get(__DIR__.'/sql'.$filename.'.sql');
        DB::transaction(fn () => DB::insert($sql));
    }
};
