<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    // use HasFactory;
    use SoftDeletes;

    public $table='business';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'code',
        'parent_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'code' => 'string',
        'parent_id' => 'integer'
    ];
}
