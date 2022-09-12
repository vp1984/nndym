<?php

namespace App\Exports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CityExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return City::where(['city.deleted' => 0])
            ->join('states','states.id','=','city.state_id')
            ->join('countries','countries.id','=','states.country_id')
            ->select('city.name','states.name as state','countries.name as country', DB::raw('CASE WHEN city.status = 1 THEN "Active" ELSE "Inactive" END as status'))           
            ->where('city.deleted',0)
            ->get();
    }
    public function headings(): array
    {
        return [
            'Name',
            'State',
            'Country',
            'Status'
        ];
    }
}
