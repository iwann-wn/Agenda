<?php
session_start();
require '../functions/functions.php';


// Periksa role
if ($_SESSION["role"] !== "admin") {
    header("Location: ../index.php");
    exit;
}

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    
    // cek apakah data berhasil di tambahkan atau tidak
    if( tambah_agenda($_POST) > 0 ) {
        echo "
            <script>
                alert('Data Berhasil Ditambahkan Ke Dalam Sistem.');
                document.location.href = 'tabel_belum_terlaksana.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Maaf, Terjadi Kesalahan Dalam Menambahkan Data.');
                document.location.href = 'tabel_belum_terlaksana.php';
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
                    <h1 class="h3 mb-4 text-gray-800">Tambah Agenda</h1>

                    <form class="tambah" action="" method="post">

                        <div class="form-group">
                            <label for="nama_acara" class="form-label">Nama Acara</label>
                            <input type="text" class="form-control form-control-tambah" id="nama_acara" name="nama_acara" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control form-control-tambah-textarea" id="keterangan" name="keterangan" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="waktu_datetime" class="form-label">Waktu Acara</label>
                            <input type="datetime-local" class="form-control form-control-tambah" id="waktu_datetime" name="waktu" onchange="updateWaktu()" >
                        </div>

                        <input type="hidden" id="waktu" >

                        <div class="form-group">
                            
                            <input type="hidden" class="form-control form-control-tambah" id="bulan" name="bulan" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tempat" class="form-label">Tempat Acara</label>
                            <input type="text" class="form-control form-control-tambah" id="tempat" name="tempat" >
                        </div>
                        <div class="form-group">
                            <label for="link_acara" class="form-label">Link Acara</label>
                            <input type="url" class="form-control form-control-tambah" id="link_acara" name="link_acara">
                        </div>

                        <div class="form-group">
                            <label for="status_acara" class="form-label">Status Acara</label>
                            <select class="form-control form-control-lg select" name="status_acara" id="status_acara">
                                
                                <option value="Belum Terlaksana">Belum Terlaksana</option>
                                <option value="Terlaksana"> Terlaksana</option>

                            </select>
                        </div>

                        <button type="submit" name="submit" class="btn btn-success btn-tambah btn-block">Submit</button>

                    </form>

                </div>
                 
            </div> 

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

            <?php  require '../functions/footer.php'; ?>
            
        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <?php  require '../functions/link_js.php'; ?>

</body>
</html>