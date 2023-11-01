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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("brand");
            $table->string("model");
            $table->string("color");
            $table->integer("capacity")->default(0);
            $table->unsignedBigInteger('capacity_unit');
            $table->unsignedBigInteger('category');
            $table->foreign("capacity_unit")->references('id')->on('capacity_units');
            $table->foreign("category")->references('id')->on('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
