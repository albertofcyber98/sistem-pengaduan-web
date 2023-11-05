<?php
session_start();
require './functions/all_functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .bg-login-image-custom {
            background: url('https://images.unsplash.com/photo-1562240020-ce31ccb0fa7d?auto=format&fit=crop&q=80&w=1974&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-position: center;
            background-size: cover;
        }
    </style>

</head>

<body class="bg-gradient-info">

    <div class="container mt-5">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image-custom"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Sistem Pelaporan</h1>
                                    </div>
                                    <form method="post" action="">
                                        <div class="form-group">
                                            <select name="role" class="form-control" id="">
                                                <option selected>--Pilih--</option>
                                                <option value="pegawai">Pegawai</option>
                                                <option value="pelapor">Pelapor</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter username...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-info btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <h6 class="text-center mt-4">Tidak memiliki akun pelapor ? <span><a href="register.php">Register</a></span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>
    <script src="assets/js/sweetalert.min.js"></script>
    <?php
    if (isset($_POST['submit'])) {
        $username = encryptDES($_POST['username']);
        $role = $_POST['role'];
        if ($role == 'pegawai') {
            if (login_gover($_POST) === true) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'pegawai';
                echo '
                    <script type="text/javascript">
                        swal({
                            title: "Berhasil",
                            text: "Berhasil Login",
                            icon: "success",
                            showConfirmButton: true,
                        }).then(function(isConfirm){
                            if(isConfirm){
                                window.location.replace("dashboard.php");
                            }
                        });
                    </script>
                ';
            } else {
                echo '
                    <script type="text/javascript">
                        swal({
                            title: "Gagal",
                            text: "Gagal Login",
                            icon: "error",
                            showConfirmButton: true,
                        }).then(function (isConfirm) {
                            if (isConfirm) {
                                window.location.replace("index.php");
                            }
                        });
                    </script>
                ';
            }
        } else if ($role == 'pelapor') {
            if (login_pelapor($_POST) === true) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'pelapor';
                echo '
                    <script type="text/javascript">
                        swal({
                            title: "Berhasil",
                            text: "Berhasil Login",
                            icon: "success",
                            showConfirmButton: true,
                        }).then(function(isConfirm){
                            if(isConfirm){
                                window.location.replace("dashboard.php");
                            }
                        });
                    </script>
                ';
            } else {
                echo '
                        <script type="text/javascript">
                            swal({
                                title: "Gagal",
                                text: "Gagal Login",
                                icon: "error",
                                showConfirmButton: true,
                            }).then(function (isConfirm) {
                                if (isConfirm) {
                                    window.location.replace("index.php");
                                }
                            });
                        </script>
                    ';
            }
        }
    }
    ?>

</body>

</html>