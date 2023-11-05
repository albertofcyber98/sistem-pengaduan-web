<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pegawai') {
    header('Location: ./index.php');
}
require './functions/all_functions.php';
$usernameCol = $_SESSION['username'];
$statusPendingCheck = encryptDES('pending');
$statusActiveCheck = encryptDES('active');
$roleCheck = encryptDES('pelapor');
$dataPendings = query_data("SELECT*FROM db_akun WHERE role='$roleCheck' AND status='$statusPendingCheck'");
$dataActives = query_data("SELECT*FROM db_akun WHERE role='$roleCheck' AND status='$statusActiveCheck'");
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
        $page = 3;
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
                    <h1 class="h3 mb-2 text-gray-800">Data Akun Pelapor Aktif</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
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
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($dataActives == []) {
                                        ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No data</td>
                                            </tr>
                                            <?php
                                        } else {
                                            $no = 1;
                                            foreach ($dataActives as $dataActive) :
                                            ?>
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <td><?= decryptDES($dataActive['username']) ?></td>
                                                    <td><?= decryptDES($dataActive['nama']) ?></td>
                                                    <td><?= decryptDES($dataActive['jenis_kelamin']) ?></td>
                                                    <td><?= decryptDES($dataActive['no_telpon']) ?></td>
                                                    <td class="text-center"><span class="badge badge-success"><?= decryptDES($dataActive['status']) ?></span></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#modalUpdateActive<?= $dataActive['username']; ?>">Unactive</button>
                                                    </td>
                                                    <!-- Start update modal -->
                                                    <div class="modal fade" id="modalUpdateActive<?= $dataActive['username']; ?>" role="dialog">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Unactive</h5>
                                                                    <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form role="form" action="" method="POST" autocomplete="off">
                                                                        <?php
                                                                        $username = $dataActive['username'];
                                                                        $edits = query_data("SELECT * FROM db_akun WHERE username='$username'");
                                                                        foreach ($edits as $edit) :
                                                                        ?>
                                                                            <input type="hidden" name="username" value="<?= $edit['username']; ?>">
                                                                            <p>Yakin untuk menonaktifkan akun ?</p>
                                                                            <div class="flex text-center mt-4 mb-3">
                                                                                <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                                                                <button type="submit" name="updateActiveToUnactive" class="btn btn-danger ml-2">Unactive</button>
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


                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800 mt-5">Data Akun Pelapor Pending</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
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
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($dataPendings == []) {
                                        ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No data</td>
                                            </tr>
                                            <?php
                                        } else {
                                            $no = 1;
                                            foreach ($dataPendings as $dataPending) :
                                            ?>
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <td><?= decryptDES($dataPending['username']) ?></td>
                                                    <td><?= decryptDES($dataPending['nama']) ?></td>
                                                    <td><?= decryptDES($dataPending['jenis_kelamin']) ?></td>
                                                    <td><?= decryptDES($dataPending['no_telpon']) ?></td>
                                                    <td class="text-center"><span class="badge badge-warning"><?= decryptDES($dataPending['status']) ?></span></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-success mb-1" data-bs-toggle="modal" data-bs-target="#modalUpdatePending<?= ($dataPending['username']); ?>">Active</button>
                                                    </td>
                                                    <!-- Start update modal -->
                                                    <div class="modal fade" id="modalUpdatePending<?= $dataPending['username']; ?>" role="dialog">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Active</h5>
                                                                    <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form role="form" action="" method="POST" autocomplete="off">
                                                                        <?php
                                                                        $username = $dataPending['username'];
                                                                        $edits = query_data("SELECT * FROM db_akun WHERE username='$username'");
                                                                        foreach ($edits as $edit) :
                                                                        ?>
                                                                            <input type="hidden" name="username" value="<?= $edit['username']; ?>">
                                                                            <p>Yakin untuk mengaktifkan akun ?</p>
                                                                            <div class="flex text-center mt-4 mb-3">
                                                                                <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                                                                <button type="submit" name="updatePendingToActive" class="btn btn-success ml-2">Active</button>
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
    if (isset($_POST['updatePendingToActive'])) {
        if (update_active_pelapor($_POST) > 0) {
            echo '
                <script type="text/javascript">
                    swal({
                        title: "Berhasil",
                        text: "Berhasil Diaktifkan",
                        icon: "success",
                        showConfirmButton: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.replace("data_akun_pelapor.php");
                        }
                    });
                </script>
            ';
        } else {
            echo '
                <script type="text/javascript">
                    swal({
                        title: "Gagal",
                        text: "Gagal Diaktifkan",
                        icon: "error",
                        showConfirmButton: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.replace("data_akun_pelapor.php");
                        }
                    });
                </script>
            ';
        }
    }
    if (isset($_POST['updateActiveToUnactive'])) {
        if (update_unactive_pelapor($_POST) > 0) {
            echo '
                <script type="text/javascript">
                    swal({
                        title: "Berhasil",
                        text: "Berhasil Dinonaktifkan",
                        icon: "success",
                        showConfirmButton: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.replace("data_akun_pelapor.php");
                        }
                    });
                </script>
            ';
        } else {
            echo '
                <script type="text/javascript">
                    swal({
                        title: "Gagal",
                        text: "Gagal Dinonaktifkan",
                        icon: "error",
                        showConfirmButton: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.replace("data_akun_pelapor.php");
                        }
                    });
                </script>
            ';
        }
    }
    ?>



</body>

</html>