<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\leadsModel;
use App\Models\ProjectModel;
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

class ProjectExport implements
    FromCollection,
    WithHeadings,
    WithEvents,
    WithStyles,
    WithCustomStartCell
{
    protected $id_user;
    protected $tanggal;
    protected $status;
    protected $rowNumber = 1;

    protected $labelTanggal = null;
    protected $labelSales = null;
    protected $labelStatus = null;

    public function __construct($id_user = null, $status = null, $tanggal = null)
    {
        $this->id_user = $id_user;
        $this->tanggal = $tanggal;
        $this->status = $status;
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function collection()
    {
        $query = ProjectModel::with(['sales', 'produk', 'lead']);

        if ($this->id_user) {
            $query->where('id_user', $this->id_user);
            $this->labelSales = User::find($this->id_user)?->name;
        }
        if ($this->status) {
            $query->where('status_project', $this->status);
            $this->labelSales = $this->status;
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
                $item->lead->nama,
                $item->produk->nama_produk,
                $item->sales->name,
                $item->harga_jual,
                $item->pengajuan_harga,
                $item->status_project,
                Carbon::parse($item->created_at)->translatedFormat('d F Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Lead',
            'Nama Produk',
            'Nama Sales',
            'Harga Jual',
            'Harga Pengajuan',
            'Tanggal Input',
            'Status',
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

                $event->sheet->mergeCells("A{$row}:H{$row}");
                $event->sheet->setCellValue("A{$row}", 'LAPORAN DATA PROJECT');
                $row++;

                if ($this->labelTanggal) {
                    $event->sheet->mergeCells("A{$row}:H{$row}");
                    $event->sheet->setCellValue("A{$row}", 'Periode : ' . $this->labelTanggal);
                    $row++;
                }

                if ($this->labelSales) {
                    $event->sheet->mergeCells("A{$row}:H{$row}");
                    $event->sheet->setCellValue("A{$row}", 'Sales : ' . $this->labelSales);
                    $row++;
                } else {
                    $event->sheet->mergeCells("A{$row}:H{$row}");
                    $event->sheet->setCellValue("A{$row}", 'Sales : Semua Sales');
                    $row++;
                }
                if ($this->labelStatus) {
                    $event->sheet->mergeCells("A{$row}:H{$row}");
                    $event->sheet->setCellValue("A{$row}", 'Status : ' . $this->labelStatus);
                    $row++;
                } else {
                    $event->sheet->mergeCells("A{$row}:H{$row}");
                    $event->sheet->setCellValue("A{$row}", 'Status : Semua Status');
                    $row++;
                }

                $event->sheet->getStyle("A1:A{$row}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 13],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                foreach (range('A', 'H') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
