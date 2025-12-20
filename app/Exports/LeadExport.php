<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\leadsModel;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class LeadExport implements
    FromCollection,
    WithHeadings,
    WithEvents,
    WithStyles,
    WithCustomStartCell
{
    protected $id_user;
    protected $tanggal;
    protected $rowNumber = 1;

    protected $labelTanggal = null;
    protected $labelSales = null;

    public function __construct($id_user = null, $tanggal = null)
    {
        $this->id_user = $id_user;
        $this->tanggal = $tanggal;
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function collection()
    {
        $query = leadsModel::with('sales');

        if ($this->id_user) {
            $query->where('id_user', $this->id_user);
            $this->labelSales = User::find($this->id_user)?->name;
        }

        if ($this->tanggal) {

            if (str_contains($this->tanggal, 'to')) {
                [$from, $to] = array_map('trim', explode('to', $this->tanggal));
                $this->labelTanggal =
                    Carbon::parse($from)->translatedFormat('d F Y') .
                    ' s/d ' .
                    Carbon::parse($to)->translatedFormat('d F Y');
            } else {
                $from = $to = $this->tanggal;
                $this->labelTanggal =
                    Carbon::parse($this->tanggal)->translatedFormat('d F Y');
            }

            $query->whereBetween('created_at', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay(),
            ]);
        }

        return $query->get()->map(function ($item) {
            return [
                $this->rowNumber++,
                $item->nama,
                "'" . $item->kontak,
                $item->alamat,
                $item->kebutuhan,
                $item->sales?->name ?? '-',
                Carbon::parse($item->created_at)->translatedFormat('d F Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Lead',
            'Kontak',
            'Alamat',
            'Kebutuhan',
            'Sales',
            'Tanggal Input',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            5 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $row = 1;

                $event->sheet->mergeCells("A{$row}:G{$row}");
                $event->sheet->setCellValue("A{$row}", 'LAPORAN DATA LEADS');
                $row++;

                if ($this->labelTanggal) {
                    $event->sheet->mergeCells("A{$row}:G{$row}");
                    $event->sheet->setCellValue("A{$row}", 'Periode : ' . $this->labelTanggal);
                    $row++;
                }

                if ($this->labelSales) {
                    $event->sheet->mergeCells("A{$row}:G{$row}");
                    $event->sheet->setCellValue("A{$row}", 'Sales : ' . $this->labelSales);
                    $row++;
                } else {
                    $event->sheet->mergeCells("A{$row}:G{$row}");
                    $event->sheet->setCellValue("A{$row}", 'Sales : Semua Sales');
                    $row++;
                }

                $event->sheet->getStyle("A1:A{$row}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 13],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                foreach (range('A', 'G') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
