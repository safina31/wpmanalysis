<?php include 'koneksi.php'; ?>

<h2>Input Nilai Alternatif terhadap Kriteria</h2>
<form method="post">
    Alternatif: 
    <select name="id_alternatif">
        <?php
        $alt = $koneksi->query("SELECT * FROM alternatif");
        while ($a = $alt->fetch_assoc()) {
            echo "<option value='$a[id]'>$a[nama]</option>";
        }
        ?>
    </select><br><br>

    <?php
    $krit = $koneksi->query("SELECT * FROM kriteria");
    while ($k = $krit->fetch_assoc()) {
        echo "{$k['nama']} : <input type='number' step='any' name='nilai[{$k['id']}]'><br>";
    }
    ?>
    <br><input type="submit" name="simpan" value="Simpan / Update Nilai">
</form>

<?php
if (isset($_POST['simpan'])) {
    $id_alt = $_POST['id_alternatif'];
    foreach ($_POST['nilai'] as $id_krit => $nilai) {
        $cek = $koneksi->query("SELECT * FROM nilai WHERE id_alternatif=$id_alt AND id_kriteria=$id_krit");
        if ($cek->num_rows > 0) {
            $koneksi->query("UPDATE nilai SET nilai=$nilai WHERE id_alternatif=$id_alt AND id_kriteria=$id_krit");
        } else {
            $koneksi->query("INSERT INTO nilai (id_alternatif, id_kriteria, nilai) VALUES ($id_alt, $id_krit, $nilai)");
        }
    }
    echo "<script>alert('Nilai berhasil disimpan!'); location.href='nilai.php';</script>";
}

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']); // Sanitize input
    $koneksi->query("DELETE FROM kriteria WHERE id='$id'");
    header("Location: kriteria.php");
    exit;
}
?>

<h3>Data Nilai</h3>
<table border="1" cellpadding="5">
<tr><th>Alternatif</th><th>Kriteria</th><th>Nilai</th></tr>
<?php
$data = $koneksi->query("SELECT a.nama AS alt, k.nama AS krit, n.nilai, n.id_alternatif 
                         FROM nilai n 
                         JOIN alternatif a ON n.id_alternatif=a.id 
                         JOIN kriteria k ON n.id_kriteria=k.id 
                         ORDER BY n.id_alternatif");
$id_alt_last = null;
while ($row = $data->fetch_assoc()) {
    echo "<tr>
        <td>{$row['alt']}</td>
        <td>{$row['krit']}</td>
        <td>{$row['nilai']}</td>
    </tr>";
    $id_alt_last = $row['id_alternatif'];
}
?>
</table>
<br>

<a href="/wp_decision">🔙 Kembali ke Menu Utama</a>