<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fsr extends Model
{
    use HasFactory;
    protected $casts = [
        'time_arrived' => 'datetime:Y-m-d H:m:s', 
        'time_completed' => 'datetime:Y-m-d H:m:s',
        'job_date_started' => 'datetime:Y-m-d H:m:s',
        'job_date_finished' => 'datetime:Y-m-d H:m:s',
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
