<?php include 'koneksi.php'; ?>
<h2>Hasil Perhitungan Weighted Product</h2>

<table border="1" cellpadding="5">
<tr>
    <th>Alternatif</th><th>Vector Preferensi (Vᵢ)</th>
</tr>
<?php
// Ambil data
$kriteria = $koneksi->query("SELECT * FROM kriteria");
$alternatif = $koneksi->query("SELECT * FROM alternatif");

// Hitung bobot normal
$total_bobot = $koneksi->query("SELECT SUM(bobot) as total FROM kriteria")->fetch_assoc()['total'];
$bobot_normal = [];

while ($k = $kriteria->fetch_assoc()) {
    $id = $k['id'];
    $bobot_normal[$id] = ($k['tipe'] == 'cost' ? -1 : 1) * ($k['bobot'] / $total_bobot);
}

// 1. Hitung semua Si (skor) dan simpan
$alt = $koneksi->query("SELECT * FROM alternatif");
$skor_array = [];
$total_skor = 0;

while ($a = $alt->fetch_assoc()) {
    $id_alt = $a['id'];
    $nama_alt = $a['nama'];
    $skor = 1;

    $nilai = $koneksi->query("SELECT * FROM nilai WHERE id_alternatif=$id_alt");
    while ($n = $nilai->fetch_assoc()) {
        $id_krit = $n['id_kriteria'];
        $v = pow($n['nilai'], $bobot_normal[$id_krit]);
        $skor *= $v;
    }

    $skor_array[] = ['nama' => $nama_alt, 'skor' => $skor];
    $total_skor += $skor;
}

// 2. Tampilkan nilai Vi = Si / total S
usort($skor_array, function($a, $b) {
    return $b['skor'] <=> $a['skor']; // Descending
});

foreach ($skor_array as $item) {
    $vi = $item['skor'] / $total_skor;
    echo "<tr><td>{$item['nama']}</td><td>" . round($vi, 6) . "</td></tr>";
}

?>
</table>

<a href="/wp_decision">🔙 Kembali ke Menu Utama</a>