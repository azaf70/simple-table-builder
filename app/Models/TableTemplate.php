<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TableTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'table_templates';

    public function user() {
        return $this->belongsTo(User::class);
    }

}
