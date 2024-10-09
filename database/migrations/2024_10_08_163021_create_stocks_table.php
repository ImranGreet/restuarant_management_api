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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('product_title');
            $table->string('category');
            $table->string('reordr_point');
            $table->integer('quantity_in_hand');
            $table->integer('minimum_quantity_in_hand');
            $table->integer('leadtime');
            $table->string('preferred_supplier');
            $table->integer('ingredient_use')->default(1);
            $table->date('expiration_date');
            $table->string('location');
            $table->string('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
