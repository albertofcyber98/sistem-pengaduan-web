<?php
require '../functions/all_functions.php';
$rows = [];
$statusPendingCheck = encryptDES('pending');
if($result = mysqli_query($conn, "SELECT*FROM db_akun WHERE role='ZmxGY25JaHVqNFE9' AND status='$statusPendingCheck'")){
  while ($row = mysqli_fetch_assoc($result)) {
    $row["username"] = decryptDES($row["username"]);
    $row["nama"] = decryptDES($row["nama"]);
    $row["jenis_kelamin"] = decryptDES($row["jenis_kelamin"]);
    $row["no_telpon"] = decryptDES($row["no_telpon"]);
    $row["status"] = decryptDES($row["status"]);
    $rows[] = $row;
  }
  mysqli_close($conn);
  echo json_encode($rows);
}