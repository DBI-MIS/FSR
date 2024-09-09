<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $fillable = [
        'brand',
        'model',
        'description',
        'serial',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'equipment_projects')->withPivot(['order'])->withTimestamps();
    }

    public function fsrs()
    {
        return $this->belongsToMany(Fsr::class, 'fsr_equipments')->withPivot(['order'])->withTimestamps();
    }


    // public function project()
    // {
    //     return $this->hasManyThrough(Project::class, 'equipment_projects', Fsr::class, 'fsr_equipments');
    // }
}
