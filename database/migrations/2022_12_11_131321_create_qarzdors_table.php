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
        Schema::create('qarzdors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('phone')->unique();
            $table->integer('debt')->default(0);
            $table->date('return_date')->nullable();
            $table->integer('limit')->default(0);
            $table->string('caption')->nullable();
            $table->integer('status')->default(1);
            $table->integer('sms_count')->default(0);
            $table->integer('type')->default(1);
            $table->unsignedBigInteger('korxona_id')->nullable();
            $table->foreign('korxona_id')->references('id')->on('korxonas')->onDelete('cascade');
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
        Schema::dropIfExists('qarzdors');
    }
};
