<?php

use App\Models\Fsr;
use App\Models\Project;
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
        Schema::create('fsr_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class);
            $table->foreignIdFor(Fsr::class);
            $table->date('fsr_date')->nullable();
            $table->string('status')->default('pending');
            $table->longText('history')->nullable();
            $table->longText('findings')->nullable();
            $table->longText('action_done')->nullable();
            $table->longText('recommendation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fsr_parts');
    }
};
