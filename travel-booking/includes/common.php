<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set default timezone if needed (optional, uncomment if required)
// date_default_timezone_set('Asia/Ho_Chi_Minh');

// Include database connection
require_once __DIR__ . '/db.php';

// Include common functions
require_once __DIR__ . '/functions.php';

// Other common initializations can go here
?>
