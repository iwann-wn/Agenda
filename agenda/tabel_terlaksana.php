<?php 

session_start();
require '../functions/functions.php';

$agenda = query("SELECT * FROM agenda WHERE status_acara = 'Terlaksana' ORDER BY id DESC");
 
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

    <?php  require '../functions/link_css.php'; ?>    

</head>


<body id="page-top">
 
    <div id="wrapper">

        <!-- Sidebar -->
        <?php  require '../functions/sidebar.php'; ?>
  
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

                <!-- Begin Page Content -->
                <div class="container-fluid"  >

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tabel Agenda Yang Terlaksana</h1>
                    <p class="mb-4">Agenda Yang Sudah Dilaksanakan Oleh Perhutani Akan Ditampilkan Disini.</p>


                    <!-- DataTales  -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a class="m-0 font-weight-bold text-success" href="generate_pdf.php?status_acara=Terlaksana" target="_blank">Export to PDF</a>
                        </div>

                        <div class="card-body" >
                            <div class="table-responsive">

                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                             <th>No</th>
                                            <th>Nama Acara</th>
                                            <th>Keterangan</th>
                                            <th>Waktu</th>
                                            <th>Tempat</th>
                                            <th>Link Acara</th>
                                            <th>Status Acara</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $counter = 1; ?>
                                        <?php foreach ($agenda as $row) : ?>
                                            <tr>
                                                <td><?= $counter; ?></td>
                                                <td><?= $row['nama_acara']; ?></td>
                                                <td><?= $row['keterangan']; ?></td>
                                                <td><?= $row['waktu']; ?></td>
                                                <td><?= $row['tempat']; ?></td>
                                                <td>
                                                    <a href="<?= $row['link_acara']; ?>" target="_blank">
                                                        <?= excerpt($row['link_acara']); ?>
                                                    </a>
                                                </td>
                                                <td><?= $row['status_acara']; ?></td>

                                            </tr>
                                            <?php $counter++; ?>
                                        <?php endforeach; ?>
                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Footer -->
            <?php  require '../functions/footer.php'; ?>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <?php require '../functions/link_js.php'; ?>

</body>

</html>