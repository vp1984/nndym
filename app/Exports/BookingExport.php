<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Booking::where(['booking.deleted' => 0])
                    ->select('order_number','booking_date','kids','coupon_code','guardian_name','guardian_mobile','guardian_alt_mobile','guardian_email','guardian_address','special_message','basepriceamt','discountamt','taxamt','totalpriceamt','area.name as area','package.name as package','city.name as city',DB::raw('CASE WHEN booking.status = 1 THEN "Active" ELSE "Inactive" END as status'))
                    ->join('city_date_package', 'city_date_package.id', '=', 'booking.package_plan')
                    ->join('package_city', 'city_date_package.package_city_id', '=', 'package_city.id')
                    ->join('package', 'package.id', '=', 'package_city.package_id')
                    ->join('city', 'city.id', '=', 'package_city.city_id')
                    ->join('area', 'area.id', '=', 'booking.area_id')
                    ->get();
    }
    public function headings(): array
    {
        return [
            'order_number',
            'booking_date',
            'kids',
            'coupon_code',
            'guardian_name',
            'guardian_mobile',
            'guardian_alt_mobile',
            'guardian_email',
            'guardian_address',
            'special_message',
            'basepriceamt',
            'discountamt',
            'taxamt',
            'totalpriceamt',
            'area',
            'package',
            'city',
            'Status',
        ];
    }
}
