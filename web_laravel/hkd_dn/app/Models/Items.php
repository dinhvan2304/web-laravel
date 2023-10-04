<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Items extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = true;
    public $table = 'category_items';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'title',
        'description',
        'code',
        'head_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'text',
        'code' => 'string',
        'parent_id' => 'integer'
    ];

}
