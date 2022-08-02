<?php

namespace App\Exports;

use App\Models\Result;
use DateTime;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ResultsExport implements ShouldAutoSize, WithMapping, WithHeadings, WithEvents, FromQuery, WithCustomStartCell, WithColumnFormatting
{
    use Exportable;

    // private $courses[];
    // private $course_string;

    public function query()
    {
        return Result::query()
            ->with('courses', 'applicant')
            ->orderBy('results.applicant_id', 'asc');
    }

    public function map($result): array
    {
        // Get courses array
        foreach ($result->courses as $course) {
            $courses[] = array(
                $course->course_name,
            );
        }
        // Convert courses array to string
        $courses_string = '';
        foreach ($courses as $course) {
            foreach ($course as $name => $course_name) {
                $courses_string .= $course_name . ', ';
            }
        }

        $clean_courses = substr($courses_string, 0, -2);

        return [
            $result->applicant_id,
            $result->name,
            $result->score,
            $result->status,
            $clean_courses,
            $result->applicant->email,
            $result->applicant->phone_number,
        ];
    }

    public function headings(): array
    {
        return [
            'Control Number',
            'Name',
            'Score',
            'Status',
            'Courses',
            'Email',
            'Phone Number',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:G1')->applyFromArray([
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
            'G' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }
}
