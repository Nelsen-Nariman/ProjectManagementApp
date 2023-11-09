<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'doc',
        'project_id'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
