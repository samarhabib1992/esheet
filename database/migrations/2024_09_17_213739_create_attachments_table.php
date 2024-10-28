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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('attachment_name', 255)->nullable(); // Name of the attachment
            $table->string('attachment_path', 255)->nullable(); // Path to the attachment
            $table->string('attachment_type')->nullable(); // Type of the attachment
            $table->string('attachment_size')->nullable(); // Size of the attachment
            $table->morphs('attachable'); // Polymorphic relation fields (attachable_id, attachable_type)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
