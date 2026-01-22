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
        Schema::create('orderline_entities', function (Blueprint $table) {
            $table->id();
            $table->string('product_id', 36);
            $table->integer('quantity', false, true);
            $table->foreignUuid('order_id')->constrained('order_entities', 'id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderline_entities');
    }
};
