<?php  


if( !isset($_SESSION["login"]) ) {
    header("Location:../login.php");
    exit;
}


?>

        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.php">
                <div class="sidebar-brand-icon rotate-n-15"> 
                    <img class="img-fluid " src="../images/Logo_Perhutani.png" alt="...">
                </div>
                <div class="sidebar-brand-text mx-3"> Perhutani <sup>Jawa Tengah</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="../index.php">
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
                                echo '<a class="collapse-item" href="../agenda/tambah_agenda.php">Tambah Agenda</a>';
                            }
                        ?>
                        <a class="collapse-item" href="../agenda/tabel_terlaksana.php">Agenda Terlaksana</a>
                        <a class="collapse-item" href="../agenda/tabel_belum_terlaksana.php">Agenda Belum Terlaksana</a>
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
                        <a class="collapse-item" href="../galeri/galeri.php">Galeri</a>
                        <!-- <a class="collapse-item" href="../galeri/tambah_foto.php">Tambah Foto</a> -->

                        <?php 
                            if ($_SESSION["role"] === "admin") {
                                echo '<a class="collapse-item" href="../galeri/tabel_galeri.php">Daftar Galeri </a>';
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

            <!-- Nav Item - Pages Collapse Menu -->
            

            <!-- Nav Item - Charts -->
            
            <li class="nav-item">
                <!-- <button type="submit" name="logout">Logout</button> -->
                <a class="nav-link" href="../logout.php">
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