<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DbeDirectory extends Model
{
   
    use HasFactory;

    
    protected $casts = [
        'contact_no' => 'array',
    ];
    
    protected $fillable = [
        'contact_no',
        'contact_person',
        'designation',
        'email_address',
        'status',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function fsrs()
    {
        return $this->hasMany(Fsr::class);
    }
}
