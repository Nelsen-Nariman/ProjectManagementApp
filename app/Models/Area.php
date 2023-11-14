<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'project_id'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function documentations() {
        return $this->hasMany(Documentation::class);
    }

}
