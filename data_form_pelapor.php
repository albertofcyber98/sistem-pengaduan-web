<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pelapor') {
    header('Location: ./index.php');
}
require './functions/all_functions.php';
$usernameCol = $_SESSION['username'];
$datas = query_data("SELECT*FROM db_form_pelaporan WHERE username_pelapor='$usernameCol'");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Pelapor</title>
    <?php
    require 'views/link.php';
    ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        $page = 4;
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
                    <h1 class="h3 mb-2 text-gray-800">Data Form Pelaporan</h1>

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
                                                <td class="text-center" colspan="8">No Data</td>
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
                                                    <td class="align-middle"><a href="./files/<?= decryptAES($data['bukti']) ?>" class="btn btn-sm btn-info">Unduh Bukti</a></td>
                                                    <td class="align-middle"><span class="badge <?= decryptAES($data['status']) == 'finish' ? 'badge-success' : 'badge-warning' ?>"><?= decryptAES($data['status']) ?></span></td>
                                                    <td class="align-middle">
                                                        <?php
                                                        if (decryptAES($data['status']) != 'finish') {
                                                        ?>
                                                            <button class="btn btn-sm btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $data['id']; ?>">Hapus</button>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <!-- Start update modal -->
                                                    <div class="modal fade" id="modalUbah<?= $data['id']; ?>" role="dialog">
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
                                                                        $edits = query_data("SELECT * FROM db_form_pelaporan WHERE id='$id'");
                                                                        foreach ($edits as $edit) :
                                                                        ?>
                                                                            <input type="hidden" name="id" value="<?= $edit['id']; ?>">
                                                                            <input type="hidden" name="bukti" value="<?= $edit['bukti']; ?>">
                                                                            <p>Yakin untuk menghapus form pelaporan ?</p>
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
                                                    <h5 class="modal-title">Tambah Laporan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="#" autocomplete="off" id="daftarForm" enctype="multipart/form-data">                                                        
                                                        <div class="form-group row mt-3">
                                                            <label class="col-4 col-form-label">Nama Pelapor</label>
                                                            <div class="col-8">
                                                                <input type="text" class="form-control" name="nama_terlapor" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mt-3">
                                                            <label class="col-4 col-form-label">Jenis Laporan</label>
                                                            <input type="hidden" name="username" value="<?= $usernameCol ?>">
                                                            <div class="col-8">
                                                                <select class="form-control" name="jenis_laporan">
                                                                    <option selected>--Pilih--</option>
                                                                    <?php
                                                                    $checkJenisLaporans = query_data("SELECT*FROM db_jenis_laporan");
                                                                    foreach ($checkJenisLaporans as $checkJenisLaporan) :
                                                                    ?>
                                                                        <option value="<?= $checkJenisLaporan['nama'] ?>"><?= decryptDES($checkJenisLaporan['nama']) ?></option>
                                                                    <?php
                                                                    endforeach;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mt-3">
                                                            <label class="col-4 col-form-label">Bukti</label>
                                                            <div class="col-8">
                                                                <input type="file" class="form-control" name="bukti" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mt-3">
                                                            <label class="col-4 col-form-label">SKPD</label>
                                                            <div class="col-8">
                                                                <select class="form-control" name="skpd">
                                                                    <option selected>--Pilih--</option>
                                                                    <?php
                                                                    $checkSKPDs = query_data("SELECT*FROM db_skpd");
                                                                    foreach ($checkSKPDs as $checkSKPD) :
                                                                    ?>
                                                                        <option value="<?= $checkSKPD['nama'] ?>"><?= decryptDES($checkSKPD['nama']) ?></option>
                                                                    <?php
                                                                    endforeach;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mt-3">
                                                            <label class="col-4 col-form-label">Jabatan</label>
                                                            <div class="col-8">
                                                                <input type="text" class="form-control" name="jabatan" required>
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
        if (add_form($_POST) > 0) {
            echo '
                <script type="text/javascript">
                    swal({
                        title: "Berhasil",
                        text: "Berhasil Ditambahkan",
                        icon: "success",
                        showConfirmButton: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.replace("data_form_pelapor.php");
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
                            window.location.replace("data_form_pelapor.php");
                        }
                    });
                </script>
            ';
        }
    }
    if (isset($_POST['delete'])) {
        if (delete_form($_POST) > 0) {
            echo '
                <script type="text/javascript">
                    swal({
                        title: "Berhasil",
                        text: "Berhasil Dihapus",
                        icon: "success",
                        showConfirmButton: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.replace("data_form_pelapor.php");
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
                            window.location.replace("data_form_pelapor.php");
                        }
                    });
                </script>
            ';
        }
    }
    ?>



</body>

</html>