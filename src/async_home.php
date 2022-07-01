<?php
// Header untuk Konfigurasi Keamanan Komunikasi dan CORS Data
header("Access-Control-Allow-Origin: *");

// Import Function
require 'function.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['action'])) {
    $post_id = $_POST['post_id'];

    // Menentukan Query Berdasarkan Aksi
    switch ($_POST['action']) {
        case 'like':
            $query = "INSERT INTO likes VALUES($post_id, $user_id)";
            break;

        case 'unlike':
            $query = "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id";
            break;

        case 'mark':
            $query = "INSERT INTO bookmarks VALUES($post_id, $user_id)";
            break;

        case 'unmark':
            $query = "DELETE FROM bookmarks WHERE post_id = $post_id AND user_id = $user_id";
            break;

        default:
            break;
    }

    // Eksekusi Query
    mysqli_query($conn, $query) or die(mysqli_error($conn));

    if (($_POST['action'] == "like") || ($_POST["action"] == "unlike")) {
        echo getPostLikes($post_id);
    }

    exit;
}

if (isset($_POST['getComments'])) {
    echo getComments($_POST['post_id']);
    exit;
}

if (isset($_POST['submit_comment'])) {
    echo createComment($_POST);
    exit;
}

if (isset($_POST['seeMore'])) {
    $_SESSION['limit'] += 5;
    echo $_SESSION['limit'];
    exit;
}

if (isset($_POST['seeLess'])) {
    $_SESSION['limit'] -= 5;
    echo $_SESSION['limit'];
    exit;
}
