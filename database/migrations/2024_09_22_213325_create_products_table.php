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
            $table->string('name', 255); // Product name
            $table->decimal('price', 10, 2); // Product price
            $table->foreignId('product_type_id')->constrained('product_types')->onDelete('cascade'); // Foreign key to product type
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Foreign key to category
            $table->foreignId('topic_id')->constrained('topics')->onDelete('cascade'); // Foreign key to topic
            $table->text('description')->nullable(); // Product description
            $table->tinyInteger('status')->default(1)->comment('1 = active, 0 = inactive');
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
