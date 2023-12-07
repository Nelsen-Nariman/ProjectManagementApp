<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'progress',
        'priority',
        'deadline',
        'status'
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'project_users', 'project_id', 'user_id');
    }

    public function areas() {
        return $this->hasMany(Area::class);
    }

    public function files() {
        return $this->hasMany(File::class);
    }
}
