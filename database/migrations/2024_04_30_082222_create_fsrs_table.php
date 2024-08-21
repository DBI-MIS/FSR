<?php

use App\Models\DbePersonnel;
use App\Models\Equipment;
use App\Models\FsrEquipReplace;
use App\Models\NeededEquipment;
use App\Models\Project;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\PostgresGrammar;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        
        Schema::create('fsrs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fsr_no');
            $table->foreignIdFor(User::class);
            $table->time('time_arrived')->nullable();
            $table->time('time_completed')->nullable();
            $table->dateTime('job_date_started')->nullable();
            $table->dateTime('job_date_finished')->nullable();
            $table->foreignIdFor(Project::class)->nullable();
            $table->longText('attended_to')->nullable();
            $table->longText('concerns')->nullable();
            $table->longText('service_rendered')->nullable();
            $table->longText('recommendation')->nullable();
            $table->longText('response_time')->nullable();
            $table->integer('response_time_rate')->nullable();
            $table->longText('service_time')->nullable();
            $table->integer('service_time_rate')->nullable();
            $table->longText('resolution_time')->nullable();
            $table->integer('resolution_time_rate')->nullable();
            $table->longText('suggestions')->nullable();
            $table->string('encoder')->nullable();
            $table->timestamps();

            $table->string('actual_voltage_v1')->nullable();
            $table->string('actual_voltage_v2')->nullable();
            $table->string('actual_voltage_v3')->nullable();
            $table->string('actual_amperage_v1')->nullable();
            $table->string('actual_amperage_v2')->nullable();
            $table->string('actual_amperage_v3')->nullable();
            $table->string('voltage_imbalance')->nullable();
            $table->string('current_imbalance')->nullable();
            $table->string('control_voltage')->nullable();

            $table->string('reading_for')->nullable();
            $table->string('compressor_type')->nullable();
            $table->string('refrigerant_type')->nullable();
            $table->string('suction_pressure1')->nullable();
            $table->string('suction_pressure2')->nullable();
            $table->string('suction_pressure3')->nullable();
            $table->string('suction_pressure4')->nullable();
            $table->string('discharge_pressure1')->nullable();
            $table->string('discharge_pressure2')->nullable();
            $table->string('discharge_pressure3')->nullable();
            $table->string('discharge_pressure4')->nullable();
            $table->string('oil_pressure1')->nullable();
            $table->string('oil_pressure2')->nullable();
            $table->string('oil_pressure3')->nullable();
            $table->string('oil_pressure4')->nullable();
            $table->string('suction_temp1')->nullable();
            $table->string('suction_temp2')->nullable();
            $table->string('suction_temp3')->nullable();
            $table->string('suction_temp4')->nullable();
            $table->string('discharge_temp1')->nullable();
            $table->string('discharge_temp2')->nullable();
            $table->string('discharge_temp3')->nullable();
            $table->string('discharge_temp4')->nullable();
            $table->string('liquid_temp1')->nullable();
            $table->string('liquid_temp2')->nullable();
            $table->string('liquid_temp3')->nullable();
            $table->string('liquid_temp4')->nullable();
            $table->string('oil_temp1')->nullable();
            $table->string('oil_temp2')->nullable();
            $table->string('oil_temp3')->nullable();
            $table->string('oil_temp4')->nullable();
            $table->string('discharge_superheat1')->nullable();
            $table->string('discharge_superheat2')->nullable();
            $table->string('discharge_superheat3')->nullable();
            $table->string('discharge_superheat4')->nullable();
            $table->string('wcc_cooler_temp')->nullable();
            $table->string('wcc_condenser_temp')->nullable();
            $table->string('acc_cooler_temp')->nullable();
            $table->string('acc_ambient_temp')->nullable();
            $table->string('pressure_cooler_water_in')->nullable();
            $table->string('pressure_condenser_water_in')->nullable();
            $table->string('pressure_cooler_water_out')->nullable();
            $table->string('pressure_condenser_water_out')->nullable();
            $table->string('water_pressure_drop_cooler')->nullable();
            $table->string('water_pressure_drop_condenser')->nullable();
            $table->string('approach_condenser_cooler_temp')->nullable();
            $table->string('approach_condenser_condenser_temp')->nullable();
            $table->string('approach_evaporator_cooler_temp')->nullable();
            $table->string('approach_evaporator_condenser_temp')->nullable();
            $table->string('temp_cooler_water_in_air_in')->nullable();
            $table->string('temp_cooler_water_out_air_out')->nullable();
            $table->string('temp_condenser_water_in_air_in')->nullable();
            $table->string('temp_condenser_water_out_air_out')->nullable();
        });

        // Schema::create('fsr_equipment_status', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('actual_voltage_v1')->nullable();
        //     $table->string('actual_voltage_v2')->nullable();
        //     $table->string('actual_voltage_v3')->nullable();
        //     $table->string('actual_amperage_v1')->nullable();
        //     $table->string('actual_amperage_v2')->nullable();
        //     $table->string('actual_amperage_v3')->nullable();
        //     $table->string('voltage_imbalance')->nullable();
        //     $table->string('current_imbalance')->nullable();
        //     $table->string('control_voltage')->nullable();
        //     $table->timestamps();
        // });

        // Schema::create('fsr_equipment_readings', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('reading_for')->nullable();
        //     $table->string('compressor_type')->nullable();
        //     $table->string('refrigerant_type')->nullable();
        //     $table->string('suction_pressure1')->nullable();
        //     $table->string('suction_pressure2')->nullable();
        //     $table->string('suction_pressure3')->nullable();
        //     $table->string('suction_pressure4')->nullable();
        //     $table->string('discharge_pressure1')->nullable();
        //     $table->string('discharge_pressure2')->nullable();
        //     $table->string('discharge_pressure3')->nullable();
        //     $table->string('discharge_pressure4')->nullable();
        //     $table->string('oil_pressure1')->nullable();
        //     $table->string('oil_pressure2')->nullable();
        //     $table->string('oil_pressure3')->nullable();
        //     $table->string('oil_pressure4')->nullable();
        //     $table->string('suction_temp1')->nullable();
        //     $table->string('suction_temp2')->nullable();
        //     $table->string('suction_temp3')->nullable();
        //     $table->string('suction_temp4')->nullable();
        //     $table->string('discharge_temp1')->nullable();
        //     $table->string('discharge_temp2')->nullable();
        //     $table->string('discharge_temp3')->nullable();
        //     $table->string('discharge_temp4')->nullable();
        //     $table->string('liquid_temp1')->nullable();
        //     $table->string('liquid_temp2')->nullable();
        //     $table->string('liquid_temp3')->nullable();
        //     $table->string('liquid_temp4')->nullable();
        //     $table->string('oil_temp1')->nullable();
        //     $table->string('oil_temp2')->nullable();
        //     $table->string('oil_temp3')->nullable();
        //     $table->string('oil_temp4')->nullable();
        //     $table->string('discharge_superheat1')->nullable();
        //     $table->string('discharge_superheat2')->nullable();
        //     $table->string('discharge_superheat3')->nullable();
        //     $table->string('discharge_superheat4')->nullable();
        //     $table->string('wcc_cooler_temp')->nullable();
        //     $table->string('wcc_condenser_temp')->nullable();
        //     $table->string('acc_cooler_temp')->nullable();
        //     $table->string('acc_ambient_temp')->nullable();
        //     $table->string('pressure_cooler_water_in')->nullable();
        //     $table->string('pressure_condenser_water_in')->nullable();
        //     $table->string('pressure_cooler_water_out')->nullable();
        //     $table->string('pressure_condenser_water_out')->nullable();
        //     $table->string('water_pressure_drop_cooler')->nullable();
        //     $table->string('water_pressure_drop_condenser')->nullable();
        //     $table->string('approach_condenser_cooler_temp')->nullable();
        //     $table->string('approach_condenser_condenser_temp')->nullable();
        //     $table->string('approach_evaporator_cooler_temp')->nullable();
        //     $table->string('approach_evaporator_condenser_temp')->nullable();
        //     $table->string('temp_cooler_water_in_air_in')->nullable();
        //     $table->string('temp_cooler_water_out_air_out')->nullable();
        //     $table->string('temp_condenser_water_in_air_in')->nullable();
        //     $table->string('temp_condenser_water_out_air_out')->nullable();
        //     $table->timestamps();
        // });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fsrs');
        // Schema::dropIfExists('fsr_equipment_status');
        // Schema::dropIfExists('fsr_equipment_readings');
    }
};
