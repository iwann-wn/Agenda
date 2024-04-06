// File: loadKegiatan.js
// Fungsi untuk memuat konten dari halaman kegiatan.php ke dalam div
function loadKegiatanContent() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("kegiatan-container").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "update_status.php", true);
    xhttp.send();
}

// Panggil fungsi loadKegiatanContent saat halaman pertama kali dimuat
window.onload = loadKegiatanContent;
