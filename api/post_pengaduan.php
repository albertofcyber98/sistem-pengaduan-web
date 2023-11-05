<?php
require '../functions/all_functions.php';
if(isset($_POST['jenis_laporan'])&&isset($_POST['username'])&&isset($_POST['skpd'])&&isset($_POST['jabatan'])&&isset($_POST['nama_terlapor'])&&isset($_FILES['bukti'])){
    $jenis_laporan = encryptDES($_POST['jenis_laporan']);
    $username_pelapor = encryptDES($_POST['username']);
    $skpd = encryptDES($_POST['skpd']);
    $jabatan = encryptAES($_POST['jabatan']);
    $nama_terlapor = encryptAES($_POST['nama_terlapor']);
    $bukti = encryptAES(uploadAPI('bukti'));
    $status = encryptAES('pending');
    
    // Your SQL statement with placeholders
    $sql = $conn->prepare("INSERT INTO db_form_pelaporan (username_pelapor, nama_terlapor, jenis_laporan, bukti, skpd, jabatan, status, hasil_investivigasi) VALUES (?, ?, ?, ?, ?, ?, ?, '')");
    
    // Bind the parameters with the appropriate data types
    $sql->bind_param('sssssss', $username_pelapor, $nama_terlapor, $jenis_laporan, $bukti, $skpd, $jabatan, $status);
    
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
