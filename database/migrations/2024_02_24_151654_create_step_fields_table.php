<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('step_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('step_id');
            $table->foreign('step_id')->references('id')->on('steps');
            $table->string('field_name');
            $table->integer('order_num')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('step_fields');
    }
};
