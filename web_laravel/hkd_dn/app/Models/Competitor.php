<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Competitor
 * @package App\Models
 * @version December 16, 2021, 3:26 am UTC
 *
 * @property string $so_dkkd
 * @property string $name_vi
 * @property string $name_en
 * @property string $c_status
 * @property string $linh_vuc
 * @property string $loai_doanh_nghiep
 * @property string $phone
 * @property string $fax
 * @property string $c_address
 * @property string $province
 * @property string $country
 * @property string $nganh_nghe
 * @property string $c_group
 * @property string $link
 */
class Competitor extends Model
{
    use SoftDeletes;


    public $table = 'competitors';
    
    public $timestamps = false;


    protected $dates = ['deleted_at'];



    public $fillable = [
        'so_dkkd',
        'name_vi',
        'name_en',
        'c_status',
        'linh_vuc',
        'loai_doanh_nghiep',
        'phone',
        'fax',
        'c_address',
        'province',
        'country',
        'nganh_nghe',
        'c_group',
        'link'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'so_dkkd' => 'string',
        'name_vi' => 'string',
        'name_en' => 'string',
        'c_status' => 'string',
        'linh_vuc' => 'string',
        'loai_doanh_nghiep' => 'string',
        'phone' => 'string',
        'fax' => 'string',
        'c_address' => 'string',
        'province' => 'string',
        'country' => 'string',
        'nganh_nghe' => 'string',
        'c_group' => 'string',
        'link' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
