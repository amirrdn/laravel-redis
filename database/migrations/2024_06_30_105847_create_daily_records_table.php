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
        Schema::create('daily_records', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->integer('male_count')->default(0);
            $table->integer('female_count')->default(0);
            $table->float('male_avg_age')->default(0);
            $table->float('female_avg_age')->default(0);
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
        Schema::dropIfExists('daily_records');
    }
};
