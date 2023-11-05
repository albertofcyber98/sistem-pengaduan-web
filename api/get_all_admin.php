<?php
require '../functions/all_functions.php';
$rows = [];
if($result = mysqli_query($conn, "SELECT*FROM db_akun WHERE role='L0JHQjRIODk3WmM9'")){
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  mysqli_close($conn);
  echo json_encode($rows);
}