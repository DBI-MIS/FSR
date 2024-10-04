<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pmservice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'date_slots' => 'array',
        'equipment' => 'array',
    ];

    protected $fillable = [
           'project_id',
           'subscription',
           'details',
           'status',
           'equipment',
           'free_tc',
           'start_date',
           'end_date',
           'renewal_date',
           'date_slots',
           'po_ref',
           'contract_type',
           'contract_duration',
    ];

    public function pm_project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
