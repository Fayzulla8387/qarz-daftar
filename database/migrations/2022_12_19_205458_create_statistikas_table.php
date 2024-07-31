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
        Schema::create('statistikas', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('total_debt');
            $table->integer('received_debt');
            $table->integer('paid_debt');
            $table->integer('debtors_count');
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
        Schema::dropIfExists('statistikas');
    }
};
