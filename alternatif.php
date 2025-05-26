<?php include 'koneksi.php'; ?>

<h2>Data Alternatif</h2>
<form method="post">
    <input type="hidden" name="id" value="<?= isset($_GET['edit']) ? $_GET['edit'] : '' ?>">
    Nama Alternatif: <input type="text" name="nama" value="<?= $_GET['nama'] ?? '' ?>" required>
    <input type="submit" name="<?= isset($_GET['edit']) ? 'update' : 'simpan' ?>" value="<?= isset($_GET['edit']) ? 'Update' : 'Tambah' ?>">
</form>

<?php
if (isset($_POST['simpan'])) {
    $koneksi->query("INSERT INTO alternatif (nama) VALUES ('$_POST[nama]')");
    header("Location: alternatif.php");
}
if (isset($_POST['update'])) {
    $koneksi->query("UPDATE alternatif SET nama='$_POST[nama]' WHERE id='$_POST[id]'");
    header("Location: alternatif.php");
}
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);

    // Hapus nilai yang terkait dengan alternatif ini
    $koneksi->query("DELETE FROM nilai WHERE id_alternatif='$id'");

    // Hapus alternatifnya
    $koneksi->query("DELETE FROM alternatif WHERE id='$id'");

    header("Location: /wp_decision/alternatif.php");
    exit;
}
?>

<table border="1" cellpadding="5">
<tr><th>No</th><th>Nama</th><th>Aksi</th></tr>
<?php
$no = 1;
$data = $koneksi->query("SELECT * FROM alternatif");
while ($row = $data->fetch_assoc()) {
    echo "<tr>
        <td>$no</td>
        <td>{$row['nama']}</td>
        <td>
            <a href='?edit={$row['id']}&nama={$row['nama']}'>Edit</a> | 
            <a href='?hapus={$row['id']}' onclick=\"return confirm('Yakin hapus?')\">Hapus</a>
        </td>
    </tr>";
    $no++;
}
?>
</table>
<br>
<a href="/wp_decision">🔙 Kembali ke Menu Utama</a>
