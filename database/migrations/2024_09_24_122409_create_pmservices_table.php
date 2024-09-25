<?php

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
        Schema::create('pmservices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class);
            $table->string('subscription')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('contract_duration')->nullable();
            $table->string('details')->nullable();
            $table->string('status')->nullable()->default('active');
            $table->string('equipment')->nullable();
            $table->integer('free_tc')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('renewal_date')->nullable();
            $table->JSON('date_slots')->nullable();
            $table->string('po_ref')->nullable();            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pmservices');
    }
};
