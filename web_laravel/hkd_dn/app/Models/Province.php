<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Province
 * @package App\Models
 * @version July 16, 2021, 5:54 pm UTC
 *
 * @property string $name
 * @property string $code
 * @property integer $status
 */
class Province extends Model
{
    use SoftDeletes;


    public $table = 'provinces';
    
    public $timestamps = false;


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'code',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'code' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
    protected $appends = ['status_name'];
    public function getStatusNameAttribute($value)
    {
        return ($this->status == 1?'Kích hoạt': 'Không kích hoạt');
    }

}
