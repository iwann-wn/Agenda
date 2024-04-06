<?php 

session_start();
require '../functions/functions.php';

// Periksa role
if ($_SESSION["role"] !== "admin") {
    header("Location: ../index.php");
    exit;
}

$agenda = query("SELECT agenda.id AS id, agenda.nama_acara AS nama_acara, agenda.bulan, galeri.gambar
                FROM agenda
                LEFT JOIN galeri ON agenda.kode_unix = galeri.kode_unix;
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
 

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tabel Galeri</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">

                        <div class="card-body" id="ajax">
                            <div class="table-responsive">

                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>keterangan Foto</th>
                                            <th>Gambar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $counter = 1; ?>
                                        <?php foreach ($agenda as $row) : ?>
                                            <tr>
                                                <td><?= $counter; ?></td>
                                                <td><?= $row['nama_acara']; ?></td>
                                                
                                                <td class="tb_foto">
                                                    <img src="../images/foto/<?= $row["gambar"]; ?>" 
                                                     >
                                                </td>
                                                
                                                <td class="btn_agenda" >
                                                    <a class="btn btn-primary" role="button" 
                                                        href="tambah_foto.php?id=<?= $row["id"]; ?>" >Tambah Foto
                                                    </a>
                                                    <a class="btn btn-success" role="button" 
                                                        href="ubah_galeri.php?id=<?= $row["id"]; ?>" > Edit Foto
                                                    </a>
                                                    <a class="btn btn-danger" role="button"
                                                        href="hapus_galeri.php?id=<?= $row["id"]; ?>" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Foto Ini? Tindakan Ini Tidak Dapat Dibatalkan.');" > Hapus Foto
                                                    </a>
                                                </td>
                                                
                                            </tr>
                                            <?php $counter++; ?>
                                        <?php endforeach; ?>
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


    <?php require '../functions/link_js.php'; ?>

</body>

</html>