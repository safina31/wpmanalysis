<?php
$koneksi = new mysqli("localhost", "root", "", "wp_decision");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
