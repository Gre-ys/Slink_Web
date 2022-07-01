<?php
// Nyalakan Session
session_start();

// Import Mailer
require_once '../vendor/autoload.php';

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

// Koneksi ke DB
$conn = mysqli_connect("localhost", "root", "", "slink_web");

// Fungsi Read/Get Data
function queryGetData($query)
{
  global $conn;
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

  $rows = [];
  while ($tmp = mysqli_fetch_assoc($result)) {
    $rows[] = $tmp;
  }
  mysqli_free_result($result);
  mysqli_next_result($conn);
  return $rows;
}

// Fungsi Ambil Data Post
function getPosts($limit)
{
  // Query
  $query = "CALL getPosts($limit)";

  // Eksekusi Query
  return queryGetData($query);
}

function getTopPosts()
{
  // Query
  $query = "CALL getTopPosts()";

  // Eksekusi Query
  return queryGetData($query);
}

// Fungsi Ambil Data Post Sesuai Id
function getPostById($post_id)
{
  // Query
  $query = "CALL getPostById($post_id)";

  // Return
  return queryGetData($query);
}

// Fungsi Ambil Data Posts Sesuai User(CMS)
function getPostsByUser($user_id)
{
  // Query
  $query = "CALL getPostsByUser($user_id)";

  // Eksekusi Query
  return queryGetData($query);
}

// Fungsi Ambil Data Category
function getCategory()
{
  // Query
  $query = "CALL getCategory()";

  // Eksekusi Query
  return queryGetData($query);
}

//Fungsi Ambil Data Posts Sesuai Category
function getPostsByCategory($cat_id)
{
  // Query
  $query = "CALL getPostsByCategory($cat_id)";

  // Eksekusi Query
  return queryGetData($query);
}

// Fungsi Ambil Data Posts Milik Follower dan Following 
function getPostsByFollows($user_id)
{
  $query = "CALL getPostsByFollows($user_id)";

  return queryGetData($query);
}

// Fungsi Cari Data Post
function searchPosts($keyword)
{
  $query = "SELECT posts.id, posts.judul, posts.deskripsi, posts.link, users.username, posts.waktu_aksi, category.nama FROM posts INNER JOIN users ON posts.user_id = users.id INNER JOIN category ON posts.cat_id = category.id WHERE posts.judul LIKE '%$keyword%' OR posts.deskripsi LIKE '%$keyword%'  OR users.username LIKE '%$keyword%' ORDER BY posts.waktu_aksi DESC";

  return queryGetData($query);
}

// Fungsi Tambah/Buat Data Post
function createPost($data)
{
  global $conn;

  // Pass Data ke Var untuk Diproses 
  $judul = htmlspecialchars($data["judul"]);
  $deskripsi = htmlspecialchars($data["deskripsi"]);
  $link = htmlspecialchars($data["link"]);
  $user_id = (int)htmlspecialchars($data["user_id"]);
  $cat_nama = htmlspecialchars($data["category"]);

  // Cek Field Diisi atau Tidak... Menghindari Inputan Berupa Whitespace(' ')
  if (ctype_space($judul) || ctype_space($deskripsi) || ctype_space($link)) {
    return ["error_space" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Isi Field Dengan Benar!</strong> Jangan Isi Field dengan whitespace/spasi Saja
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  // Cek Link
  if (filter_var($link, FILTER_VALIDATE_URL) === false) {
    return ["error_link" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>URL Tidak Valid!</strong> Silahkan Masukan URL Dengan Format yang Benar Http/Https/Localhost DLL
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }


  // Cek Category Sudah Ada Atau Belum
  if ($cek = queryGetData("SELECT * FROM category WHERE nama = '$cat_nama'")) {
    $cat_id = $cek[0]['id'];
    $query = "INSERT INTO posts VALUES (NULL,'$judul','$deskripsi', '$link', NOW(), '$user_id', '$cat_id')";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    // Jika Berhasil
    return ["success_create" => "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Post Berhasil Dibuat!</strong> Ayo Buat Lebih Banyak Post
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>"];
    exit;
  }

  // Jika Category Belum Ada
  $query = "INSERT INTO category VALUES(NULL, '$cat_nama')";
  mysqli_query($conn, $query) or die(mysqli_error($conn));
  $cek = queryGetData("SELECT * FROM category WHERE nama = '$cat_nama'");
  $cat_id = $cek[0]['id'];
  $query2 = "INSERT INTO posts VALUES (NULL,'$judul','$deskripsi', '$link', NOW(), '$user_id', '$cat_id')";
  mysqli_query($conn, $query2) or die(mysqli_error($conn));

  // Jika Berhasil
  return ["success_create" => "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Post Berhasil Dibuat!</strong> Ayo Buat Lebih Banyak Post
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
  exit;
}

// Fungsi Update Data Post
function updatePost($data)
{
  global $conn;

  // Pass Data ke Var untuk Diproses 
  $id = (int)htmlspecialchars($data["id"]);
  $judul = htmlspecialchars($data["judul"]);
  $deskripsi = htmlspecialchars($data["deskripsi"]);
  $link = htmlspecialchars($data["link"]);
  $cat_nama = htmlspecialchars($data["category"]);

  // Cek Field Diisi atau Tidak... Menghindari Inputan Berupa Whitespace(' ')
  if (ctype_space($judul) || ctype_space($deskripsi) || ctype_space($link)) {
    return ["error_space" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Isi Field Dengan Benar!</strong> Jangan Isi Field dengan whitespace/spasi Saja
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>"];
    exit;
  }

  // Cek Link
  if (filter_var($link, FILTER_VALIDATE_URL) === false) {
    return ["error_link" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>URL Tidak Valid!</strong> Silahkan Masukan URL Dengan Format yang Benar Http/Https/Localhost DLL 
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  // Cek Category Sudah Ada Atau Belum
  if ($cek = queryGetData("SELECT * FROM category WHERE nama = '$cat_nama'")) {
    $cat_id = $cek[0]['id'];
    $query = "UPDATE posts SET judul = '$judul', deskripsi = '$deskripsi', link = '$link', waktu_aksi = NOW(), cat_id = '$cat_id' WHERE id = $id";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    // Jika Berhasil
    return ["success_update" => "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Post Berhasil Diupdate!</strong> Ayo Buat Post Sesempurna Mungkin
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>"];
    exit;
  }

  // Jika Category Belum Ada
  $query = "INSERT INTO category VALUES(NULL, '$cat_nama')";
  mysqli_query($conn, $query) or die(mysqli_error($conn));
  $cek = queryGetData("SELECT * FROM category WHERE nama = '$cat_nama'");
  $cat_id = $cek[0]['id'];
  $query2 = "UPDATE posts SET judul = '$judul', deskripsi = '$deskripsi', link = '$link', waktu_aksi = NOW(), cat_id = '$cat_id' WHERE id = $id";
  mysqli_query($conn, $query2) or die(mysqli_error($conn));

  // Jika Berhasil
  return ["success_update" => "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Post Berhasil Diupdate!</strong> Ayo Buat Post Sesempurna Mungkin
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>"];
  exit;
}


// Fungsi Hapus Data Post
function deletePost($id)
{
  global $conn;

  // Eksekusi Query
  mysqli_query($conn, "DELETE FROM posts WHERE id = $id") or die(mysqli_error($conn));

  // Jika Berhasil
  return ["success_delete" => "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Post Berhasil Dihapus!</strong> Tetap Semangat Bikin Post Ya
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
}

// Fungsi Cari Data Post Milik Sendiri Berdasarkan Keyword 
function searchPostsPrivate($keyword, $user_id)
{
  // Query Cari Data

  $query = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.id WHERE users.id = $user_id AND (posts.judul LIKE '%$keyword%' OR posts.deskripsi LIKE '%$keyword%')";

  // Eksekusi Query untuk Menggunakan Fungsi Get Data
  return queryGetData($query);
}

// Fungsi Kirim Email
function sendMail($email, $subject, $html)
{
  $transport = Transport::fromDsn('smtp://slinkweb012@gmail.com:ssyzcescdkvaurtt@smtp.gmail.com:465');
  $mailer = new Mailer($transport);
  $emailSend = (new Email());
  $emailSend->from('slinkweb012@gmail.com');
  $emailSend->to($email);
  $emailSend->subject($subject);
  $emailSend->html($html);
  $mailer->send($emailSend);
  return ["send" => true];
}

// Fungsi Kirim Recovery Password Link
function sendRecovery($email)
{
  $email = htmlspecialchars($email);

  // Cek Email Valid atau Tidak
  if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    return ["error_emailVal" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Email Tidak Valid!</strong> Silahkan Gunakan Email yang Benar
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>"];
    exit;
  }

  // Cek User Ada atau Tidak
  if ($cek = queryGetData("SELECT * FROM users WHERE email = '$email'")) {

    // Cek User Verified atau Tidak
    if ($cek[0]['verified'] == 0) {
      return ["error_verified" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Akun Belum Terverifikasi!</strong> Silahkan Verifikasi Lebih Dulu
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>"];
      exit;
    }

    // Hash Email
    $key = hash('sha256', $cek[0]['username']);

    // Pengiriman Email
    $subject = "Recovery Password Akun Slink";
    $html = '<h3>Tekan Tombol atau Akses Link Dibawah untun Melakukan</h3>
    <button type="button"><a href="http://localhost/Slink_Web/2.%20Slink%20UAS/src/recovery.php?key=' . $key . '"></a>Go</button>
    <h5>Silahkan Masuk Ke Halaman <a href="http://localhost/Slink_Web/2.%20Slink%20UAS/src/recovery.php?key=' . $key . '">Recovery</a></h5>';

    $status = sendMail($email, $subject, $html);

    // Cek Email Terkirim atau Tidak
    if (!isset($status["send"])) {
      return ["error_send" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Email Gagal Dikirim!</strong> Silahkan Coba Lagi Setelah Beberapa Saat
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
      exit;
    }

    return ["success" => "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Email Recovery Berhasil Dikirim!</strong> Silahkan Akses Link untuk Recovery Password yang Sudah Dikirimkan Ke Email
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>"];
    exit;
  }

  // Saat User Tidak Ada
  return ["error_user" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Akun Dengan Email Tersebut Tidak Ditemukan!</strong> Silahkan Gunakan Email yang Terdaftar pada Akun yang Telah Registrasi
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
  exit;
}

// Fungsi Recovery Password
function recovery($data, $key)
{
  global $conn;

  $username = htmlspecialchars($data['username']);
  $password = htmlspecialchars(mysqli_real_escape_string($conn, $data['password']));
  $passwordCon = htmlspecialchars(mysqli_real_escape_string($conn, $data['passwordCon']));

  // Cek Field Diisi atau Tidak... Menghindari Inputan Berupa Whitespace(' ')
  if (ctype_space($username) || ctype_space($password) || ctype_space($passwordCon)) {
    return ["error_space" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Isi Field Dengan Benar!</strong> Jangan Isi Field dengan whitespace/spasi Saja
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>"];
    exit;
  }

  // Cek Username Ada atau Tidak
  if ($cek = queryGetData("SELECT * FROM users WHERE username = '$username'")) {

    // Cek Username Cocok dengan Recovery Email Key
    if ($key == hash('sha256', $username)) {

      // Cek Apakah Password Kurang dari 8 Karakter atau Tidak
      if (strlen($password) < 8) {
        return ["error_pass" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Password Tidak Boleh Kurang Dari 8 Karakter!</strong> Silahkan Tambah Karakter untuk Password
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
        exit;
      }

      // Cek Apakah Konfirmasi Password Benar
      if ($password !== $passwordCon) {
        return ["error_passCon" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Konfirmasi Password Salah!</strong> Silahkan Masukan Password yang Sudah diisi Di Field Sebelumnya
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
        exit;
      }

      // Hash Password
      $hashformat = "2y$10$";
      $salt = "willyoumarrymeyeahjust";
      $hash_and_salt = $hashformat . $salt;
      $password = crypt($password, $hash_and_salt);

      // Ganti Password
      $query = "UPDATE users SET password = '$password' WHERE username = '$username'";
      mysqli_query($conn, $query) or die(mysqli_error($conn));
      return ["success" => "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Password Berhasil Diperbaharui!</strong>
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>"];
    }

    return ["error_key" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Recovery Tidak Bisa Dilakukan!</strong> Gunakan Username Akun yang Tertaut Dengan Email Penerima Link Recovery
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }
  return ["error_user" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Akun Tidak Ditemukan!</strong> Masukan Username Akun yang Benar dan Sesuai Email
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>"];
  exit;
}

// Fungsi Kirim  OTP
function sendOTP($email)
{
  global $conn;

  // Cek Email Valid atau Tidak
  if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    return ["error_emailVal" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Email Tidak Valid!</strong> Silahkan Gunakan Email yang Benar/Valid
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>"];
    exit;
  }

  // Cek User Ada atau Tidak
  if ($cek = queryGetData("SELECT * FROM users WHERE email = '$email'")) {

    // Cek Status User Verified atau Belum
    if ($cek[0]['verified'] == 1) {
      return ["error_verified" => "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
      <strong>Akun Sudah Terverifikasi!</strong> Silahkan Langsung Saja Login
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
      exit;
    }

    // Buat Kode OTP
    $generator = "1357902468";
    $otp = "";

    for ($i = 1; $i <= 6; $i++) {
      $otp .= substr($generator, (rand() % (strlen($generator))), 1);
    }

    // Masukan User dan OTP ke Tabel otp
    $query = "INSERT INTO otp VALUES('$email','$otp')";
    mysqli_query($conn, $query) or die(mysqli_error($conn));

    // Pengiriman Email
    $subject = "Kode OTP Verifikasi Akun Slink";
    $html = '<h3>Selamat Bergabung Menjadi Bagian Dari Keluarga Besar Slink...</h3>
    <h4>' . $otp . '</h4>
    <h5>Silahkan Masukan Kode Berikut Ke Halaman <a href="http://localhost/Slink_Web/2.%20Slink%20UAS/src/verifikasi.php">Verifikasi</a></h5>';
    $status = sendMail($email, $subject, $html);

    // Cek Email Terkirim atau Tidak
    if (!isset($status["send"])) {
      return ["error_send" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Email Gagal Dikirim!</strong> Pastikan Koneksi Stabil dan Silahkan Coba Lagi Setelah Beberapa Saat
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>"];
      exit;
    }

    return ["success" => "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>OTP Berhasil Dikirim!</strong> Silahkan verifikasi Akun Menggunakan <strong>Email</strong>, dan Kode <strong>OTP</strong> yang Sudah Dikirim ke Email
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>"];
    exit;
  }

  // Saat User Tidak Ada
  return ["error_user" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Akun Dengan Email Tersebut Tidak Ditemukan!</strong> Silahkan Gunakan Email yang Terdaftar pada Akun yang Telah Registrasi
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>"];
  exit;
}

// Fungsi Verifikasi
function verifikasi($data)
{
  global $conn;

  $email = htmlspecialchars($data['email']);
  $otp = htmlspecialchars($data['otp']);


  // Cek Email Valid atau Tidak
  if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    return ["error_emailVal" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Email Tidak Valid!</strong> Silahkan Gunakan Email yang Benar
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>"];
    exit;
  }

  if (ctype_space($otp)) {
    return ["error_space" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Isi Field Dengan Benar!</strong> Jangan Isi Field dengan whitespace/spasi Saja
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>"];
    exit;
  }

  // Cek User Ada atau Tidak
  if ($cek = queryGetData("SELECT * FROM users WHERE email = '$email'")) {

    // Cek Status User Verified atau Belum
    if ($cek[0]['verified'] == 1) {
      return ["error_verified" => "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>Akun Sudah Terverifikasi Sebelumnya!</strong> Silahkan Langsung Saja Login
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>"];
      exit;
    }

    // Cek Kesesuaian User dan OTP
    if ($cek2 = queryGetData("SELECT * FROM otp WHERE email = '$email' AND otp_code = '$otp'")) {
      // Hapus User dan OTP ke dari Tabel otp
      $query = "DELETE FROM otp WHERE email = '$email' AND otp_code = '$otp'";
      $query2 = "DELETE FROM otp WHERE email = '$email'";
      mysqli_query($conn, $query) or die(mysqli_error($conn));
      mysqli_query($conn, $query2) or die(mysqli_error($conn));
      return ["success" => "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Akun Berhasil Terverifikasi!</strong> Selamat Anda Sudah Resmi Menjadi Bagian dari Keluarga Besar <strong>Slink</strong>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
      exit;
    }

    return ["error_otp" => "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
    <strong>Email dan Kode OTP Tidak Cocok!</strong> Silahkan Masukan Kode OTP yang Tertera Pada Email Terkait
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>"];
    exit;
  }

  // Saat User Tidak Ada
  return ["error_user" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Akun Dengan Email Tersebut Tidak Ditemukan!</strong> Silahkan Gunakan Email yang Terdaftar pada Akun yang Telah Registrasi
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>"];
  exit;
}

// Fungsi Registrasi
function register($data)
{

  global $conn;


  $nama = htmlspecialchars(stripslashes($data["nama"]));
  $email = htmlspecialchars(stripslashes($data["email"]));
  $username = htmlspecialchars(stripslashes($data["username"]));
  $password = htmlspecialchars(mysqli_real_escape_string($conn, $data["password"]));
  $passwordCon = htmlspecialchars(mysqli_real_escape_string($conn, $data["passwordCon"]));

  // Cek Field Diisi atau Tidak... Menghindari Inputan Berupa Whitespace(' ')
  if (ctype_space($nama) || ctype_space($email) || ctype_space($username) || ctype_space($password) || ctype_space($passwordCon)) {
    return ["error_space" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Isi Field Dengan Benar!</strong> Jangan Isi Field dengan whitespace/spasi Saja
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  // Cek Username Menggunakan Space atau Tidak
  if ($username == trim($username) && strpos($username, " ") !== false) {
    return ["error_space2" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Username Dilarang Menggunakan Space!</strong> Jangan Isi Field Username dengan Space
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>"];
    exit;
  }

  // Cek Username Digunakan atau Belum
  if (queryGetData("SELECT * FROM users WHERE username = '$username'")) {
    return ["error_username" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Username Sudah Digunakan!</strong> Silahkan Gunakan Username Lain
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  // Cek Email Valid atau Tidak
  if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    return ["error_emailVal" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Email Tidak Valid!</strong> Silahkan Gunakan Email yang Benar
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  // Cek Email Digunakan atau Belum
  if (queryGetData("SELECT * FROM users WHERE email = '$email'")) {
    return ["error_emailUni" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Email Sudah Digunakan!</strong> Silahkan Gunakan Email Lain
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  // Cek Apakah Password Kurang dari 8 Karakter atau Tidak
  if (strlen($password) < 8) {
    return ["error_password" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Password Tidak Boleh Kurang Dari 8 Karakter!</strong> Silahkan Tambah Karakter untuk Password
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  // Cek Apakah Konfirmasi Password Benar
  if ($password !== $passwordCon) {
    return ["error_passwordCon" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Konfirmasi Password Salah!</strong> Silahkan Masukan Password yang Sudah diisi Di Field Sebelumnya
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  //Menencrypt password pengguna
  $hashformat = "2y$10$";
  $salt = "willyoumarrymeyeahjust";
  $hash_and_salt = $hashformat . $salt;
  $password = crypt($password, $hash_and_salt);

  // // Enkripsi Password Standar
  // $password = password_hash($password, PASSWORD_DEFAULT);

  // Query Insert Data
  $query = "INSERT INTO users VALUES(NULL, '$nama', NULL, '$email', '$username', '$password', NOW(), NULL, '0')";

  // Eksekusi Query
  mysqli_query($conn, $query) or die(mysqli_error($conn));

  // Kirim Email Berisi Kode OTP
  $status = sendOTP($email);

  // Cek Email Terkirim atau Tidak
  if (isset($status["error_send"])) {
    return ["error_send" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Email Gagal Dikirim!</strong> Silahkan Coba Lagi Setelah Beberapa Saat
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  // Cek Berhasil atau Tidak
  return ["success" => "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Registrasi Berhasil!</strong> Silahkan verifikasi Akun Menggunakan <strong>Email</strong> ini, dan Kode <strong>OTP</strong> yang Sudah Dikirim ke Email
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
}

// Fungsi Login
function login($data)
{
  $username = htmlspecialchars($data["username"]);
  $password = htmlspecialchars($data["password"]);

  // Cek Username
  if ($cek = queryGetData("SELECT * FROM users WHERE username = '$username'")) {

    // Cek Password
    if (password_verify($password, $cek[0]["password"])) {

      // Cek User Verifikasi atau Belum
      if ($cek[0]['verified'] != 1) {
        return ["error_verified" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Akun Belum Terverifikasi!</strong> Silahkan <a href='./verifikasi.php'>Verifikasi</a> Terlebih Dahulu
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>"];
        exit;
      }

      // Set Session
      $_SESSION["login"] = true;
      $_SESSION["user_id"] = $cek[0]["id"];

      if (isset($data['remember'])) {
        setcookie('user_id', $cek[0]['id'], time() + 250);
        setcookie('key', hash('sha256', $cek['0']['username']), time() + 250);
      }

      header("Location: home.php");
      exit();
    }

    return ["error" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Username atau Password Salah!</strong>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }
  return ["error" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Username atau Password Salah!</strong>
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>"];
  exit;
}

// Fungsi Logout
function logout()
{

  // Hapus Session
  $_SESSION['login'] = false;
  session_unset();
  session_destroy();


  // Hapus Cookie
  setcookie('user_id', '', time() - 3600);
  setcookie('key', '', time() - 3600);

  header('location: ../index.php');
}

// Fungsi Menghitung Jumlah Like di Post
function getPostLikes($post_id)
{
  global $conn;

  // Query Hitung Like
  $query = "SELECT getPostLikes($post_id)";

  // Eksekusi Query
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $rows = mysqli_fetch_array($result);
  return $rows[0];
}

// Fungsi Cek Post di Like atau Belum
function checkPostLiked($user_id, $post_id)
{
  global $conn;

  // Query Hitung Like
  $query = "SELECT checkPostLiked($user_id, $post_id)";

  // Eksekusi Query
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $rows = mysqli_fetch_array($result);
  if ($rows[0] > 0) {
    return true;
  } else {
    return false;
  }
}

function checkPostBookmarked($user_id, $post_id)
{
  global $conn;

  // Query Hitung Like
  $query = "SELECT checkPostBookmarked($user_id, $post_id)";

  // Eksekusi Query
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $rows = mysqli_fetch_array($result);
  if ($rows[0] > 0) {
    return true;
  } else {
    return false;
  }
}


//Fungsi untuk Ambil Komentar
function getComments($post_id)
{
  global $conn;

  $query = "CALL getComments($post_id, 0)";
  $commentsData = queryGetData($query);
  $comments = '';

  foreach ($commentsData as $comment) {
    if ($comment["foto"] == "" || empty($comment["foto"]) || $comment["foto"] == null) {
      $comment['foto'] = "user.png";
    }
    $comments .= '
                                    <div class="mb-3">
                                        <div class="d-flex flex-start">
                                            <img class="rounded-circle shadow-1-strong me-3" src="../Foto/' . $comment['foto'] . '" alt="avatar" width="65" height="65" />
                                            <div class="flex-grow-1 flex-shrink-1">
                                                <div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="mb-1">
                                                            ' . $comment['username'] . ' <span class="small">- ' . $comment['waktu_komentar'] . '</span>
                                                        </p>
                                                    </div>
                                                    <p class="small mb-0">
                                                        ' . $comment['komentar'] . '
                                                    </p>
                                                    <button type="button" name="reply" class="btn btn-primary btn-sm text-white reply" id="' . $comment['id'] . '">Reply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ';
    $comments .= getCommentReply($conn, $post_id, $comment["id"]);
  }
  echo $comments;
}

//Fungsi Ambil Reply Komentar
function getCommentReply($conn, $post_id, $parent_comment_id = 0, $marginLeft = 0)
{
  $comments = '';
  $query = "CALL getComments($post_id, $parent_comment_id)";
  $commentsData = queryGetData($query);

  if ($parent_comment_id == 0) {
    $marginLeft = 0;
  } else {
    $marginLeft = $marginLeft + 80;
  }
  if (sizeof($commentsData) > 0) {
    foreach ($commentsData as $comment) {
      if ($comment["foto"] == "" || empty($comment["foto"]) || $comment["foto"] == null) {
        $comment['foto'] = "user.png";
      }
      $comments .= '
      <div class="mb-3 w-75" style="margin-left: ' . $marginLeft . 'px;">
                                        <div class="d-flex flex-start">
                                            <img class="rounded-circle shadow-1-strong me-3" src="../Foto/' . $comment['foto'] . '" alt="avatar" width="65" height="65" />
                                            <div class="flex-grow-1 flex-shrink-1">
                                                <div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="mb-1">
                                                            ' . $comment['username'] . ' <span class="small">- ' . $comment['waktu_komentar'] . '</span>
                                                        </p>
                                                    </div>
                                                    <p class="small mb-0">
                                                        ' . $comment['komentar'] . '
                                                    </p>
                                                    <button type="button" name="reply" class="btn btn-primary btn-sm text-white reply" id="' . $comment['id'] . '">Reply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
      $comments .= getCommentReply($conn, $post_id, $comment["id"],  $marginLeft);
    }
  }
  return $comments;
}

//Fungsi Membuat Komentar
function createComment($data)
{
  global $conn;

  // Pass Data ke Var untuk Diproses 
  $post_id = (int)htmlspecialchars($data["post_id"]);
  $user_id = (int)htmlspecialchars($data["user_id"]);
  $parent_comment_id = (int)htmlspecialchars($data["parent_comment_id"]);
  $comment = htmlspecialchars($data["comment"]);

  // Cek Field Diisi atau Tidak... Menghindari Inputan Berupa Whitespace(' ')
  if (ctype_space($comment)) {
    return ["error_space" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Isi Field Dengan Benar!</strong> Jangan Isi Field dengan whitespace/spasi Saja
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  $query = "INSERT INTO comments VALUES(NULL, '$comment', '$post_id', '$user_id', '$parent_comment_id', NOW())";

  mysqli_query($conn, $query) or die(mysqli_error($conn));

  // return mysqli_affected_rows($conn);

  // Cek Berhasil atau Tidak
  return ["success" => "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>comment Berhasil Dibuat!</strong>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
}

//Fungsi Ambil Data untuk Profile
function getProfile($user_id)
{
  // Query
  $query = "CALL getProfile($user_id)";

  // Eksekusi Query
  return queryGetData($query);
}

// Fungsi untuk Update Profile
function updateProfile($data, $img, $user_id)
{
  global $conn;

  $nama = $data['nama'];
  $username = $data['username'];
  $bio = $data['bio'];

  // Cek Field Diisi atau Tidak... Menghindari Inputan Berupa Whitespace(' ')
  if (ctype_space($nama) ||  ctype_space($username) || ctype_space($bio)) {
    return ["error_space" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Isi Field Dengan Benar!</strong> Jangan Isi Field dengan whitespace/spasi Saja
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>"];
    exit;
  }


  // Cek Username Digunakan atau Belum
  if (queryGetData("SELECT * FROM users WHERE username = '$username' AND id != $user_id")) {
    return ["error_username" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Username Sudah Digunakan!</strong> Silahkan Gunakan Username Lain
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>"];
    exit;
  }

  // Cek Username Menggunakan Space atau Tidak
  if ($username == trim($username) && strpos($username, " ") !== false) {
    return ["error_space2" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Username Dilarang Menggunakan Space!</strong> Jangan Isi Field Username dengan Space
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>"];
    exit;
  }

  $foto = $img['image']['name'];
  $foto_temp = $img['image']['tmp_name'];

  // Jika Tidak Update Foto Maka Gunakan Foto yang Sudah Ada
  if (empty($foto)) {
    $profile = getProfile($user_id);
    $foto = $profile[0]['foto'];
  }

  $query = "UPDATE users SET nama = '{$nama}', ";
  $query .= "username = '{$username}', ";
  $query .= "foto = '{$foto}', ";
  $query .= "bio = '{$bio}' WHERE id = $user_id ";

  mysqli_query($conn, $query) or die(mysqli_error($conn));

  move_uploaded_file($foto_temp, "../Foto/$foto");


  // Cek Berhasil atau Tidak
  return ["success" => "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Profile Berhasil di Update!</strong>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>"];
  exit;
}

// Fungsi untuk Menghapus Akun
function deleteAccount($user_id, $text, $validation_text)
{
  global $conn;

  if ($text === $validation_text) {
    $query = "DELETE FROM users WHERE id = $user_id";
    $delete_account = mysqli_query($conn, $query);

    if (!$delete_account) {
      die(mysqli_error($conn));
    }


    echo "
    <script>
    Swal.fire({
      icon: 'success',
      title: 'Akun Terhapus',
      confirmButtonText: 'OK',
      showCloseButton: true,
    })
    </script>
    ";

    logout();
  } else {
    return  ["error_kalimat" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Kalimat Tidak Sesuai!</strong>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>"];
    exit;
  }
}

// Fungsi untuk  Mengambil Data Bookmark
function getBookmarks($user_id)
{
  $query = "CALL getBookmarks($user_id)";

  return queryGetData($query);
}

// Fungsi untuk Cek User di Follow atau Belum
function checkFollows($other_id, $user_id)
{
  global $conn;

  // Query Hitung Like
  $query = "SELECT checkFollows ($other_id, $user_id)";

  // Eksekusi Query
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $rows = mysqli_fetch_array($result);
  if ($rows[0] > 0) {
    return true;
  } else {
    return false;
  }
}

//Fungsi untuk Ambil Data Follower
function getFollowers($user_id, $check_id)
{
  $query = "CALL getFollowers($user_id)";

  $followers = queryGetData($query);

  if (sizeof($followers) > 0) {
    $followersHtml = '';
    foreach ($followers as $follower) {
      $followCondition = (checkFollows($follower['user_id'], $check_id)) ? "<button type='button' class='col-3 btn btn-outline-danger follow_button' data-id='" . $follower['user_id'] . "'>Unfollow</button>" : "<button type='button' class='col-3 btn btn-primary follow_button' data-id='" . $follower['user_id'] . "'>Follow</button>";
      $followersHtml .= '
      <div class="card mb-2">
          <div class="card-body d-flex">
            <a target="_blank" href="./user.php?username=' . $follower['username'] . '" class="col-9 row text-decoration-none text-reset">
                  <div class="col-2">
                      <img class="rounded-circle shadow-1-strong me-3" src="../Foto/' . $follower['foto'] . '" alt="avatar" width="50" height="50" />
                  </div>
                  <h6 class="col-4">' . $follower['username'] . '</h6>
                  <div class="col-2">
                      <h7 class="text-center bi bi-heart-fill text-danger"></h7>
                      <span class="mx-1">' . $follower['jml_like'] . '</span>
                  </div>
                  <div class="col-2 ">
                      <h7 class="text-center bi bi-card-heading text-primary"></h7>
                      <span class="mx-1">' . $follower['jml_post'] . '</span>
                  </div>
              </a>
              ' . $followCondition . '
          </div>
      </div>';
    }
    return $followersHtml;
    exit;
  } else {
    return "<h6>Tidak Memiliki Follower</h6>";
    exit;
  }
}

//Fungsi untuk Ambil Data Following
function getFollowings($user_id, $check_id)
{
  $query = "CALL getFollowings($user_id)";

  $followings = queryGetData($query);

  if (sizeof($followings) > 0) {
    $followingsHtml = '';
    foreach ($followings as $following) {
      $followCondition = (checkFollows($following['user_id'], $check_id)) ? "<button type='button' class='col-3  btn btn-outline-danger follow_button' data-id='" . $following['user_id'] . "'>Unfollow</button>" : "<button type='button' class='col-3 btn btn-primary follow_button' data-id='" . $following['user_id'] . "'>Follow</button>";
      $followingsHtml .= '
      <div class="card mb-2">
          <div class="card-body d-flex">
            <a target="_blank" href="./user.php?username=' . $following['username'] . '" class="col-9 row text-decoration-none text-reset">
                  <div class="col-2">
                      <img class="rounded-circle shadow-1-strong me-3" src="../Foto/' . $following['foto'] . '" alt="avatar" width="50" height="50" />
                  </div>
                  <h6 class="col-4">' . $following['username'] . '</h6>
                  <div class="col-2">
                      <h7 class="text-center bi bi-heart-fill text-danger"></h7>
                      <span class="mx-1">' . $following['jml_like'] . '</span>
                  </div>
                  <div class="col-2 ">
                      <h7 class="text-center bi bi-card-heading text-primary"></h7>
                      <span class="mx-1">' . $following['jml_post'] . '</span>
                  </div>
              </a>
                ' . $followCondition . '
          </div>
      </div>';
    }
    return $followingsHtml;
    exit;
  } else {
    return "<h6>Tidak Mengikuti Siapa Pun</h6>";
    exit;
  }
}

// Ambil Data Rekomendasi Follow
function getRekFollows($user_id)
{

  $query = "CALL getRekFollows($user_id)";

  return queryGetData($query);
}

// Ambil Data Leaderboard
function leaderboard($user_id)
{
  // Query
  $query = "CALL leaderboard($user_id)";


  // Eksekusi Query
  return queryGetData($query);
}

// Membuat Chat di Diskusi
function createChat($data)
{
  global $conn;

  // Pass Data ke Var untuk Diproses 
  $text = htmlspecialchars($data["text"]);
  $user_id = $_SESSION['user_id'];

  // Cek Field Diisi atau Tidak... Menghindari Inputan Berupa Whitespace(' ')
  if (ctype_space($text) || empty($text) || $text == NULL) {
    return ["error_space" => "<script type='text/javascript'>Write Something?;</script>"];
    exit;
  }

  // Jika Category Belum Ada
  $query = "INSERT INTO chatall VALUES(NULL, '{$text}', $user_id, now()) ";
  mysqli_query($conn, $query) or die(mysqli_error($conn));
}

// Transfer Data ke Akun Lain
function transferData($data)
{
  global $conn;

  // Ambil Data
  $username_sendiri = htmlspecialchars(stripslashes($data["username_sendiri"]));
  $password_sendiri = htmlspecialchars(mysqli_real_escape_string($conn, $data["password_sendiri"]));
  $email_sendiri = htmlspecialchars(stripslashes($data["email_sendiri"]));
  $username_target = htmlspecialchars(stripslashes($data["username_target"]));
  $password_target = htmlspecialchars(mysqli_real_escape_string($conn, $data["password_target"]));
  $email_target = htmlspecialchars(stripslashes($data["email_target"]));

  // Hash Password untuk Pengecekan di DB
  $hashformat = "2y$10$";
  $salt = "willyoumarrymeyeahjust";
  $hash_and_salt = $hashformat . $salt;
  $password_sendiri = crypt($password_sendiri, $hash_and_salt);
  $password_target = crypt($password_target, $hash_and_salt);

  // Cek Field Diisi atau Tidak... Menghindari Inputan Berupa Whitespace(' ')
  if (ctype_space($username_sendiri) || ctype_space($password_sendiri) || ctype_space($email_sendiri) || ctype_space($username_target) || ctype_space($password_target) || ctype_space($email_target)) {
    return ["error_space" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Isi Field Dengan Benar!</strong> Jangan Isi Field dengan whitespace/spasi Saja
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  // Cek Username Sendiri Benar Atau Tidak 
  if (!queryGetData("SELECT * FROM users WHERE username = '$username_sendiri'")) {
    return ["error_username_sendiri" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Username Tidak Ditemukan!</strong> Silahkan Masukan Username yang Benar
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  // Cek Username Target Benar Atau Tidak 
  if (!queryGetData("SELECT * FROM users WHERE username = '$username_target'")) {
    return ["error_username_target" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Username Tidak Ditemukan!</strong> Silahkan Masukan Username yang Benar
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  // Cek Username Sendiri dan Target Sama Atau Tidak
  if ($username_sendiri == $username_target) {
    return ["error_username_sama" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Username Sama!</strong> Username Sendiri dan Target Tidak Boleh Sama
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>"];
    exit;
  }


  // Cek Email Sendiri Valid atau Tidak
  if (filter_var($email_sendiri, FILTER_VALIDATE_EMAIL) === false) {
    return ["error_emailVal_sendiri" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Email Tidak Valid!</strong> Silahkan Gunakan Email yang Benar
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  // Cek Email Sendiri Ada atau Tidak
  if (!queryGetData("SELECT * FROM users WHERE email = '$email_sendiri'")) {
    return ["error_email_sendiri" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Email Tidak Ditemukan!</strong> Silahkan Masukan Email dengan Benar
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  // Cek Email Target Valid atau Tidak
  if (filter_var($email_target, FILTER_VALIDATE_EMAIL) === false) {
    return ["error_emailVal_target" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Email Tidak Valid!</strong> Silahkan Gunakan Email yang Benar
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  // Cek Email Target Ada atau Tidak
  if (!queryGetData("SELECT * FROM users WHERE email = '$email_target'")) {
    return ["error_email_target" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Email Tidak Ditemukan!</strong> Silahkan Masukan Email dengan Benar
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  // Cek Email Sendiri dan Target Sama Atau Tidak
  if ($email_sendiri == $email_target) {
    return ["error_email_sama" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Email Sama!</strong> Email Sendiri dan Target Tidak Boleh Sama
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }

  //Query
  $hasil = queryGetData("CALL transfer_data('$username_sendiri', '$email_sendiri', '$password_sendiri', '$username_target', '$email_target', '$password_target')");

  // Status
  if ($hasil[0]['status'] == "Berhasil!") {
    logout();
    return ["success" => "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Transfer Data Berhasil!</strong>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  } else {
    return ["error_sql" => "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>" . $hasil[0]['status'] . "</strong>
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"];
    exit;
  }
}

function getUsers($user_id)
{
  $query = "SELECT id, username FROM users WHERE id NOT IN ('$user_id')";

  return queryGetData($query);
}
