<?php 

$conn = mysqli_connect("localhost", "root", "", "agenda_iwan");


function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}


function join_galeri_agenda() {
    global $conn;

    $query = "SELECT * FROM galeri
              JOIN agenda ON galeri.id = agenda.id";
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function tambah_agenda($data) {
    global $conn;

    $nama_acara = htmlspecialchars($data["nama_acara"]);
    $keterangan = htmlspecialchars($data["keterangan"]);
    $bulan = htmlspecialchars($data["bulan"]);

    // Array asosiatif untuk nama hari dan bulan dalam bahasa Indonesia
    $nama_hari = array(
        "Sunday" => "Minggu",
        "Monday" => "Senin",
        "Tuesday" => "Selasa",
        "Wednesday" => "Rabu",
        "Thursday" => "Kamis",
        "Friday" => "Jumat",
        "Saturday" => "Sabtu"
    );

    $nama_bulan = array(
        "January" => "Januari", "February" => "Februari", "March" => "Maret",
        "April" => "April", "May" => "Mei", "June" => "Juni",
        "July" => "Juli", "August" => "Agustus", "September" => "September",
        "October" => "Oktober", "November" => "November", "December" => "Desember"
    );

    // Mengubah format tanggal dan waktu
    $waktu_input = new DateTime($data["waktu"]);
    $hari = $nama_hari[$waktu_input->format("l")];
    $bulan = $nama_bulan[$waktu_input->format("F")];
    // Y,H,I tahun, jam, dan menit
    $waktu_formatted = $hari . ', ' . $waktu_input->format('d') . ' ' . $bulan . ' ' . $waktu_input->format('Y H:i');

    $tempat = htmlspecialchars($data["tempat"]);
    $link_acara = htmlspecialchars($data["link_acara"]);
    $status_acara = htmlspecialchars($data["status_acara"]);

    $kode_unix = uniqid(); 

    $query = "INSERT INTO agenda
                VALUES
              ('', '$nama_acara', '$keterangan', '$bulan', '$waktu_formatted', '$tempat', '$link_acara', '$status_acara', '$kode_unix')
            ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function hapus_agenda($id) {
	global $conn;
	mysqli_query($conn, "DELETE FROM agenda WHERE id = $id");
	return mysqli_affected_rows($conn);
}


// UPDATE Fungsi untuk mengubah format tanggal menjadi format Indonesia
function format_tanggal_indonesia($tanggal) {
    $nama_hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    $nama_bulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    
    $timestamp = strtotime($tanggal);
    $hari = $nama_hari[date("w", $timestamp)];
    $tanggal_formatted = date("j", $timestamp);
    $bulan = $nama_bulan[date("n", $timestamp)];
    $tahun = date("Y", $timestamp);
    $waktu = date("H:i", $timestamp);

    return [
        "hari" => $hari,
        "tanggal" => $tanggal_formatted,
        "bulan" => $bulan,
        "tahun" => $tahun,
        "waktu" => $waktu
    ];
}

// Fungsi ubah_agenda dengan penanganan format tanggal yang berbeda
function ubah_agenda($data) {
    global $conn;

    $id = $data["id"];
    $nama_acara = htmlspecialchars($data["nama_acara"]);
    $keterangan = htmlspecialchars($data["keterangan"]);
    $waktu_datetime = $data["waktu_datetime"]; // Ambil dari input datetime-local
    $tempat = htmlspecialchars($data["tempat"]);
    $link_acara = htmlspecialchars($data["link_acara"]);
    $status_acara = htmlspecialchars($data["status_acara"]);
    $kode_unix = $data["kode_unix"];

    // Jika waktu_datetime tidak kosong, gunakan nilainya
    // dan format ulang waktu sesuai format di tambah_agenda
    if (!empty($waktu_datetime)) {
        $formatted_data = format_tanggal_indonesia($waktu_datetime);
        $bulan = $formatted_data["bulan"];
        $waktu = "{$formatted_data["hari"]}, {$formatted_data["tanggal"]} {$formatted_data["bulan"]} {$formatted_data["tahun"]} {$formatted_data["waktu"]}";
    } else {
        // Jika waktu_datetime kosong, gunakan waktu dari data
        $bulan = htmlspecialchars($data["bulan"]);
        $waktu = $data["waktu_db"];
    }

    $query = "UPDATE agenda SET 
                nama_acara = '$nama_acara',
                keterangan = '$keterangan',
                bulan = '$bulan',
                waktu = '$waktu',
                tempat = '$tempat',
                link_acara = '$link_acara',
                status_acara = '$status_acara',
                kode_unix = '$kode_unix'
              WHERE id = $id
            ";
    
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn); 
}

function registrasi($data) {
    global $conn;

    $nama = mysqli_real_escape_string($conn, $data["nama"]); // Ambil input nama
    $email = strtolower($data["email"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek email sudah ada atau belum
    $result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$email'");

    if( mysqli_fetch_assoc($result) ) {
        echo "<script>
                alert('Email Sudah Terdaftar. Silakan Gunakan Email Lain.')
              </script>";
        return false;
    }

    // cek konfirmasi password
    if( $password !== $password2 ) {
        echo "<script>
                alert('Konfirmasi Password Tidak Cocok. Harap Periksa Kembali.');
              </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Set nilai default role ke "user"
    $role = "user";

    // tambahkan user baru ke database dengan nilai role default
    mysqli_query($conn, "INSERT INTO user (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')");

    return mysqli_affected_rows($conn);
}


// potong karakter text
function excerpt($string){
	$string = substr($string, 0, 15);
	return $string . "...";
}


// tambah_foto galeri
function tambah_foto($data) {
	global $conn;
	
	$kode_unix = $data["kode_unix"];

	// Cek apakah sudah ada foto untuk agenda ini
	$query = "SELECT COUNT(*) FROM galeri WHERE kode_unix = '$kode_unix'";
	$result = mysqli_query($conn, $query);
	$count = mysqli_fetch_array($result)[0];
	if ($count > 0) {
		echo "
			<script>
				alert('Maaf, Foto Sudah Terlampir Pada Agenda Ini.');				 
				document.location.href = 'tabel_galeri.php';
			</script>
		";
		return false;
	}

	// upload gambar
	$gambar = upload();
	if (!$gambar) {
		return false;
	}

	// Ambil ID agenda berdasarkan kode_unix
	$query = "SELECT id FROM agenda WHERE kode_unix = '$kode_unix'";
	$result = mysqli_query($conn, $query);
	$agenda = mysqli_fetch_assoc($result);
	$id = $agenda['id'];
	$kode_unix = $data["kode_unix"];

	// Simpan foto dan keterangan_foto ke tabel galeri
	$query = "INSERT INTO galeri (id, gambar, kode_unix)
	          VALUES ('$id', '$gambar',  '$kode_unix')";


	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}



// fungsi untuk upload gambar
function upload() {

	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apakah tidak ada gambar yang diupload
	if( $error === 4 ) {
		echo "<script>
				alert('Silakan Pilih Gambar Terlebih Dahulu.');
			  </script>";
		return false;
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
		echo "<script>
				alert('Sepertinya Yang Anda Unggah Bukanlah File Gambar Yang Diizinkan. Mohon Pastikan Anda Memilih File Gambar Dengan Format Jpg, Jpeg, Atau Png Untuk Diunggah.');
			  </script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if( $ukuranFile > 20000000 ) {
		echo "<script>
				alert('Maaf, Ukuran Gambar Yang Anda Unggah Melebihi Batas Yang Diizinkan. Mohon Unggah Gambar Dengan Ukuran 20mb Atau Lebih Kecil Untuk Melanjutkan.');
			  </script>";
		return false;
	}

	// lolos pengecekan. gambar siap diupload
	// generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, '../images/foto/' . $namaFileBaru);

	return $namaFileBaru;
}

// hapus foto
function hapus_foto($id) {
	global $conn;
	mysqli_query($conn, "DELETE FROM galeri WHERE id = $id");
	return mysqli_affected_rows($conn);
}

// ubah gambar

function ubah_foto($data) {
	global $conn;

	$id = $data["id"];
	 
	$gambarLama = htmlspecialchars($data["gambarLama"]);
	$kode_unix = $data["kode_unix"];
	 
	
	// cek apakah user pilih gambar baru atau tidak
	if( $_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	} else {
		$gambar = upload();
	}
	

	$query = "UPDATE galeri SET 
				gambar = '$gambar',
				kode_unix = '$kode_unix' 
			  WHERE id = $id
			";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	
}


?>