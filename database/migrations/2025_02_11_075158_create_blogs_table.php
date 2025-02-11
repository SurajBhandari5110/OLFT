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
    Schema::create('blogs', function (Blueprint $table) {
        $table->id('blog_id');
        $table->string('title')->unique();
        $table->text('content'); // Stores HTML content from Quill
        $table->string('slug')->unique();
        $table->string('by_user', 250);
        $table->timestamps(); // created_at & updated_at
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
};
