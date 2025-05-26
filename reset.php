<?php
include 'koneksi.php';

// urutan penting: hapus nilai dulu, baru kriteria & alternatif
$koneksi->query("DELETE FROM nilai");
$koneksi->query("DELETE FROM kriteria");
$koneksi->query("DELETE FROM alternatif");

header("Location: /wp_decision");
exit;
?>
