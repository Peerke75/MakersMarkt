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
            $table->foreignId('categorie_id')->constrained();
            $table->foreignId('maker_id')->constrained('users');
            $table->string('name');
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->longText('status_change')->nullable();
            $table->text('description');
            $table->enum('production_time', ['1-3 maanden', '4-6 maanden', '7-9 maanden', '10-12 maanden']);
            $table->enum('material', ['hout', 'metaal', 'kunststof', 'glas', 'steen', 'textiel', 'leer', 'papier', 'keramiek', 'overig']);
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0);
            $table->string('image')->nullable();
            $table->string('link')->nullable();
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
