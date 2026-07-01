<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('destination');
            $table->string('flag')->nullable();
            $table->string('status')->default('upcoming');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('budget', 12, 2)->default(0);
            $table->decimal('spent', 12, 2)->default(0);
            $table->char('currency', 3)->default('USD');
            $table->string('cover_photo')->nullable();
            $table->text('description')->nullable();
            $table->string('transport')->nullable();
            $table->string('visibility')->default('private');
            $table->boolean('privacy_photos')->default(false);
            $table->boolean('privacy_notes')->default(false);
            $table->boolean('privacy_expenses')->default(false);
            $table->string('pref_purpose')->nullable();
            $table->string('pref_accommodation')->nullable();
            $table->string('pref_pace')->nullable();
            $table->string('pref_food_priority')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['visibility', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
