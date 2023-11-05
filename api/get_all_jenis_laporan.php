<?php
require '../functions/all_functions.php';
$rows = [];
if($result = mysqli_query($conn, "SELECT*FROM db_jenis_laporan")){
  while ($row = mysqli_fetch_assoc($result)) {
    $row["nama"] = decryptDES($row["nama"]);
    $rows[] = $row;
  }
  mysqli_close($conn);
  echo json_encode($rows);
}