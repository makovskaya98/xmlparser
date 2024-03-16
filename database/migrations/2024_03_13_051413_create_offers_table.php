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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_id');
            $table->unsignedBigInteger('feeds_id');
            $table->text('url')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency_id', 10);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->decimal('oldprice', 10, 2);
            $table->json('picture');
            $table->boolean('store');
            $table->boolean('pickup');
            $table->boolean('delivery');
            $table->string('type_prefix', '70');
            $table->string('vendor', '70');
            $table->integer('model');
            $table->string('name', '70');
            $table->integer('vendor_code');
            $table->text('description');
            $table->json('param');
            $table->foreign('feeds_id')->references('id')->on('feeds')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->timestamps();

            $table->index('external_id');
            $table->index('price');
            $table->index('currency_id');
            $table->index('category_id');
            $table->index('oldprice');
            $table->index('delivery');
            $table->index('type_prefix');
            $table->index('vendor');
            $table->index('model');
            $table->index('vendor_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
