<?php
require '../functions/all_functions.php';
$rows = [];
$statusPendingCheck = encryptDES('pending');
if($result = mysqli_query($conn, "SELECT*FROM db_akun WHERE role='ZmxGY25JaHVqNFE9' AND status='$statusActiveCheck'")){
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  mysqli_close($conn);
  echo json_encode($rows);
}