<?php
require '../functions/all_functions.php';
$rows = [];
if($result = mysqli_query($conn, "SELECT*FROM db_form_pelaporan")){
  while ($row = mysqli_fetch_assoc($result)) {
    $row["jenis_laporan"] = decryptDES($row["jenis_laporan"]);
    $row["skpd"] = decryptDES($row["skpd"]);
    $row["jabatan"] = decryptAES($row["jabatan"]);
    $row["status"] = decryptDES($row["status"]);
    $row["username_pelapor"] = decryptDES($row["username_pelapor"]);
    $rows[] = $row;
  }
  mysqli_close($conn);
  echo json_encode($rows);
}