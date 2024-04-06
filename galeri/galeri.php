<?php 

session_start();
require '../functions/functions.php';

$agenda = query("SELECT agenda.nama_acara, galeri.gambar 
        FROM galeri
        JOIN agenda ON galeri.kode_unix = agenda.kode_unix;
");



?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/png" href="../images/perhutani favicon.png" sizes="16x16">

    <title>Iwan Agenda - Perhutani</title>

    <!-- Custom fonts for this template-->
    

    <?php  require '../functions/link_css.php'; ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php  require '../functions/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button> 

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-success" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
 

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Galeri Foto</h1>
                    <p class="mb-4"> </p>

                    <!-- DataTales Example -->

                         

                    <div class="container-lg gallery min-vh-100">

                        <div class="row gy-4 row-cols-1 row-cols-sm-2 row-cols-md-3 mt-2">

                            <?php foreach( $agenda as $row ) : ?>

                                <div class="col">
                                    <a href="../images/foto/<?= $row["gambar"]; ?>" data-lightbox="models" data-title="<?= $row["nama_acara"]; ?>">
                                        <img src="../images/foto/<?= $row["gambar"]; ?>" class="gallery-item" alt="gallery">
                                    </a>
     

                                    <p class="galeri-caption"> <?= $row["nama_acara"]; ?> </p>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php  require '../functions/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a> 

    <?php  require '../functions/link_js.php'; ?>

</body>

</html>