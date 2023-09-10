<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Row extends Model
{
    use HasFactory, SoftDeletes;

    public function columns()
    {
        return $this->belongsToMany(Column::class);
    }
}
