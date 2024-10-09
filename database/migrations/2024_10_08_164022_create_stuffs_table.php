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
        Schema::create('stuffs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->date('start_from');
            $table->string('contact_normal');
            $table->string('address');
            $table->integer('salary_wages');
            $table->string('benifits');
            $table->integer('vacation_peroid')->default(10);
            $table->string('training_records');
            $table->string('contact_emergency');
            $table->string('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stuffs');
    }
};
