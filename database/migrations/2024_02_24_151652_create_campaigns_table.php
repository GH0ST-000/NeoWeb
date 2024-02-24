<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('end_date');
            $table->string('uuid')->unique();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
