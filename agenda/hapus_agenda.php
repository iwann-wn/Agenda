<?php 
session_start();

if( !isset($_SESSION["login"]) ) {
	header("Location: ../login.php");
	exit;
}

require '../functions/functions.php';

// Periksa role
if ($_SESSION["role"] !== "admin") {
    header("Location: ../index.php");
    exit;
}


$id = $_GET["id"];

if( hapus_agenda($id) > 0 ) {
	echo "
		<script>
			alert('Data Berhasil Dihapus Dari Sistem.');
			document.location.href = '../index.php';
		</script>
	";
} else {
	echo "
		<script>
			alert('Maaf, Gagal Menghapus Data');
			document.location.href = '../index.php';
		</script>
	";
}

?>