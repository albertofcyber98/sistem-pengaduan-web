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

    <title>Regsitrasi</title>

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
                                        <h1 class="h4 text-gray-900 mb-4">Registrasi Akun Pelapor</h1>
                                    </div>
                                    <form method="post" action="">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="nama" required placeholder="Nama">

                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="jenis_kelamin">
                                                <option selected>--Jenis Kelamin--</option>
                                                <option value="L">L</option>
                                                <option value="P">P</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="no_telpon" placeholder="No telpon" required>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-info btn-user btn-block">
                                            Registrasi
                                        </button>
                                    </form>
                                    <h6 class="text-center mt-4">Sudah memiliki akun ? <span><a href="index.php">Login</a></span></h6>
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
        $cekData = mysqli_query($conn, "SELECT*FROM db_akun WHERE username='$username'");
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
                        window.location.replace("register.php");
                    }
                });
            </script>
            ';
        } else {
            if (add_akun_pelapor($_POST) > 0) {
                echo '
                <script type="text/javascript">
                    swal({
                        title: "Berhasil",
                        text: "Berhasil Registrasi",
                        icon: "success",
                        showConfirmButton: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            window.location.replace("index.php");
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
                                window.location.replace("register.php");
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