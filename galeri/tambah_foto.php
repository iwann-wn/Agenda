<?php

session_start();
require '../functions/functions.php';

// Periksa role
if ($_SESSION["role"] !== "admin") {
    header("Location: ../index.php");
    exit;
}

// ambil data di URL
$id = $_GET["id"];
 

// query data agenda berdasarkan id
$agenda = query("SELECT * FROM agenda WHERE id = $id")[0];

// query data galeri berdasarkan id
$galeri = query("SELECT * FROM galeri WHERE id = $id");

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    
    // cek apakah gambar berhasil di tambahkan atau tidak
    if( tambah_foto($_POST) > 0 ) {
        echo "
            <script>
                alert('Foto Berhasil Ditambahkan Ke Dalam Sistem.');
                document.location.href = 'tabel_galeri.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Maaf, Terjadi Kesalahan Dalam Menambahkan Foto.');
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
                    <h1 class="h3 mb-4 text-gray-800">Tambah Agenda</h1>

                    <form class="tambah" action="" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="keterangan_foto" class="form-label">Keterangan Foto</label>
                            <input type="text" class="form-control form-control-tambah" id="keterangan_foto" name="keterangan_foto"  value="<?= $agenda["nama_acara"]; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="gambar" class="form-label">Gambar</label> <br>

                            <?php foreach ($galeri as $foto) : ?>

                                <img src="../images/foto/<?= $foto["gambar"]; ?>"  width="90" class="gallery-item" alt="gallery"> <br> <br>
                                
                            <?php endforeach; ?>

                            <input class="form-control form-control-lg custom-input" type="file" id="gambar" name="gambar" >
                                

                        </div> 


                        <input type="hidden" name="kode_unix" value="<?= $agenda["kode_unix"]; ?>">

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