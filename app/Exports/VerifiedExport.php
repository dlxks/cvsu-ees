<?php

namespace App\Exports;

use App\Models\Verified;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class VerifiedExport implements ShouldAutoSize, WithMapping, WithHeadings, WithEvents, FromQuery, WithCustomStartCell, WithColumnFormatting
{
    use Exportable;

    public function query()
    {
        return Verified::query()
            ->with('applicant', 'course')
            ->orderBy('verifieds.applicant_id', 'asc');
    }

    public function map($result): array
    {
        $qual_course = "";
        if ($result->status == "not qualified") {
            $qual_course = "N/A";
        } else {
            $qual_course = $result->course_applied ." - ".$result->course->course_desc;
        }

        $crs_applied = $result->course_applied ." - ".$result->course->course_desc;

        return [
            $result->applicant_id,
            $result->name,
            $result->rating,
            $crs_applied,
            $qual_course,
            $result->status,
            $result->applicant->email,
            $result->applicant->phone_number,
        ];
    }

    public function headings(): array
    {
        return [
            'Control Number',
            'Name',
            'Rating',
            'Course Applied',
            'Qualified Course',
            'Status',
            'Email',
            'Phone Number',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:H1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_00,
            'H' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }
}
