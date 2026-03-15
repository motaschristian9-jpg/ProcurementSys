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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('item_code');
            $table->string('material');
            $table->string('size')->nullable();
            $table->string('unit')->nullable();
            $table->string('supplier')->nullable();
            $table->string('brand')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->string('quarter')->nullable();
            $table->date('date')->nullable();
            $table->boolean('purchased')->default(false); // Davao or Local as boolean or string? Request says "purchased" is "Davao or Local"
            $table->string('location')->nullable(); // For "Davao or Local"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
