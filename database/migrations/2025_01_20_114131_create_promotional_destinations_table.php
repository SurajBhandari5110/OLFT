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
        Schema::create('promotional_destinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('destination_id');
            $table->text('generated_url');
            $table->timestamps();
         
    
            // Foreign key constraint
            $table->foreign('destination_id')
            ->references('id')
            ->on('destinations')
            ->onDelete('cascade');
        

        });
        



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotional_destinations');
    }
};
