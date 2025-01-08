<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotional_packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pk_Package_id');// Reference to packages table
            $table->string('generated_url');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('pk_Package_id')
          ->references('pk_Package_id')
          ->on('packages')
          ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotional_packages');
    }
};
