<?php 

session_start();
if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}
require 'functions/functions.php';

$agenda = query("SELECT * FROM agenda ORDER BY id DESC");

// Fungsi untuk mengambil jumlah data berdasarkan status dari tabel agenda
function getJumlahByStatus($status = '') {
    global $conn;
    if ($status !== '') {
        $query = "SELECT COUNT(*) AS jumlah FROM agenda WHERE status_acara = '$status'";
    } else {
        $query = "SELECT COUNT(*) AS jumlah FROM agenda";
    }
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['jumlah'];
}

// Mendapatkan jumlah data terlaksana
$jumlah_terlaksana = getJumlahByStatus('terlaksana');

// Mendapatkan jumlah data belum terlaksana
$jumlah_belum_terlaksana = getJumlahByStatus('belum terlaksana');

// Mendapatkan jumlah semua data 
$jumlah_semua_data = getJumlahByStatus();

// Fungsi untuk mengambil jumlah data berdasarkan bulan tertentu
function getJumlahByBulan($bulan) {
    global $conn;
    $query = "SELECT COUNT(*) AS jumlah FROM agenda WHERE bulan = '$bulan'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['jumlah'];
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


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                     
                    <img class="img-fluid " src="images/Logo_Perhutani.png" alt="...">
                    
                </div>
                <div class="sidebar-brand-text mx-3"> Perhutani <sup>Jawa Tengah</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fa-solid fa-gauge-high"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span>Agenda</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">

                        <?php 
                            if ($_SESSION["role"] === "admin") {
                                echo '<a class="collapse-item" href="agenda/tambah_agenda.php">Tambah Agenda</a>';
                            }
                        ?>
                        <a class="collapse-item" href="agenda/tabel_terlaksana.php">Agenda Terlaksana</a>
                        <a class="collapse-item" href="agenda/tabel_belum_terlaksana.php">Agenda Belum Terlaksana</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fa-regular fa-images"></i>
                    <span>Galeri</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <h6 class="collapse-header">Custom Utilities:</h6> -->
                        <a class="collapse-item" href="galeri/galeri.php">Galeri</a>

                        <!-- <a class="collapse-item" href="galeri/tambah_foto.php">Tambah Foto</a> -->
                        <!-- <a class="collapse-item" href="galeri/tabel_galeri.php">Daftar Galeri </a> -->

                        <?php 
                            if ($_SESSION["role"] === "admin") {
                                echo '<a class="collapse-item" href="galeri/tabel_galeri.php">Daftar Galeri </a>';
                            }
                        ?>

                    </div>
                </div>
            </li>
            <!-- Nav Item - Utilities Collapse Menu -->
            

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>
            

            <li class="nav-item">
                <!-- <button type="submit" name="logout">Logout</button> -->
                <a class="nav-link" href="logout.php">
                    <i class="fa-solid fa-door-open"></i>
                    <span>Logout</span>
                </a>
            </li>
            

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
            <!-- Sidebar Message -->
            

        </ul>
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

                </nav>


                <!-- start gambar -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>                                  

                </div>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12 mb-4">

                            <!-- Illustrations -->
                            <div class="card shadow mb-4">
                                
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                            src="images/home_image.svg" alt="...">
                                    </div>
                                    <p> 
                                        <strong>TERUS HIJAUKAN NEGERI.</strong> Perhutani Mengelola Sumberdaya Hutan Di Pulau Jawa Dan Madura Senantiasa Menerapkan Prinsip-Prinsip Kelestarian Dan Good Corporate Governance.
                                    </p>
                                    
                                </div>
                            </div>                           

                        </div>
                    </div>

                </div>

                <!-- end gambar -->


                <!-- start jumlah agenda -->
                <div class="container-fluid">
                    
                
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                   <p class="h3 mb-0 text-gray-800">Data Agenda</p>
                </div>

                <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Jumlah Agenda</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> 
                                                <?php echo $jumlah_semua_data; ?> Agenda
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-solid fa-calendar-days fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Annual) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Agenda Belum Terlaksana
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $jumlah_belum_terlaksana; ?> Agenda
 
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-solid fa-calendar-xmark fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Agenda Terlaksana
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"> 
                                                        <?php echo $jumlah_terlaksana; ?> Agenda
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-solid fa-calendar-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        
                    </div>   
            
                </div>

                <!-- end jumlah agenda -->


                <!-- start jumlah perbulan -->
                <div class="container-fluid">
                    
                
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                   <p class="h3 mb-0 text-gray-800">Data Agenda Per Bulan</p>
                </div>

                <div class="row">

                        <!-- Earnings (Monthly) Card Example -->

                        <!-- Earnings (Annual) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Januari
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo getJumlahByBulan('Januari'); ?> Agenda 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Februari</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> 
                                                <?php echo getJumlahByBulan('Februari'); ?> Agenda
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Maret
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo getJumlahByBulan('Maret'); ?> Agenda 
 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                April</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> 
                                                <?php echo getJumlahByBulan('April'); ?> Agenda
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Mei
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo getJumlahByBulan('Mei'); ?> Agenda 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Juni</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> 
                                                <?php echo getJumlahByBulan('Juni'); ?> Agenda
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Juli
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo getJumlahByBulan('Juli'); ?> Agenda 
 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Agustus</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> 
                                                <?php echo getJumlahByBulan('Agustus'); ?> Agenda
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            September
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo getJumlahByBulan('September'); ?> Agenda 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Oktober</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> 
                                                <?php echo getJumlahByBulan('Oktober'); ?> Agenda
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            November
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo getJumlahByBulan('November'); ?> Agenda 
 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Desember</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> 
                                                <?php echo getJumlahByBulan('Desember'); ?> Agenda
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                        

                        <!-- Pending Requests Card Example -->
                        
                    </div>   
            
                </div>
                <!-- end jumlah perbulan -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php  require 'functions/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <?php require 'functions/link_js.php'; ?>

</body>

</html>