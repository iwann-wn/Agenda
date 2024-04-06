<?php
session_start();

require 'functions/functions.php';

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$loginError = ""; // Inisialisasi pesan kesalahan

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // Cek peran pengguna
            if ($row["role"] === "admin" || $row["role"] === "user") {
                $_SESSION["login"] = true;
                $_SESSION["role"] = $row["role"]; // Set peran pengguna
                header("Location: index.php");
                exit;
            }
        }
    }

    // Set pesan kesalahan sesuai kondisi
    $loginError = "Maaf, Username & Password Tidak Sesuai.";
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

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>

                                    <?php if (!empty($loginError)) : ?>
                                        <p style="color: red; font-style: italic; font-weight: bold;">
                                            <?php echo $loginError; ?>
                                        </p>
                                    <?php endif; ?>


                                    <form class="user" action="" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                 name="email" placeholder="Enter email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
                                        </div>

                                        <hr>

                                        <button type="submit" name="login" class="btn btn-success btn-user btn-block">Login</button>
                                        
                                    </form>
                                    
                                    <hr>
                                    <div class="text-center">
                                        <a class="small text-success" href="register.php" >Create an Account!</a>
                                    </div>

                                </div>
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