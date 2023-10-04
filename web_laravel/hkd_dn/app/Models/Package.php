<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Package
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
class Package extends Model
{
    use SoftDeletes;


    public $table = 'thong_tin_goi_thau';
    
    public $timestamps = false;


    protected $dates = ['deleted_at'];



    public $fillable = [
        'hinh_thuc_tb',
        'loai_tb',
        'so_tbmt',
        'so_hieu_khlcnt',
        'ten_khlcnt',
        'linh_vuc',
        'ben_moi_thau',
        'ten_goi_thau',
        'phan_loai',
        'ten_du_toan',
        'nguon_von',
        'loai_hop_dong',
        'hinh_thuc_lcnt',
        'phuong_thuc_lcnt',
        'thoi_gian_thuc_hien',
        'hinh_thuc_du_thau',
        'nhan_e_hsdt_tu_ngay',
        'nhan_e_hsdt_den_ngay',
        'hieu_luc_e_hsdt',
        'dia_diem_nhan_hsdt',
        'thoi_diem_dong_mo_thau',
        'dia_diem_mo_thau',
        'gia_du_toan',
        'tien_dbdt',
        'hinh_thuc_dbdt',
        'trang_thai',
        'gia_goi_thau',
        'don_vi_trung_thau',
        'gia_trung_thau',
        'ngay_phe_duyet',
        'link',
        'deleted',
        'dia_diem_thuc_hien',
        'send_mail_id',
        'company_id',
        'so_tbmt_version',
        'competitor_id',
        'services',
        'services_by_name',
        'services_by_scope',
        'timestamp',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'hinh_thuc_tb' => 'string',
        'loai_tb' => 'string',
        'so_tbmt' => 'string',
        'so_hieu_khlcnt' => 'string',
        'ten_khlcnt' => 'string',
        'linh_vuc' => 'string',
        'ben_moi_thau' => 'string',
        'ten_goi_thau' => 'string',
        'phan_loai' => 'string',
        'ten_du_toan' => 'string',
        'nguon_von' => 'string',
        'loai_hop_dong' => 'string',
        'hinh_thuc_lcnt' => 'string',
        'phuong_thuc_lcnt' => 'string',
        'thoi_gian_thuc_hien' => 'string',
        'hinh_thuc_du_thau' => 'string',
        'nhan_e_hsdt_tu_ngay' => 'string',
        'nhan_e_hsdt_den_ngay' => 'string',
        'hieu_luc_e_hsdt' => 'string',
        'dia_diem_nhan_hsdt' => 'string',
        'thoi_diem_dong_mo_thau' => 'string',
        'dia_diem_mo_thau' => 'string',
        'gia_du_toan' => 'string',
        'tien_dbdt' => 'string',
        'hinh_thuc_dbdt' => 'string',
        'trang_thai' => 'string',
        'gia_goi_thau' => 'string',
        'don_vi_trung_thau' => 'string',
        'gia_trung_thau' => 'string',
        'ngay_phe_duyet' => 'string',
        'link' => 'string',
        'deleted' => 'string',
        'dia_diem_thuc_hien' => 'string',
        'send_mail_id' => 'string',
        'company_id' => 'string',
        'so_tbmt_version' => 'string',
        'competitor_id' => 'string',
        'services' => 'string',
        'services_by_name' => 'string',
        'services_by_scope' => 'string',
        'timestamp' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
