<?php

namespace App\Models;

use App\Enums\DbePersonnelStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class DbePersonnel extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    
    
    protected $fillable = [
        'name',
        'designation',
        'employee_status',
        'status',
        'profile_photo_path'
    ];

    public function fsr()
    {
        return $this->hasOne(Fsr::class);
    }

    // public function fsrs()
    // {
    //     return $this->hasMany(Fsr::class);
    // }

    public function fsrs()
    {
        return $this->belongsToMany(Fsr::class, 'fsr_personnels')->withPivot(['order'])->withTimestamps();
    }

    // protected $casts =  [
    //     'status' => DbePersonnelStatus::class
    // ];
}
