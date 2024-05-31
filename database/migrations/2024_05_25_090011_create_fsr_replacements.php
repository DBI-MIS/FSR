<?php

use App\Models\Fsr;
use App\Models\FsrEquipReplace;
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
        Schema::create('fsr_replacements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fsr::class)->nullable();
            $table->foreignIdFor(FsrEquipReplace::class)->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fsr_replacements');
    }
};
