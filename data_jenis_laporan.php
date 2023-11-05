<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pegawai') {
    header('Location: ./index.php');
}
require './functions/all_functions.php';
$usernameCol = $_SESSION['username'];
$datas = query_data("SELECT*FROM db_jenis_laporan");
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
        $page = 6;
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
                    <h1 class="h3 mb-2 text-gray-800">Data Jenis Laporan</h1>

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
                                            <th>Nama</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($datas == []) {
                                        ?>
                                            <tr>
                                                <td class="text-center" colspan="6">No Data</td>
                                            </tr>
                                            <?php
                                        } else {
                                            $no = 1;
                                            foreach ($datas as $data) :
                                            ?>
                                                <tr>
                                                    <td class="align-middle"><?= $no ?></td>
                                                    <td class="align-middle"><?= decryptDES($data['nama']) ?></td>
                                                    <td class="align-middle">
                                                        <button class="btn btn-sm btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $data['id']; ?>">Hapus</button>
                                                    </td>
                                                    <!-- Start update modal -->
                                                    <div class="modal fade" id="modalHapus<?= $data['id']; ?>" role="dialog">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Hapus Data</h5>
                                                                    <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form role="form" action="" method="POST" autocomplete="off">
                                                                        <?php
                                                                        $id = $data['id'];
                                                                        $edits = query_data("SELECT * FROM db_jenis_laporan WHERE id='$id'");
                                                                        foreach ($edits as $edit) :
                                                                        ?>
                                                                            <input type="hidden" name="id" value="<?= $edit['id']; ?>">
                                                                            <p>Yakin untuk menghapus jenis laporan ?</p>
                                                                            <div class="flex text-center mt-4 mb-3">
                                                                                <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                                                                <button type="submit" name="delete" class="btn btn-danger ml-2">Hapus</button>
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
                                        }
                                        ?>
                                    </tbody>
                                    <div class="modal modal-custom fade" id="daftar-data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Jenis Laporan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="#" autocomplete="off" id="daftarForm">
                                                        <div class="form-group row mt-3">
                                                            <label class="col-4 col-form-label">Nama</label>
                                                            <div class="col-8">
                                                                <input type="text" class="form-control" name="nama" required>
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
        if (add_jenis_laporan($_POST) > 0) {
            echo '
                <script type="text/javascript">
                    swal({
                        title: "Berhasil",
                        text: "Berhasil Ditambahkan",
                        icon: "success",
                        showConfirmButton: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.replace("data_jenis_laporan.php");
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
                            window.location.replace("data_jenis_laporan.php");
                        }
                    });
                </script>
            ';
        }
    }
    if (isset($_POST['delete'])) {
        if (delete_jenis_laporan($_POST) > 0) {
            echo '
                <script type="text/javascript">
                    swal({
                        title: "Berhasil",
                        text: "Berhasil Dihapus",
                        icon: "success",
                        showConfirmButton: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.replace("data_jenis_laporan.php");
                        }
                    });
                </script>
            ';
        } else {
            echo '
                <script type="text/javascript">
                    swal({
                        title: "Gagal",
                        text: "Gagal Dihapus",
                        icon: "error",
                        showConfirmButton: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.replace("data_jenis_laporan.php");
                        }
                    });
                </script>
            ';
        }
    }
    ?>



</body>

</html>