<?php
$conn = mysqli_connect('localhost', 'root', '', 'db_aes_des');
// $conn = mysqli_connect('localhost', 'wbspangk', 'root', 'wbspangk_db_aes_des');
header('Access-Control-Allow-Origin: *');

$secretKey = "MySecret";
$ivDES = "12345678";
$ivAES = "1234567890123456";

function encryptDES($data)
{
  global $secretKey, $ivDES;
  $encryptedData = openssl_encrypt($data, 'DES-CBC', $secretKey, 0, $ivDES);
  return base64_encode($encryptedData);
}
function decryptDES($data)
{
  global $secretKey, $ivDES;
  $decryptedData = openssl_decrypt(base64_decode($data), 'DES-CBC', $secretKey, 0, $ivDES);
  return $decryptedData !== false ? trim($decryptedData) : null;
}

function encryptAES($data)
{
  global $secretKey, $ivAES;
  $cipherText = openssl_encrypt($data, 'aes-256-cbc', $secretKey, 0, $ivAES);
  return base64_encode($cipherText);
}

function decryptAES($encryptedData)
{
  global $secretKey, $ivAES;
  $decipherText = openssl_decrypt(base64_decode($encryptedData), 'aes-256-cbc', $secretKey, 0, $ivAES);
  return $decipherText;
}

function login_gover($params)
{
  global $conn;
  $username = encryptDES($params['username']);
  $password = encryptDES($params['password']);
  // Perintah query sql
  $query = "SELECT * FROM db_akun WHERE username='$username' AND role='L0JHQjRIODk3WmM9'";
  $get = mysqli_query($conn, $query);
  // Mengambil jumlah baris
  $result = mysqli_num_rows($get);
  // Mengambil data
  $row_account = mysqli_fetch_assoc($get);
  if ($result === 1) {
    if ($password == $row_account['password']) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}
function login_pelapor($params)
{
  global $conn;
  $username = encryptDES($params['username']);
  $password = encryptDES($params['password']);
  $status = encryptDES('active');
  // Perintah query sql
  $query = "SELECT * FROM db_akun WHERE username='$username' AND status='$status'";
  $get = mysqli_query($conn, $query);
  // Mengambil jumlah baris
  $result = mysqli_num_rows($get);
  // Mengambil data
  $row_account = mysqli_fetch_assoc($get);
  if ($result === 1) {
    if ($password == $row_account['password']) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}
function tgl_indo($tanggal)
{
  $hari = array(
    1 =>    'Senin',
    'Selasa',
    'Rabu',
    'Kamis',
    'Jumat',
    'Sabtu',
    'Minggu'
  );
  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $pecahkan = explode('-', $tanggal);

  // variabel pecahkan 0 = tanggal
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tahun

  return $hari[date('N', mktime(0, 0, 0, $pecahkan[1], $pecahkan[2], $pecahkan[0]))] . ', ' . $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function upload($data)
{
  // return false;
  $namaFile = $_FILES[$data]['name'];
  // $ukuranFile = $_FILES[$data]['size'];
  $error = $_FILES[$data]['error'];
  $tmpName = $_FILES[$data]['tmp_name'];
  // cek jika tidak ada gambar diupload

  // if ($error === 4) {
  //   echo "
  //           <script>
  //               alert('Masukkan Berkas');
  //           </script>
  //           ";
  //   return false;
  // }
  // cek yang boleh diupload
  $ekstensiFileValid = ['docx'];
  $ekstensiFile = explode('.', $namaFile);
  $ekstensiFile = strtolower(end($ekstensiFile));
  if (!in_array($ekstensiFile, $ekstensiFileValid)) {
    echo "
            <script>
                alert('Upload berkas berekstensi docx'" . $data . ");
            </script>
            ";
    return false;
  }
  // lolos pengecekan
  //generate
  $namaFileBaru = uniqid();
  $namaFileBaru .= '.';
  $namaFileBaru .= $ekstensiFile;
  move_uploaded_file($tmpName, './files/' . $namaFileBaru);
  return $namaFileBaru;
}
function uploadAPI($data)
{
  // return false;
  $namaFile = $_FILES[$data]['name'];
  // $ukuranFile = $_FILES[$data]['size'];
  $error = $_FILES[$data]['error'];
  $tmpName = $_FILES[$data]['tmp_name'];
  // cek jika tidak ada gambar diupload

  // if ($error === 4) {
  //   echo "
  //           <script>
  //               alert('Masukkan Berkas');
  //           </script>
  //           ";
  //   return false;
  // }
  // cek yang boleh diupload
  $ekstensiFileValid = ['docx'];
  $ekstensiFile = explode('.', $namaFile);
  $ekstensiFile = strtolower(end($ekstensiFile));
  if (!in_array($ekstensiFile, $ekstensiFileValid)) {
    echo "
            <script>
                alert('Upload berkas berekstensi docx'" . $data . ");
            </script>
            ";
    return false;
  }
  // lolos pengecekan
  //generate
  $namaFileBaru = uniqid();
  $namaFileBaru .= '.';
  $namaFileBaru .= $ekstensiFile;
  move_uploaded_file($tmpName, '../files/' . $namaFileBaru);
  return $namaFileBaru;
}

function query_data($params)
{
  global $conn;
  $result = mysqli_query($conn, $params);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}
function add_akun_admin($params)
{
  global $conn;
  $username = encryptDES($params['username']);
  $nama = encryptDES($params['nama']);
  $password = encryptDES($params['password']);
  $jenis_kelamin = encryptDES($params['jenis_kelamin']);
  $no_telpon = encryptDES($params['no_telpon']);
  $status = encryptDES('active');
  $role = encryptDES('pegawai');
  mysqli_query($conn, "INSERT INTO db_akun VALUES('$username','$password','$nama', '$jenis_kelamin', '$no_telpon','$status','$role')");
  return mysqli_affected_rows($conn);
}
function edit_akun_admin($params)
{
  global $conn;
  $username = $params['username'];
  $password = $params['password'];
  $jenis_kelamin = encryptDES($params['jenis_kelamin']);
  $no_telpon = encryptDES($params['no_telpon']);
  $nama = encryptDES($params['nama']);
  if ($password == '') {
    mysqli_query($conn, "UPDATE db_akun SET jenis_kelamin='$jenis_kelamin',
    no_telpon='$no_telpon',
    nama='$nama'
    WHERE username='$username'");
    return mysqli_affected_rows($conn);
  } else {
    $pass = encryptDES($params['password']);
    mysqli_query($conn, "UPDATE db_akun SET jenis_kelamin='$jenis_kelamin',
    no_telpon='$no_telpon',
    password='$pass',
    nama='$nama'
    WHERE username='$username'");
    return mysqli_affected_rows($conn);
  }
}
function add_akun_pelapor($params)
{
  global $conn;
  $username = encryptDES($params['username']);
  $nama = encryptDES($params['nama']);
  $password = encryptDES($params['password']);
  $jenis_kelamin = encryptDES($params['jenis_kelamin']);
  $no_telpon = encryptDES($params['no_telpon']);
  $status = encryptDES('pending');
  $role = encryptDES('pelapor');
  mysqli_query($conn, "INSERT INTO db_akun VALUES('$username','$password','$nama', '$jenis_kelamin', '$no_telpon','$status','$role')");
  return mysqli_affected_rows($conn);
}
function update_active_pelapor($params)
{
  global $conn;
  $username = $params['username'];
  $status = encryptDES('active');
  mysqli_query($conn, "UPDATE db_akun SET status='$status' WHERE username='$username' ");
  return mysqli_affected_rows($conn);
}
function update_unactive_pelapor($params)
{
  global $conn;
  $username = $params['username'];
  $status = encryptDES('pending');
  mysqli_query($conn, "UPDATE db_akun SET status='$status' WHERE username='$username' ");
  return mysqli_affected_rows($conn);
}
function add_skpd($params){
  global $conn;
  $nama = encryptDES($params['nama']);
  mysqli_query($conn, "INSERT INTO db_skpd VALUES(NULL,'$nama')");
  return mysqli_affected_rows($conn);
}
function delete_skpd($params){
  global $conn;
  $id = $params['id'];
  mysqli_query($conn, "DELETE FROM db_skpd WHERE id='$id'");
  return mysqli_affected_rows($conn);
}
function add_jenis_laporan($params){
  global $conn;
  $nama = encryptDES($params['nama']);
  mysqli_query($conn, "INSERT INTO db_jenis_laporan VALUES(NULL,'$nama')");
  return mysqli_affected_rows($conn);
}
function delete_jenis_laporan($params){
  global $conn;
  $id = $params['id'];
  mysqli_query($conn, "DELETE FROM db_jenis_laporan WHERE id='$id'");
  return mysqli_affected_rows($conn);
}
function add_form($params){
  global $conn;
  $jenis_laporan = $params['jenis_laporan'];
  $username_pelapor = $params['username'];
  $skpd = $params['skpd'];
  $jabatan = encryptAES($params['jabatan']);
  $nama_terlapor = encryptAES($params['nama_terlapor']);
  $bukti = encryptAES(upload('bukti'));
  $status = encryptAES('pending');
  mysqli_query($conn, "INSERT INTO db_form_pelaporan VALUES(NULL,'$username_pelapor','$nama_terlapor','$jenis_laporan','$bukti','$skpd','$jabatan','$status','')");
  return mysqli_affected_rows($conn);
}
function delete_form($params){
  global $conn;
  $bukti = decryptAES($params['bukti']);
  unlink('./files/'. $bukti);
  $id = $params['id'];
  mysqli_query($conn, "DELETE FROM db_form_pelaporan WHERE id='$id'");
  return mysqli_affected_rows($conn);
}

function update_form($params){
  global $conn;
  $id = $params['id'];
  $status = encryptAES('finish');
  $hasil = encryptAES(upload('hasil'));
  mysqli_query($conn, "UPDATE db_form_pelaporan SET status='$status', hasil_investivigasi='$hasil'  WHERE id='$id' ");
  return mysqli_affected_rows($conn);
}