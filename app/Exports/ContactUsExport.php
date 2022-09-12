<?php

namespace App\Exports;

use App\Models\ContactUs;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactUsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ContactUs::where(['deleted' => 0])
                ->select('name','tel','email','subject','message', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'))->get();
    }
    public function headings(): array
    {
        return [
            'Name',
            'Telephone',
            'Email',
            'Subject',
            'Message',
            'Status'
        ];
    }
}
