<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Format price based on selected currency
 * @param float $amount_vnd Amount in VND
 * @return string Formatted price with currency symbol
 */
function formatPrice($amount_vnd) {
    // Default currency is VND if not set
    $currency = $_SESSION['currency'] ?? 'VND';
    
    // Exchange rates relative to VND (hardcoded for simplicity)
    $rates = [
        'VND' => 1,
        'USD' => 25000,
        'EUR' => 27000,
        'JPY' => 170
    ];
    
    // Symbols and formatting rules
    $formats = [
        'VND' => ['symbol' => '₫', 'position' => 'after', 'decimals' => 0, 'dec_point' => ',', 'thousands_sep' => '.'],
        'USD' => ['symbol' => '$', 'position' => 'before', 'decimals' => 2, 'dec_point' => '.', 'thousands_sep' => ','],
        'EUR' => ['symbol' => '€', 'position' => 'before', 'decimals' => 2, 'dec_point' => ',', 'thousands_sep' => '.'],
        'JPY' => ['symbol' => '¥', 'position' => 'before', 'decimals' => 0, 'dec_point' => '.', 'thousands_sep' => ',']
    ];
    
    // Fallback if somehow currency is invalid
    if (!isset($rates[$currency])) {
        $currency = 'VND';
    }
    
    $rate = $rates[$currency];
    $format = $formats[$currency];
    
    // Convert
    $converted_amount = $amount_vnd / $rate;
    
    // Format
    $formatted_number = number_format($converted_amount, $format['decimals'], $format['dec_point'], $format['thousands_sep']);
    
    if ($format['position'] == 'before') {
        return $format['symbol'] . $formatted_number;
    } else {
        return $formatted_number . ' ' . $format['symbol'];
    }
}
?>
