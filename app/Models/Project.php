<?php

namespace App\Models;

use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Project extends Model
{
    use HasFactory;
    use HasFilamentComments;

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
        return $this->hasOne(Fsr::class, 'project_id');
    }

    public function fsrs()
    {
        return $this->hasMany(Fsr::class);
    }
   
    public function relatedfsrs()
    {
        return $this->hasMany(Fsr::class, 'project_id');
    }
    
    public function projectdirectories()
    {
        return $this->hasMany(DbeDirectory::class, 'project_id');
    }
    public function projectdirectory()
    {
        return $this->hasOne(DbeDirectory::class, 'project_id');
    }

    public function pmsubcriptions()
    {
        return $this->hasMany(Pmservice::class, 'project_id');
    }


    // public function equipments()
    // {

    //     $fsrs = $this->fsrs()->pluck('id');

    //     return Equipment::whereHas('fsrs', function($query) use ($fsrs) {
    //         $query->whereIn('fsr_id', $fsrs);
    //     })->get();
    // }

    // public function equipmentss()
    // {
    //     return $this->hasManyThrough(Equipment::class, Fsr::class, 'project_id', 'id', 'id', 'id');
    // }

    // public function equipmentprojects()
    // {
    //     return $this->belongsToMany(Equipment::class, 'equipment_projects')->withPivot(['order'])->withTimestamps();
    // }

}
