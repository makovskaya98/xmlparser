<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_mappings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feeds_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('external_id');
            $table->foreign('feeds_id')->references('id')->on('feeds')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->timestamps();

            $table->index('feeds_id');
            $table->index('category_id');
            $table->index('external_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_mappings');
    }
};
