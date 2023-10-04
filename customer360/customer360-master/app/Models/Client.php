<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Client
 * @package App\Models
 * @version December 16, 2021, 3:15 am UTC
 *
 * @property string $company_name
 * @property string $address
 * @property string $city
 * @property string $created_date
 * @property string $website
 * @property string $phone
 * @property string $company_id
 * @property string $so_dkkd
 * @property string $type_company
 */
class Client extends Model
{
    use SoftDeletes;


    public $table = 'clients';
    
    public $timestamps = false;


    protected $dates = ['deleted_at'];



    public $fillable = [
        'company_name',
        'address',
        'city',
        'created_date',
        'website',
        'phone',
        'company_id',
        'so_dkkd',
        'type_company'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_name' => 'string',
        'address' => 'string',
        'city' => 'string',
        'created_date' => 'string',
        'website' => 'string',
        'phone' => 'string',
        'company_id' => 'string',
        'so_dkkd' => 'string',
        'type_company' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
