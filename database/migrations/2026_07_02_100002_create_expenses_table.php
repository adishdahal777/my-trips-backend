<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->char('currency', 3)->default('USD');
            $table->date('date');
            $table->string('category')->index();
            $table->string('icon')->nullable();
            $table->boolean('ai_suggested')->default(false);
            $table->boolean('is_private')->default(false);
            $table->timestamps();

            $table->index(['trip_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
