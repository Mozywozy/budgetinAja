<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $dateFrom;
    protected $dateTo;
    protected $userId;
    protected $search;
    protected $type;
    protected $categoryId;

    public function __construct($userId, $dateFrom, $dateTo, $search = '', $type = '', $categoryId = '')
    {
        $this->userId = $userId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->search = $search;
        $this->type = $type;
        $this->categoryId = $categoryId;
    }

    public function collection()
    {
        return Transaction::where('user_id', $this->userId)
            ->when($this->search, function ($query) {
                return $query->where('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->type, function ($query) {
                return $query->where('type', $this->type);
            })
            ->when($this->categoryId, function ($query) {
                return $query->where('category_id', $this->categoryId);
            })
            ->when($this->dateFrom, function ($query) {
                return $query->where('transaction_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                return $query->where('transaction_date', '<=', $this->dateTo);
            })
            ->with('category')
            ->orderBy('transaction_date', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Deskripsi',
            'Kategori',
            'Tipe',
            'Jumlah',
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->transaction_date,
            $transaction->description,
            $transaction->category ? $transaction->category->name : 'Tidak Ada Kategori',
            $transaction->type == 'income' ? 'Pemasukan' : 'Pengeluaran',
            'Rp ' . number_format($transaction->amount, 0, ',', '.'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}