<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

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

    public function scopeAllowedSorts(Builder $query, string $column)
    {
        return $query->orderBy($column);
    }

    //Searching data by Companies
    public function scopeAllowedFilters(Builder $query, string $key)
    {
        if ($companyId = request()->query($key))
        {
            $query->where($key, $companyId);
        }
        return $query;
    }

    public function scopeAllowedSearch(Builder $query, array $keys)
    {
        if ($search = request()->query('search'))
        {
            foreach ($keys as $index => $key) {
                $method = $index === 0 ? 'where' : 'orWhere';
                $query->{$method}($key, "LIKE", "%{$search}%");
            }
        }
        return $query;
    }
    
}
