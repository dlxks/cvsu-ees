<?php

namespace App\Exports;

use App\Models\Applicant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ApplicantsExport implements FromCollection, WithEvents, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return User::all();

        $data = Applicant::select(\DB::raw('applicants.id as Control_Number, 
                                            applicants.fname as First_Name, 
                                            applicants.mname as Middle_Name, 
                                            applicants.lname as Last_Name, 
                                            applicants.course_applied as Course_Applied, 
                                            applicants.email as Email, 
                                            applicants.phone_number as Phone_Number'))
            ->orderBy('applicants.id')
            ->get();

        $data = $data->each(function ($d) {
            $d->setAppends([]);
        });

        return $data;
    }

    public function headings(): array
    {
        return ['Control Number', 'First Name', 'Middle Name', 'Last Name', 'Course Applied', 'Email', 'Phone Number'];
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            // 'A' => ['font' => ['italic' => true]],

            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class =>  function (AfterSheet $event) {
                $cellRange = 'A1:F1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->getSize(12);
            },
        ];
    }
}
