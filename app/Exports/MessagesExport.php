<?php

namespace App\Exports;

use App\Models\Message;
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

class MessagesExport implements ShouldAutoSize, WithMapping, WithHeadings, WithEvents, FromQuery, WithCustomStartCell, WithColumnFormatting
{
    use Exportable;

    public function query()
    {
        return Message::query()
            ->orderBy('messages.created_at', 'desc');
    }

    public function map($result): array
    {
        return [
            $result->name,
            $result->contact,
            $result->inquiry,
            $result->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Contact',
            'Inquiry',
            'Date Created',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:D1')->applyFromArray([
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
            'D' => NumberFormat::FORMAT_DATE_XLSX22,
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }
}
