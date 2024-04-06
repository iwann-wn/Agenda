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

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    
    // cek apakah data berhasil diubah atau tidak
    if( ubah_agenda($_POST) > 0 ) {
        echo "
            <script>
                alert('Data Berhasil Diperbarui.');
                document.location.href = 'tabel_terlaksana.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Maaf, Data Gagal Di Perbarui.');
                document.location.href = 'ubah_agenda.php';
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
              
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Edit Agenda</h1>

                    <form class="tambah" action="" method="post">

                        <input type="hidden" name="id" value="<?= $agenda["id"]; ?>">


                        <div class="form-group">
                            <label for="nama_acara" class="form-label">Nama Acara</label>
                            <input type="text" class="form-control form-control-tambah" id="nama_acara" name="nama_acara" value="<?= $agenda["nama_acara"]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control form-control-tambah-textarea" id="keterangan" name="keterangan" rows="3" > <?= $agenda["keterangan"]; ?> </textarea>
                        </div>
                         

                        <!-- waktu start -->
                        <div class="form-group">
                            <label for="waktu" class="form-label">Pilih Waktu</label>
                            <input type="datetime-local" class="form-control form-control-tambah" id="waktu_datetime" name="waktu_datetime" onchange="updateWaktu()" >
                        </div>
                        <div class="form-group">
                            <label for="waktu" class="form-label">Waktu Acara</label> 
                            <span class="form-control form-control-tambah" id="waktu" >
                                <?= $agenda["waktu"]; ?>
                            </span>
                        </div>
                        <input type="hidden" name="waktu_db" value="<?php echo $agenda["waktu"]; ?>">
                        <!-- waktu end -->


                        <div class="form-group">
                             
                            <input type="hidden" class="form-control form-control-tambah" id="bulan" name="bulan" readonly value="<?= $agenda["bulan"]; ?>">
                        </div>

                        <div class="form-group">
                            <label for="tempat" class="form-label">Tempat Acara</label>
                            <input type="text" class="form-control form-control-tambah" id="tempat" name="tempat" value="<?= $agenda["tempat"]; ?>" >
                        </div>
                        <div class="form-group">
                            <label for="link_acara" class="form-label">Link Acara</label>
                            <input type="url" class="form-control form-control-tambah" id="link_acara" name="link_acara" value="<?= $agenda["link_acara"]; ?>" >
                        </div>
 

                        <div class="form-group">
                            <label for="status_acara" class="form-label">Status Acara</label>
                            <select class="form-control form-control-lg select" name="status_acara" id="status_acara">

                                <option value="<?= $agenda["status_acara"]; ?>"><?= $agenda["status_acara"]; ?></option>

                                <option value="Belum Terlaksana" <?= ($agenda["status_acara"] === "Belum Terlaksana") ? "selected" : ""; ?>>Belum Terlaksana</option>

                                <option value="Terlaksana" <?= ($agenda["status_acara"] === "Terlaksana") ? "selected" : ""; ?>>Terlaksana</option>

                            </select>
                        </div>
 

                        <input type="hidden" name="kode_unix" value="<?= $agenda["kode_unix"]; ?>">

                        <button type="submit" name="submit" class="btn btn-success btn-tambah btn-block">Submit</button>



                    </form>

                </div> 

            </div>
            <!-- End of Main Content -->
            <script type="text/javascript">
              function updateWaktu() {
                const datetimeInput = document.getElementById('waktu_datetime');
                const informasiWaktu = document.getElementById('waktu');
                const statusAcaraSelect = document.getElementById('status_acara');

                if (datetimeInput.value) {
                    const selectedDate = new Date(datetimeInput.value);
                    const currentDate = new Date(); // Tanggal dan waktu saat ini
                    
                    const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' };
                    const formattedDate = selectedDate.toLocaleDateString('id-ID', options);
                    
                    informasiWaktu.textContent = formattedDate;
                    
                    if (selectedDate.toDateString() === currentDate.toDateString()) {
                        statusAcaraSelect.value = 'Belum Terlaksana';
                    } else if (selectedDate < currentDate) {
                        statusAcaraSelect.value = 'Terlaksana';
                    } else {
                        statusAcaraSelect.value = 'Belum Terlaksana';
                    }
                }
            }
            </script>

            <!-- Footer -->
            <?php  require '../functions/footer.php'; ?>

        </div> 

    </div> 

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php  require '../functions/link_js.php'; ?>

</body>

</html>