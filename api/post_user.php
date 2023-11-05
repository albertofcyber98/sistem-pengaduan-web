<?php
require '../functions/all_functions.php';
$username = encryptDES($_POST['username']);
$cekData = mysqli_query($conn, "SELECT*FROM db_akun WHERE username='$username'");
$resultData = mysqli_num_rows($cekData);
if($resultData>0){
    echo json_encode(array('response' => 'usename sudah terdaftar'));
    return;
}

if(isset($_POST['username'])&&isset($_POST['nama'])&&isset($_POST['password'])&&isset($_POST['jenis_kelamin'])&&isset($_POST['no_telpon'])){
    $username = encryptDES($_POST['username']);
    $nama = encryptDES($_POST['nama']);
    $password = encryptDES($_POST['password']);
    $jenis_kelamin = encryptDES($_POST['jenis_kelamin']);
    $no_telpon = encryptDES($_POST['no_telpon']);
    $status = encryptDES('pending');
    $role = encryptDES('pelapor');
    
    // Your SQL statement with placeholders
    $sql = $conn->prepare("INSERT INTO db_akun (username, password, nama, jenis_kelamin, no_telpon, status,role) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    // Bind the parameters with the appropriate data types
    $sql->bind_param('sssssss', $username, $password, $nama, $jenis_kelamin, $no_telpon, $status, $role);
    
    // Execute the statement
    $sql->execute();
    
    if ($sql) {
        echo json_encode(array('response' => 'success'));
    } else {
        echo json_encode(array('response' => 'failed'));
    }
}else{
    echo json_encode(array('response' => 'no data'));
}
