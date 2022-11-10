<?php

namespace App\Models;

use App\Models\Scopes\AllowedFilterSearch;
use App\Models\Scopes\AllowedSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Stmt\Return_;

class Contact extends Model
{
    use HasFactory, SoftDeletes, AllowedSort, AllowedFilterSearch;

    protected $fillable = ['first_name', 'last_name', 'phone', 'email', 'address', 'company_id', 'user_id'];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
