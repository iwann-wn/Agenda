<?php

require '../vendor/tcpdf/tcpdf/tcpdf.php';
require '../functions/functions.php';


$status_acara = isset($_GET['status_acara']) ? $_GET['status_acara'] : '';


$agenda = query("SELECT * FROM agenda WHERE status_acara = '$status_acara' ORDER BY id DESC");

// Buat dokumen PDF baru
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->AddPage();

$html = '<h1 style="text-align: center; position: relative; top: -10px;"> Data Agenda ' . $status_acara . '</h1>';
$html .= '<style>';
$html .= 'table { width: 100%; border-collapse: collapse; }';
$html .= 'table th, table td { border: 1px solid black; padding: 5px; }';
$html .= '</style>';
$html .= '<table>';

    $html .= '<thead>
                <tr>
                    <th style="width: 25px; height: 20px;">No</th>
                    <th style="width: 105px; height: 20px;">Nama Acara</th>
                    <th style="width: 110px; height: 20px;">Keterangan</th>
                    <th style="width: 100px; height: 20px;">Waktu</th>
                    <th style="width: 100px; height: 20px;">Tempat</th>
                    <th style="width: 100px; height: 20px;">Link Acara</th>
                </tr>
            </thead>';
    $html .= '<tbody>';


    $counter = 1;


    foreach ($agenda as $row) {
        $html .= '<tr>';
        $html .= '<td style="width: 25px;">' . $counter . '</td>';
        $html .= '<td style="width: 105px;">' . $row['nama_acara'] . '</td>';
        $html .= '<td style="width: 110px;">' . $row['keterangan'] . '</td>';
        $html .= '<td style="width: 100px;">' . $row['waktu'] . '</td>'; 
        $html .= '<td style="width: 100px;">' . $row['tempat'] . '</td>'; 
        $html .= '<td style="width: 100px;">' . $row['link_acara'] . '</td>';
        $html .= '</tr>';
        $counter++; 
    }

    $html .= '</tbody>';
$html .= '</table>';

// Output PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('agenda.pdf', 'I');

exit;
?>
