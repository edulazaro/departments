<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Concerns\HasSearchText;

class Department extends Model
{
    use HasFactory, HasSearchText;

    public function child(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_departments');
    }
}
