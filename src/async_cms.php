<?php
// Header untuk Konfigurasi Keamanan Komunikasi dan CORS Data
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Import Function
require 'function.php';

// Get Data Mahasiswa untuk Diedit Lalu Kirim dalam Bentuk JSON untuk Ditampilkan
if (isset($_POST["id"])) {
    $id = $_POST['id'];

    $post =  queryGetData("CALL getPostById($id)");
    $category = queryGetData("SELECT nama FROM category");

    $data = [
        'post' => $post[0],
        'category' => $category
    ];

    echo json_encode($data);
}
