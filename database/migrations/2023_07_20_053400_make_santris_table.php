<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('santris', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama',100);
            $table->string('image');
            $table->string('gender');
            $table->string('status')->default('aktif');
            $table->integer('room')->unsigned();
            $table->integer('divisi')->unsigned();
            $table->timestamps();
            $table->foreign('room')->references('id')->on('kamars');
            $table->foreign('divisi')->references('id')->on('divisis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santris');

    }
};
