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
        'status',
        'area_id',
        'file_id',
    ];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function areas() {
        return $this->hasMany(Area::class);
    }

    public function files() {
        return $this->hasMany(File::class);
    }
}
