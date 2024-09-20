<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $casts = [
        'contact_no' => 'array',
        // 'contact_person' => 'array',
    ];

    protected $fillable = [
        'dbe_directory_id', 
        'contact_no', 
        'contact_person', 
        'email_address',
        'designation'
    ];

    public function dbeDirectory()
    {
        return $this->hasMany(DbeDirectory::class, 'contacts_directory');
    }
}
