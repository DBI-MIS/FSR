<?php

namespace App\Models;

use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // protected $guarded = [];
    protected $activities;
    protected $fillable = [
        'name',
        'warranty',
        'address',
    ];

    

    public function fsr()
    {
        return $this->hasOne(Fsr::class);
    }

    public function fsrs()
    {
        return $this->hasMany(Fsr::class);
    }


    public function equipmentprojects()
    {
        return $this->belongsToMany(Equipment::class, 'equipment_projects')->withPivot(['order'])->withTimestamps();
    }
  
}
