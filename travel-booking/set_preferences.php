<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = ['success' => false];
    
    // Validate and set currency
    if (isset($_POST['currency'])) {
        $valid_currencies = ['VND', 'USD', 'EUR', 'JPY'];
        $currency = strtoupper($_POST['currency']);
        if (in_array($currency, $valid_currencies)) {
            $_SESSION['currency'] = $currency;
            $response['success'] = true;
            $response['currency'] = $currency;
        }
    }
    
    // Validate and set location
    if (isset($_POST['location'])) {
        $valid_locations = [
            'VN' => 'VND', // Vietnam -> VND
            'US' => 'USD', // USA -> USD
            'EU' => 'EUR', // Europe -> EUR
            'JP' => 'JPY'  // Japan -> JPY
        ];
        
        $location = strtoupper($_POST['location']);
        if (array_key_exists($location, $valid_locations)) {
            $_SESSION['location'] = $location;
            // Tự động đổi tiền tệ tương ứng với vị trí nếu user muốn (hoặc ta có thể đổi luôn)
            $auto_currency = $valid_locations[$location];
            $_SESSION['currency'] = $auto_currency;
            
            $response['success'] = true;
            $response['location'] = $location;
            $response['currency'] = $auto_currency;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
