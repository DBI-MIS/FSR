<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FsrEquipReplace extends Model
{
    use HasFactory;
    protected $fillable = [
        'brand',
        'model',
        'part_description',
        'part_no',
        'part_quantity',
        
    ];


    public function fsrs()
    {
        return $this->belongsToMany(Fsr::class, 'fsr_replacements')->withPivot(['order'])->withTimestamps();
    }
}
