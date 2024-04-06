<?php

session_start();
require '../functions/functions.php';

// Periksa role
if ($_SESSION["role"] !== "admin") {
    header("Location: ../index.php");
    exit;
}

// Ambil data di URL

$id = isset($_GET['id']) ? $_GET['id'] : null;

// Query data agenda dan galeri berdasarkan ID
$agenda = query("SELECT agenda.id AS id, agenda.nama_acara AS nama_acara, agenda.kode_unix, galeri.gambar
                FROM agenda
                LEFT JOIN galeri ON agenda.kode_unix = galeri.kode_unix
                WHERE agenda.id = $id
");


// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    
    // cek apakah data berhasil diubah atau tidak
    if( ubah_foto($_POST) > 0 ) {
        echo "
            <script>
                alert('Foto Berhasil Diperbarui');
                document.location.href = 'tabel_galeri.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Maaf, Foto Gagal Di Perbarui.');
                document.location.href = 'tabel_galeri.php';
            </script>
        ";
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
                    <h1 class="h3 mb-4 text-gray-800">Edit Gambar Galeri</h1>

                    <form class="tambah" action="" method="post" enctype="multipart/form-data">

                        <input type="hidden" name="id" value="<?= $agenda[0]["id"]; ?>">
                        <input type="hidden" name="gambarLama" value="<?= $agenda[0]["gambar"]; ?>">
                        

                        <div class="form-group">
                            <label for="keterangan_foto" class="form-label">Keterangan Foto</label>
                            <input type="text" class="form-control form-control-tambah" id="keterangan_foto" name="keterangan_foto" value="<?= $agenda[0]["nama_acara"]; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="gambar" class="form-label">Gambar</label> <br>
                            <img src="../images/foto/<?= $agenda[0]["gambar"]; ?>"  width="90" class="gallery-item" alt="gallery"> <br> <br>

                            <input class="form-control form-control-lg custom-input" type="file" id="gambar" name="gambar"
                                >
                        </div>          

                        <input type="hidden" name="kode_unix" value="<?= $agenda[0]["kode_unix"]; ?>">

                        

                        <button type="submit" name="submit" class="btn btn-success btn-tambah btn-block">Submit</button>

                    </form>

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