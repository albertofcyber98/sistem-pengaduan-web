<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pegawai') {
    header('Location: ./index.php');
}
require './functions/all_functions.php';
$usernameCol = $_SESSION['username'];
$roleCheck = encryptDES($_SESSION['role']);
$datas = query_data("SELECT*FROM db_akun WHERE role='$roleCheck'");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Pegawai</title>
    <?php
    require 'views/link.php';
    ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        $page = 2;
        require 'views/sidebar.php';
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                require 'views/navbar.php';
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data Akun Pegawai</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#daftar-data">Tambah</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>No Telpon</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($datas as $data) :
                                        ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= decryptDES($data['username']) ?></td>
                                                <td><?= decryptDES($data['nama']) ?></td>
                                                <td><?= decryptDES($data['jenis_kelamin']) ?></td>
                                                <td><?= decryptDES($data['no_telpon']) ?></td>
                                                <td>
                                                    <?php
                                                    if ($usernameCol == $data['username']) {
                                                    ?>
                                                        <button class="btn btn-sm btn-info mb-1" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $data['username']; ?>">Ubah</button>
                                                    <?php

                                                    }  ?>
                                                </td>
                                                <!-- Start update modal -->
                                                <div class="modal fade" id="modalUbah<?= $data['username']; ?>" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Ubah Data</h5>
                                                                <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form role="form" action="" method="POST" autocomplete="off">
                                                                    <?php
                                                                    $username = $data['username'];
                                                                    $edits = query_data("SELECT * FROM db_akun WHERE username='$username'");
                                                                    foreach ($edits as $edit) :
                                                                    ?>
                                                                        <input type="hidden" name="username" value="<?= $edit['username']; ?>">
                                                                        <div class="form-group row mt-3">
                                                                            <label class="col-4 col-form-label">Nama</label>
                                                                            <div class="col-8">
                                                                                <input type="text" class="form-control" value="<?= decryptDES($edit['nama']) ?>" name="nama" placeholder="ex: Adi">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mt-3">
                                                                            <label class="col-4 col-form-label">Jenis Kelamin</label>
                                                                            <div class="col-8">
                                                                                <select class="form-control" name="jenis_kelamin">
                                                                                    <?php
                                                                                    $valueJK = decryptDES($edit['jenis_kelamin']);
                                                                                    if ($valueJK == 'L') {
                                                                                    ?>
                                                                                        <option value="L">L</option>
                                                                                        <option value="P">P</option>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <option value="P">P</option>
                                                                                        <option value="L">L</option>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mt-3">
                                                                            <label class="col-4 col-form-label">No Telpon</label>
                                                                            <div class="col-8">
                                                                                <input type="text" class="form-control" name="no_telpon" value="<?= decryptDES($edit['no_telpon']) ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mt-3">
                                                                            <label class="col-4 col-form-label">Password</label>
                                                                            <div class="col-8">
                                                                                <input type="password" class="form-control" name="password">
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex text-center mt-4 mb-3">
                                                                            <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                                                            <button type="submit" name="update" class="btn btn-info ml-2">Ubah</button>
                                                                        </div>
                                                                    <?php
                                                                    endforeach
                                                                    ?>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End update modal -->
                                            </tr>
                                        <?php
                                            $no++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                    <div class="modal modal-custom fade" id="daftar-data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Akun</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="#" autocomplete="off" id="daftarForm">
                                                        <div class="form-group row mt-3">
                                                            <label class="col-4 col-form-label">Username</label>
                                                            <div class="col-8">
                                                                <input type="text" class="form-control" name="username" required placeholder="ex: adi123">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mt-3">
                                                            <label class="col-4 col-form-label">Password</label>
                                                            <div class="col-8">
                                                                <input type="password" class="form-control" name="password" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mt-3">
                                                            <label class="col-4 col-form-label">Nama</label>
                                                            <div class="col-8">
                                                                <input type="text" class="form-control" name="nama" required placeholder="ex: Adi">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mt-3">
                                                            <label class="col-4 col-form-label">Jenis Kelamin</label>
                                                            <div class="col-8">
                                                                <select class="form-control" name="jenis_kelamin">
                                                                    <option selected>--Pilih--</option>
                                                                    <option value="L">L</option>
                                                                    <option value="P">P</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mt-3">
                                                            <label class="col-4 col-form-label">No Telpon</label>
                                                            <div class="col-8">
                                                                <input type="text" class="form-control" name="no_telpon" required>
                                                            </div>
                                                        </div>
                                                        <div class="text-center mt-3 mb-2">
                                                            <button type="submit" name="add" class="btn btn-info">Tambah</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php
            require 'views/footer.php';
            ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php
    require 'views/modalLogout.php';
    require 'views/script.php';
    if (isset($_POST['add'])) {
        // ini diambil dari hasil inputan form tambah
        $username = $_POST['username'];
        // cekData terkait username
        $cekData = mysqli_query($conn, "SELECT*FROM db_akun WHERE username='$username'");
        // hasil dari mysqli_num_rows itu jumlah row data didatabase
        $resultData = mysqli_num_rows($cekData);

        if ($resultData > 0) {
            echo '
            <script type="text/javascript">
                swal({
                    title: "Gagal",
                    text: "Username sudah terdaftar",
                    icon: "error",
                    showConfirmButton: true,
                }).then(function(isConfirm){
                    if(isConfirm){
                        window.location.replace("data_akun_pegawai.php");
                    }
                });
            </script>
            ';
        } else {
            if (add_akun_admin($_POST) > 0) {
                echo '
                <script type="text/javascript">
                    swal({
                        title: "Berhasil",
                        text: "Berhasil Ditambahkan",
                        icon: "success",
                        showConfirmButton: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.replace("data_akun_pegawai.php");
                        }
                    });
                </script>
            ';
            } else {
                echo '
                <script type="text/javascript">
                    swal({
                        title: "Gagal",
                        text: "Gagal Ditambahkan",
                        icon: "error",
                        showConfirmButton: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.replace("data_akun_pegawai.php");
                        }
                    });
                </script>
            ';
            }
        }
    }
    if (isset($_POST['update'])) {
        if (edit_akun_admin($_POST) > 0) {
            echo '
                <script type="text/javascript">
                    swal({
                        title: "Berhasil",
                        text: "Berhasil Diubah",
                        icon: "success",
                        showConfirmButton: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.replace("data_akun_pegawai.php");
                        }
                    });
                </script>
            ';
        } else {
            echo '
                <script type="text/javascript">
                    swal({
                        title: "Gagal",
                        text: "Gagal Diubah",
                        icon: "error",
                        showConfirmButton: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.replace("data_akun_pegawai.php");
                        }
                    });
                </script>
            ';
        }
    }
    ?>



</body>

</html>