<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'phone', 'email', 'address', 'company_id'];

    // Foreign Relationship - Many Contacts to 1 Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Foreign Relationship - 1 Contact to Many Tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    
}
