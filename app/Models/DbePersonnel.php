<?php

namespace App\Models;

use App\Enums\DbePersonnelStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Str;

class DbePersonnel extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    
    
    protected $fillable = [
        'name',
        'designation',
        'employee_status',
        'status',
        'profile_photo_path',
        'status_location'
    ];

    public function getProfile() 
{
    $firstLetter = Str::limit(strip_tags($this->name), 1, ''); 
    $wordsAfterPeriod = Str::after($this->name, '.'); 

    return $firstLetter . '.' . $wordsAfterPeriod; 
}


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
