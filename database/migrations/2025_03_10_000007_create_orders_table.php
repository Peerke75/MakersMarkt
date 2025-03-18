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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maker_id')->constrained('users');
            $table->foreignId('koper_id')->constrained('users');
            $table->dateTime('completed_at')->nullable();
            $table->enum('status', ['verzonden', 'in productie', 'geweigerd, terugbetaling verzonden']);
            $table->longText('status_message')->nullable();
            $table->float('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
