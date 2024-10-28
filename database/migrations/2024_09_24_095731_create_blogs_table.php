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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->string('slug')->nullable();
            $table->string('author_name')->nullable();
            $table->string('image')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('content');
            $table->string('category_id')->nullable();;
            $table->text('tags')->nullable(); 
            $table->tinyInteger('status')->default(1)->comment('1 = active, 0 = inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
