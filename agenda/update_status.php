<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agenda_iwan";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan tanggal saat ini
$currentDate = new DateTime();

// Mengambil data acara dari database
$sql = "SELECT id, waktu, status_acara FROM agenda";
$result = $conn->query($sql);


$englishToIndonesianDay = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];

$indonesianToEnglishDay = array_flip($englishToIndonesianDay);


$englishToIndonesianMonth = [
    'January' => 'Januari',
    'February' => 'Februari',
    'March' => 'Maret',
    'April' => 'April',
    'May' => 'Mei',
    'June' => 'Juni',
    'July' => 'Juli',
    'August' => 'Agustus',
    'September' => 'September',
    'October' => 'Oktober',
    'November' => 'November',
    'December' => 'Desember'
];

$indonesianToEnglishMonth = array_flip($englishToIndonesianMonth);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $eventId = $row["id"];
        $eventDateStr = $row["waktu"];

        $eventDateStr = str_replace(array_keys($englishToIndonesianDay), array_values($englishToIndonesianDay), $eventDateStr);
        $eventDateStr = str_replace(array_keys($englishToIndonesianMonth), array_values($englishToIndonesianMonth), $eventDateStr);
        
        $eventDateStr = str_replace(array_keys($indonesianToEnglishDay), array_values($indonesianToEnglishDay), $eventDateStr);
        $eventDateStr = str_replace(array_keys($indonesianToEnglishMonth), array_values($indonesianToEnglishMonth), $eventDateStr);

        $eventDate = DateTime::createFromFormat('l, d F Y H:i', $eventDateStr);

        if (!$eventDate) {
            echo "Format tanggal tidak valid: " . $eventDateStr . "<br>";
            continue;
        }

        if ($eventDate < $currentDate) {
            $newStatus = "Terlaksana";
        } else {
            $newStatus = "Belum Terlaksana";
        }

        // Update status acara di database
        $updateSql = "UPDATE agenda SET status_acara = '$newStatus' WHERE id = $eventId";
        if ($conn->query($updateSql) === TRUE) {
            echo "Status acara dengan ID $eventId berhasil diupdate menjadi $newStatus <br>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
} else {
    echo "Tidak Ada Data Tersedia.";
}

// Menutup koneksi
$conn->close();
?>
