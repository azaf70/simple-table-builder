<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Column extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'validation_rules',
        'table_id',
    ];

    protected $casts = [
        'validation_rules' => 'json',
    ];

    public function rows()
    {
        return $this->hasMany(Row::class);
    }
}
