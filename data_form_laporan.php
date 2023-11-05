<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pegawai') {
    header('Location: ./index.php');
}
require './functions/all_functions.php';
$usernameCol = $_SESSION['username'];
$datas = query_data("SELECT*FROM db_form_pelaporan");
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
        $page = 7;
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
                    <h1 class="h3 mb-2 text-gray-800">Data Form Laporan</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Terlapor</th>
                                            <th>Jenis Laporan</th>
                                            <th>SKPD</th>
                                            <th>Jabatan</th>
                                            <th>Bukti</th>
                                            <th>Status</th>
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
                                                    <td class="align-middle"><?= decryptAES($data['nama_terlapor']) ?></td>
                                                    <td class="align-middle"><?= decryptDES($data['jenis_laporan']) ?></td>
                                                    <td class="align-middle"><?= decryptDES($data['skpd']) ?></td>
                                                    <td class="align-middle"><?= decryptAES($data['jabatan']) ?></td>
                                                    <td class="align-middle"><a href="./files/<?= decryptAES($data['bukti']) ?>" class="btn btn-sm btn-secondary">Unduh Bukti</a></td>
                                                    <td class="align-middle"><span class="badge <?= decryptAES($data['status']) == 'finish' ? 'badge-success' : 'badge-warning' ?>"><?= decryptAES($data['status']) ?></span></td>
                                                    <td class="align-middle">
                                                        <?php
                                                        if (decryptAES($data['status']) != 'finish') {
                                                        ?>
                                                            <button class="btn btn-sm btn-info mb-1" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $data['id']; ?>">Ubah</button>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <!-- Start update modal -->
                                                    <div class="modal fade" id="modalUbah<?= $data['id']; ?>" role="dialog">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Update Data</h5>
                                                                    <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form role="form" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
                                                                        <?php
                                                                        $id = $data['id'];
                                                                        $edits = query_data("SELECT * FROM db_form_pelaporan WHERE id='$id'");
                                                                        foreach ($edits as $edit) :
                                                                        ?>
                                                                            <input type="hidden" name="id" value="<?= $edit['id']; ?>">
                                                                            <div class="form-group row mt-3">
                                                                                <label class="col-4 col-form-label">Hasil Investivigasi</label>
                                                                                <div class="col-8">
                                                                                    <input type="file" class="form-control" name="hasil" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="flex text-center mt-4 mb-3">
                                                                                <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                                                                <button type="submit" name="update" class="btn btn-info ml-2">Update</button>
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
    if (isset($_POST['update'])) {
        if (update_form($_POST) > 0) {
            echo '
                <script type="text/javascript">
                    swal({
                        title: "Berhasil",
                        text: "Berhasil Dihapus",
                        icon: "success",
                        showConfirmButton: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.replace("data_form_laporan.php");
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
                            window.location.replace("data_form_laporan.php");
                        }
                    });
                </script>
            ';
        }
    }
    ?>



</body>

</html>