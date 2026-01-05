<?php
session_start();
require_once "../config/koneksi.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['tambah'])) {
    mysqli_query($conn, "
        INSERT INTO artikel (judul, isi, tanggal)
        VALUES ('$_POST[judul]', '$_POST[isi]', CURDATE())
    ");
    header("Location: admin.php");
}


if (isset($_GET['hapus'])) {
    mysqli_query($conn, "DELETE FROM artikel WHERE id=$_GET[hapus]");
    header("Location: admin.php");
}

$edit = null;
if (isset($_GET['edit'])) {
    $q = mysqli_query($conn, "SELECT * FROM artikel WHERE id=$_GET[edit]");
    $edit = mysqli_fetch_assoc($q);
}

if (isset($_POST['update'])) {
    mysqli_query($conn, "
        UPDATE artikel SET
        judul='$_POST[judul]',
        isi='$_POST[isi]'
        WHERE id=$_POST[id]
    ");
    header("Location: admin.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Artikel</title>
</head>
<body>

<h2>Admin Panel - Artikel</h2>
<a href="login.php">Logout</a>

<hr>

<h3><?= $edit ? "Edit Artikel" : "Tambah Artikel" ?></h3>

<form method="POST">
    <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

    <input type="text" name="judul" placeholder="Judul"
           value="<?= $edit['judul'] ?? '' ?>" required><br><br>

    <textarea name="isi" placeholder="Isi artikel" required><?= $edit['isi'] ?? '' ?></textarea><br><br>

    <?php if ($edit): ?>
        <button name="update">Update</button>
    <?php else: ?>
        <button name="tambah">Tambah</button>
    <?php endif; ?>
</form>

<hr>

<h3>Data Artikel</h3>

<table border="1" cellpadding="8">
<tr>
    <th>No</th>
    <th>Judul</th>
    <th>Isi Artikel</th>
    <th>Tanggal</th>
    <th>Aksi</th>
</tr>

<?php
$no = 1;
$q = mysqli_query($conn, "SELECT * FROM artikel ORDER BY id DESC");
while ($r = mysqli_fetch_assoc($q)):
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($r['judul']) ?></td>
    <td><?= nl2br(htmlspecialchars(substr($r['isi'], 0, 150))) ?>...</td>
    <td><?= $r['tanggal'] ?></td>
    <td>
        <a href="?edit=<?= $r['id'] ?>">Edit</a> |
        <a href="?hapus=<?= $r['id'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
