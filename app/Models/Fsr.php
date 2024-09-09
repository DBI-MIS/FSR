<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Fsr extends Model
{
    use HasFactory;
    use HasFilamentComments;

    protected $casts = [
        // 'time_arrived' => 'datetime:yyyy-mm-dd hh:mm:ss', 
        // 'time_completed' => 'datetime:yyyy-mm-dd hh:mm:ss',
        // 'job_date_started' => 'date:yyyy-mm-dd', 
        // 'job_date_finished' => 'date:yyyy-mm-dd',
        'attended_to' => 'array',
    ];

    protected $fillable = [
        'fsr_no',
        'user_id',
        'time_arrived',
        'time_completed',
        'job_date_started',
        'job_date_finished',
        'project_id',
        'attended_to',
        'concerns',
        'service_rendered',
        'recommendation',
        // 'fsr_equip_replace_id',
        'response_time',
        'response_time_rate',
        'service_time',
        'service_time_rate',
        'resolution_time',
        'resolution_time_rate',
        'suggestions',
        'encoder',

        'actual_voltage_v1',
        'actual_voltage_v2',
        'actual_voltage_v3',
        'actual_amperage_v1',
        'actual_amperage_v2',
        'actual_amperage_v3',
        'voltage_imbalance',
        'current_imbalance',
        'control_voltage',

        'reading_for',
        'compressor_type',
        'refrigerant_type',
        'suction_pressure1',
        'suction_pressure2',
        'suction_pressure3',
        'suction_pressure4',
        'discharge_pressure1',
        'discharge_pressure2',
        'discharge_pressure3',
        'discharge_pressure4',
        'oil_pressure1',
        'oil_pressure2',
        'oil_pressure3',
        'oil_pressure4',
        'suction_temp1',
        'suction_temp2',
        'suction_temp3',
        'suction_temp4',
        'discharge_temp1',
        'discharge_temp2',
        'discharge_temp3',
        'discharge_temp4',
        'liquid_temp1',
        'liquid_temp2',
        'liquid_temp3',
        'liquid_temp4',
        'oil_temp1',
        'oil_temp2',
        'oil_temp3',
        'oil_temp4',
        'discharge_superheat1',
        'discharge_superheat2',
        'discharge_superheat3',
        'discharge_superheat4',
        'wcc_cooler_temp',
        'wcc_condenser_temp',
        'acc_cooler_temp',
        'acc_ambient_temp',
        'pressure_cooler_water_in',
        'pressure_condenser_water_in',
        'pressure_cooler_water_out',
        'pressure_condenser_water_out',
        'water_pressure_drop_cooler',
        'water_pressure_drop_condenser',
        'approach_condenser_cooler_temp',
        'approach_condenser_condenser_temp',
        'approach_evaporator_cooler_temp',
        'approach_evaporator_condenser_temp',
        'temp_cooler_water_in_air_in',
        'temp_cooler_water_out_air_out',
        'temp_condenser_water_in_air_in',
        'temp_condenser_water_out_air_out',

    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function personnels()
    {
        return $this->belongsToMany(DbePersonnel::class, 'fsr_personnels')->withPivot(['order'])->withTimestamps();
    }

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class, 'fsr_equipments')->withPivot(['order'])->withTimestamps();
    }


    public function replacements()
    {
        return $this->belongsToMany(FsrEquipReplace::class, 'fsr_replacements')->withPivot(['order'])->withTimestamps();
    }
}
