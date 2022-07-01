<?php
// Header untuk Konfigurasi Keamanan Komunikasi dan CORS Data
header("Access-Control-Allow-Origin: *");

// Import Function
require 'function.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['action'])) {
    $other_id = $_POST['other_id'];

    // Menentukan Query Berdasarkan Aksi
    switch ($_POST['action']) {
        case 'follow':
            $query = "INSERT INTO follows VALUES($other_id, $user_id)";
            break;

        case 'unfollow':
            $query = "DELETE FROM follows WHERE user_id = $other_id AND follower_id = $user_id";
            break;

        default:
            break;
    }

    // Eksekusi Query
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    exit;
}

if (isset($_POST["follower"])) {
    echo getFollowers($_POST['get_id'], $user_id);
}

if (isset($_POST["following"])) {
    echo getFollowings($_POST['get_id'], $user_id);
}
