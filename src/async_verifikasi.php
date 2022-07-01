<?php
// Header untuk Konfigurasi Keamanan Komunikasi dan CORS Data
header("Access-Control-Allow-Origin: *");

// Import Function
require 'function.php';

// Handler Kirim Email OTP
if (isset($_POST['email'])) {
    echo sendOTP($_POST['email']);
}
