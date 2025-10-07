<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Budget;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class TemplateTransactionsExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    protected int $userId;
    protected array $categories;
    protected array $budgets;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
        $this->categories = Category::where('user_id', $userId)
            ->orderBy('name')
            ->pluck('name')
            ->toArray();

        // Gunakan 'notes' sebagai nama Budget yang tampil (sesuai view/form)
        $this->budgets = Budget::where('user_id', $userId)
            ->orderBy('notes')
            ->pluck('notes')
            ->toArray();
    }

    public function headings(): array
    {
        return ['Tanggal', 'Tipe', 'Kategori', 'Budget', 'Jumlah', 'Deskripsi'];
    }

    public function array(): array
    {
        // Baris kosong saja (user akan mengisi sendiri)
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Sisipkan list referensi di kolom tersembunyi H-J
                // H: Tipe, I: Kategori, J: Budget
                $types = ['Pemasukan', 'Pengeluaran'];

                // Tulis list tipe
                foreach ($types as $idx => $type) {
                    $sheet->setCellValue('H' . ($idx + 1), $type);
                }

                // Tulis list kategori
                foreach ($this->categories as $idx => $cat) {
                    $sheet->setCellValue('I' . ($idx + 1), $cat);
                }

                // Tulis list budget
                foreach ($this->budgets as $idx => $bud) {
                    $sheet->setCellValue('J' . ($idx + 1), $bud);
                }

                // Sembunyikan kolom H-J (gunakan setVisible(false), bukan setHidden)
                $sheet->getColumnDimension('H')->setVisible(false);
                $sheet->getColumnDimension('I')->setVisible(false);
                $sheet->getColumnDimension('J')->setVisible(false);

                // Data validation (dropdown) untuk Tipe, Kategori, Budget
                // Range data
                $typeCount = count($types);
                $categoryCount = max(count($this->categories), 1);
                $budgetCount = max(count($this->budgets), 1);

                // Terapkan ke baris 2 s/d 500
                for ($row = 2; $row <= 500; $row++) {
                    // Tipe (kolom B) -> H1:H2
                    $dvType = $sheet->getCell('B' . $row)->getDataValidation();
                    $dvType->setType(DataValidation::TYPE_LIST);
                    $dvType->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $dvType->setAllowBlank(true);
                    $dvType->setShowDropDown(true);
                    $dvType->setFormula1('=$H$1:$H$' . $typeCount);
                    $sheet->getCell('B' . $row)->setDataValidation($dvType);

                    // Kategori (kolom C) -> I1:In
                    $dvCat = $sheet->getCell('C' . $row)->getDataValidation();
                    $dvCat->setType(DataValidation::TYPE_LIST);
                    $dvCat->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $dvCat->setAllowBlank(true);
                    $dvCat->setShowDropDown(true);
                    $dvCat->setFormula1('=$I$1:$I$' . $categoryCount);
                    $sheet->getCell('C' . $row)->setDataValidation($dvCat);

                    // Budget (kolom D) -> J1:Jm
                    $dvBudget = $sheet->getCell('D' . $row)->getDataValidation();
                    $dvBudget->setType(DataValidation::TYPE_LIST);
                    $dvBudget->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $dvBudget->setAllowBlank(true);
                    $dvBudget->setShowDropDown(true);
                    $dvBudget->setFormula1('=$J$1:$J$' . $budgetCount);
                    $sheet->getCell('D' . $row)->setDataValidation($dvBudget);
                }

                // Format kolom Tanggal (A) sebagai tanggal dan Jumlah (E) sebagai angka
                $sheet->getStyle('A2:A500')->getNumberFormat()->setFormatCode('yyyy-mm-dd');
                $sheet->getStyle('E2:E500')->getNumberFormat()->setFormatCode('#,##0.00');

                // ===== Tambahan: Rapi-kan tampilan tabel =====
                // Freeze header
                $sheet->freezePane('A2');

                // Lebar kolom
                $sheet->getColumnDimension('A')->setWidth(14); // Tanggal
                $sheet->getColumnDimension('B')->setWidth(12); // Tipe
                $sheet->getColumnDimension('C')->setWidth(24); // Kategori
                $sheet->getColumnDimension('D')->setWidth(24); // Budget
                $sheet->getColumnDimension('E')->setWidth(14); // Jumlah
                $sheet->getColumnDimension('F')->setWidth(40); // Deskripsi

                // Gaya header (bold, center, latar warna lembut)
                $headerRange = 'A1:F1';
                $sheet->getStyle($headerRange)->getFont()->setBold(true)->setSize(11);
                $sheet->getStyle($headerRange)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle($headerRange)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE9F3FF'); // biru muda lembut
                $sheet->getRowDimension(1)->setRowHeight(22);

                // Border tipis untuk area tabel
                $sheet->getStyle('A1:F500')->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
                    ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFDDDDDD'));

                // Alignment isi
                $sheet->getStyle('A2:A500')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('B2:D500')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('E2:E500')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('F2:F500')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

                // AutoFilter pada header
                $sheet->setAutoFilter('A1:F1');
                // ===== Akhir tambahan styling =====
            },
        ];
    }
}