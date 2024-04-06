<?php 

session_start();

if( isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions/functions.php';

if( isset($_POST["register"]) ) {

    if( registrasi($_POST) > 0 ) {
        echo "<script>
                alert('Anda berhasil terdaftar. Silakan masuk menggunakan akun Anda.');
                document.location.href = 'login.php';
              </script>";
    } else {
        echo mysqli_error($conn);
    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/png" href="images/perhutani favicon.png" sizes="16x16">

    <title>Iwan Agenda - Perhutani</title>

    <?php  require 'functions/link_css.php'; ?>

</head>

<body class="bg-gradient-success">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form action="" method="post" class="user">

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" placeholder="nama" name="nama">
                                </div>
                                
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" placeholder="email" name="email">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" placeholder="Password" name="password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" placeholder="Repeat Password" name="password2">
                                    </div>
                                </div>
                                <hr>

                                <button type="submit" name="register" class="btn btn-success btn-user btn-block">Register</button>
                                
                            </form>
                            <hr>
                            
                            <div class="text-center">
                                <a class="small text-success" href="login.php"  >Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <?php  require 'functions/link_js.php'; ?>

</body>

</html>