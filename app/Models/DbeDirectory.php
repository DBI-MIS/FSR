<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class DbeDirectory extends Model
{
   
    use HasFactory;

    
    protected $casts = [
        // 'contacts' => 'array',
    ];
    
    protected $fillable = [
        'project_id',
        'latest_fsr',
        'status',
    ];
    public function directoryproject()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function fsrs()
    {
        return $this->hasMany(Fsr::class);
    }

    public function contactsdbe()
    {
        return $this->belongsToMany(Contact::class, 'contacts_directory')->withTimestamps();
    }
   
  
}
