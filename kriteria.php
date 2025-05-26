<?php include 'koneksi.php'; ?>

<h2>Data Kriteria</h2>
<form method="post" action="">
    <input type="hidden" name="id" value="<?= isset($_GET['edit']) ? $_GET['edit'] : '' ?>">
    Nama: <input type="text" name="nama" value="<?= isset($_GET['nama']) ? $_GET['nama'] : '' ?>" required>
    Bobot: <input type="number" step="any" name="bobot" value="<?= isset($_GET['bobot']) ? $_GET['bobot'] : '' ?>" required>
    Tipe: 
    <select name="tipe">
        <option value="benefit" <?= (isset($_GET['tipe']) && $_GET['tipe'] == 'benefit') ? 'selected' : '' ?>>Benefit</option>
        <option value="cost" <?= (isset($_GET['tipe']) && $_GET['tipe'] == 'cost') ? 'selected' : '' ?>>Cost</option>
    </select>
    <input type="submit" name="<?= isset($_GET['edit']) ? 'update' : 'simpan' ?>" value="<?= isset($_GET['edit']) ? 'Update' : 'Tambah' ?>">
</form>

<?php
if (isset($_POST['simpan'])) {
    $koneksi->query("INSERT INTO kriteria (nama, bobot, tipe) VALUES ('$_POST[nama]', '$_POST[bobot]', '$_POST[tipe]')");
    header("Location: kriteria.php");
}
if (isset($_POST['update'])) {
    $koneksi->query("UPDATE kriteria SET nama='$_POST[nama]', bobot='$_POST[bobot]', tipe='$_POST[tipe]' WHERE id='$_POST[id]'");
    header("Location: kriteria.php");
}
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);

    // Hapus semua nilai yang berkaitan dengan kriteria ini
    $koneksi->query("DELETE FROM nilai WHERE id_kriteria='$id'");

    // Baru hapus kriteria
    $koneksi->query("DELETE FROM kriteria WHERE id='$id'");

    header("Location: /wp_decision/kriteria.php");
    exit;
}
?>

<table border="1" cellpadding="5">
<tr><th>No</th><th>Nama</th><th>Bobot</th><th>Tipe</th><th>Aksi</th></tr>
<?php
$no = 1;
$data = $koneksi->query("SELECT * FROM kriteria");
while ($row = $data->fetch_assoc()) {
    echo "<tr>
        <td>$no</td>
        <td>{$row['nama']}</td>
        <td>{$row['bobot']}</td>
        <td>{$row['tipe']}</td>
        <td>
            <a href='?edit={$row['id']}&nama={$row['nama']}&bobot={$row['bobot']}&tipe={$row['tipe']}'>Edit</a> | 
            <a href='?hapus={$row['id']}' onclick=\"return confirm('Yakin hapus?')\">Hapus</a>
        </td>
    </tr>";
    $no++;
}
?>
</table>
<br>

<a href="/wp_decision">🔙 Kembali ke Menu Utama</a>
