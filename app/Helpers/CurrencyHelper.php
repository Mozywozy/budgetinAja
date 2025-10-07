<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Nilai tukar mata uang terhadap IDR
     * Nilai ini bisa diupdate secara berkala atau diambil dari API
     */
    private static $exchangeRates = [
        'IDR' => 1,
        'USD' => 0.000064, // 1 IDR = 0.000064 USD, atau 1 USD = 15,625 IDR
        'EUR' => 0.000059, // 1 IDR = 0.000059 EUR, atau 1 EUR = 16,949 IDR
        'SGD' => 0.000086, // 1 IDR = 0.000086 SGD, atau 1 SGD = 11,628 IDR
        'MYR' => 0.00029,  // 1 IDR = 0.00029 MYR, atau 1 MYR = 3,448 IDR
    ];

    /**
     * Konversi jumlah dari IDR ke mata uang target
     *
     * @param float $amount Jumlah dalam IDR
     * @param string $targetCurrency Kode mata uang target
     * @return float
     */
    public static function convert($amount, $targetCurrency)
    {
        if (!isset(self::$exchangeRates[$targetCurrency])) {
            return $amount; // Jika mata uang tidak dikenal, kembalikan nilai asli
        }

        // Konversi dari IDR ke mata uang target
        return $amount * self::$exchangeRates[$targetCurrency];
    }

    /**
     * Format mata uang berdasarkan kode mata uang
     *
     * @param float $amount Jumlah uang dalam IDR
     * @param string $currencyCode Kode mata uang (IDR, USD, EUR, SGD, MYR)
     * @param bool $convertAmount Apakah jumlah perlu dikonversi (default: true)
     * @return string
     */
    public static function format($amount, $currencyCode, $convertAmount = true)
    {
        // Konversi jumlah jika diperlukan
        if ($convertAmount && $currencyCode !== 'IDR') {
            $amount = self::convert($amount, $currencyCode);
        }

        // Format angka dengan pemisah ribuan
        $formattedAmount = number_format($amount, 0, ',', '.');

        // Tentukan simbol dan format berdasarkan kode mata uang
        switch ($currencyCode) {
            case 'IDR':
                return "Rp. {$formattedAmount}";
            case 'USD':
                return "$ {$formattedAmount}";
            case 'EUR':
                return "€ {$formattedAmount}";
            case 'SGD':
                return "S$ {$formattedAmount}";
            case 'MYR':
                return "RM {$formattedAmount}";
            default:
                return "{$formattedAmount} {$currencyCode}";
        }
    }
}
