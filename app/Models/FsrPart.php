<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FsrPart extends Model
{
    use HasFactory;
    
    protected $casts = [
        'fsr_date' => 'datetime:Y-m-d H:m:s', 
    ];

     protected $fillable = [
        'project_id',
        'fsr_id',
        'fsr_date',
        'status',
        'history',
        'findings',
        'action_done',
        'recommendation',
    ];



    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function fsr()
    {
        return $this->belongsTo(Fsr::class);
    }

}
