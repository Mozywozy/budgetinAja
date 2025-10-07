<?php

namespace App\Imports;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Budget;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class TransactionsImport implements ToCollection, WithHeadingRow
{
    protected int $userId;
    protected int $inserted = 0;
    protected int $skipped = 0;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $tanggal   = $row['tanggal'] ?? null;
            $tipeLabel = trim((string)($row['tipe'] ?? ''));
            $kategori  = trim((string)($row['kategori'] ?? ''));
            $budget    = trim((string)($row['budget'] ?? ''));
            $jumlahRaw = $row['jumlah'] ?? null;
            $deskripsi = $row['deskripsi'] ?? null;

            if (!$tanggal || !$tipeLabel || !$kategori || !$budget || $jumlahRaw === null) {
                $this->skipped++;
                continue;
            }

            // Map label tipe ke internal
            $type = null;
            if (strcasecmp($tipeLabel, 'Pemasukan') === 0) {
                $type = 'income';
            } elseif (strcasecmp($tipeLabel, 'Pengeluaran') === 0) {
                $type = 'expense';
            } else {
                $this->skipped++;
                continue;
            }

            // Parse tanggal (support Excel serial date + dd/mm/YYYY)
            try {
                if (is_numeric($tanggal)) {
                    $dt = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal);
                    $transactionDate = \Carbon\Carbon::instance($dt)->format('Y-m-d');
                } else {
                    $tStr = trim((string)$tanggal);
                    if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{2,4}$/', $tStr)) {
                        // Jika format dd/mm/YYYY
                        $transactionDate = \Carbon\Carbon::createFromFormat('d/m/Y', $tStr)->format('Y-m-d');
                    } else {
                        $transactionDate = \Carbon\Carbon::parse($tStr)->format('Y-m-d');
                    }
                }
            } catch (\Throwable $e) {
                $this->skipped++;
                continue;
            }

            // Cari kategori by name dan user, prefer type yang cocok
            $category = \App\Models\Category::where('user_id', $this->userId)
                ->where('name', $kategori)
                ->when($type, function ($q) use ($type) {
                    return $q->where('type', $type);
                })
                ->first();

            if (!$category) {
                // fallback cari tanpa filter type
                $category = \App\Models\Category::where('user_id', $this->userId)
                    ->where('name', $kategori)
                    ->first();
            }

            if (!$category) {
                $this->skipped++;
                continue;
            }

            // Cari budget by name (fallback ke notes)
            $budgetModel = \App\Models\Budget::where('user_id', $this->userId)
                ->where('notes', $budget)
                ->first();

            if (!$budgetModel) {
                $this->skipped++;
                continue;
            }

            // Normalisasi jumlah: dukung "1.000", "1,000", "Rp 1.000,50"
            $amountStr = (string)$jumlahRaw;
            $amountStr = preg_replace('/[^\d\.,\-]/', '', $amountStr); // buang huruf/simbol selain angka, titik, koma, minus
            if (strpos($amountStr, ',') !== false && strpos($amountStr, '.') !== false) {
                // Asumsikan koma sebagai ribuan, titik sebagai desimal -> hapus semua koma
                $amountStr = str_replace(',', '', $amountStr);
            } elseif (strpos($amountStr, ',') !== false && strpos($amountStr, '.') === false) {
                // Hanya ada koma -> treat sebagai desimal (ubah ke titik)
                $amountStr = str_replace(',', '.', $amountStr);
            }
            $amount = (float)$amountStr;

            try {
                \App\Models\Transaction::create([
                    'user_id' => $this->userId,
                    'type' => $type,
                    'amount' => $amount,
                    'description' => $deskripsi,
                    'transaction_date' => $transactionDate,
                    'category_id' => $category->id,
                    'budget_id' => $budgetModel->id,
                ]);
                $this->inserted++;
            } catch (\Throwable $e) {
                $this->skipped++;
                continue;
            }
        }
    }

    public function getSummary(): array
    {
        return [
            'inserted' => $this->inserted,
            'skipped' => $this->skipped,
        ];
    }
}