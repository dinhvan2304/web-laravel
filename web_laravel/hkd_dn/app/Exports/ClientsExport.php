<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use Carbon\Carbon;

class ClientsExport implements FromCollection, WithHeadings
{
    protected $start_day;
    protected $end_day;
    function __construct($start_day, $end_day) {
        $this->start_day = $start_day;
        $this->end_day = $end_day;
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $clients = DB::table('clients');
        $clients = $clients->whereBetween('created_date', [$this->start_day, $this->end_day])->get();
        $data = [];
        foreach($clients as $key => $value) {
            array_push($data, [
                'id' => $key+1,
                'vi_name' => $value->vi_name,
                'mst' => $value->mst,
                'city' => $value->city,
                'location' => $value->location,
                'manager_name' => $value->manager_name,
                'phone' => $value->phone,
                'email' => $value->email,
                'created_date' => $value->created_date
            ]);
        }
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'STT',
            'Tên',
            'Mã số thuế',
            'Tỉnh thành',
            'Địa chỉ',
            'Tên người đại diện',
            'Số điện thoại',
            'Email',
            'Ngày thành lập',
        ];
    }

}
