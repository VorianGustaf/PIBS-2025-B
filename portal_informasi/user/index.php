<?php
require_once "../config/koneksi.php";

/* Ambil semua artikel */
$q = mysqli_query($conn, "SELECT * FROM artikel ORDER BY id DESC");

$artikel = [];
while ($r = mysqli_fetch_assoc($q)) {
    $artikel[] = $r;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Portal Informasi</title>
    <style>
/* =====================
   RESET
===================== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}

/* =====================
   BODY
===================== */
body {
    background: #f4f6f9;
    color: #333;
}

/* =====================
   HEADER
===================== */
header {
    background: #2c3e50;
    color: #fff;
    padding: 20px;
}

header h1 {
    font-size: 26px;
}

header p {
    font-size: 14px;
    opacity: 0.8;
}

/* =====================
   LAYOUT WRAPPER
===================== */
.layout {
    display: flex;
    min-height: calc(100vh - 140px);
}

/* =====================
   NAV (LEFT)
===================== */
nav {
    width: 200px;
    background: #34495e;
}

nav ul {
    list-style: none;
}

nav ul li a {
    display: block;
    padding: 12px 15px;
    color: #fff;
    text-decoration: none;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

nav ul li a:hover {
    background: #1abc9c;
}

/* =====================
   MAIN CONTENT
===================== */
main {
    flex: 1;
    padding: 20px;
}

/* =====================
   ARTICLE LIST
===================== */
section {
    background: #fff;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 4px;
    box-shadow: 0 0 5px rgba(0,0,0,0.05);
}

section h3 {
    margin-bottom: 10px;
    color: #2c3e50;
}

section p {
    line-height: 1.6;
    margin-bottom: 10px;
}

section button {
    background: #3498db;
    border: none;
    padding: 8px 12px;
    color: #fff;
    border-radius: 3px;
    cursor: pointer;
}

section button:hover {
    background: #2980b9;
}

/* =====================
   ASIDE (RIGHT)
===================== */
aside {
    width: 220px;
    background: #ecf0f1;
    padding: 15px;
}

/* =====================
   FOOTER
===================== */
footer {
    background: #2c3e50;
    color: #fff;
    text-align: center;
    padding: 12px;
    font-size: 13px;
}

/* =====================
   RESPONSIVE
===================== */
@media (max-width: 768px) {
    .layout {
        flex-direction: column;
    }

    nav, aside {
        width: 100%;
    }
}
    </style>
</head>
<body>

<header>
    <h1>PORTAL INFORMASI</h1>
    <p>Website Informasi Resmi</p>
</header>

<div class="layout">
    <nav>
        <ul>
            <li><a href="#" onclick="showList()">Beranda</a></li>
        </ul>
    </nav>

    <main>
        <article id="content">
            <h2>Artikel Terbaru</h2>

            <section>
                <h3>Peluncuran Portal Informasi Resmi</h3>
                <p>Pengumuman jadwal pemeliharaan sistem...</p>
                <button>Baca Selengkapnya</button>
            </section>
        </article>
    </main>

    <aside>
        <h3>Info</h3>
        <p>Portal berita & artikel</p>
    </aside>
</div>

<footer>
    <p>© 2025 Portal Informasi</p>
</footer>

</body>
</html>

<script>
const data = <?= json_encode($artikel); ?>;

/* =====================
   TAMPIL LIST
===================== */
function showList() {
    let html = "<h2>Artikel Terbaru</h2>";
    data.forEach(a => {
        html += `
            <section>
                <h3>${a.judul}</h3>
                <p>${a.isi.substring(0,120)}...</p>
                <button onclick="showDetail(${a.id})">
                    Baca Selengkapnya
                </button>
            </section>
        `;
    });
    document.getElementById("content").innerHTML = html;
}

/* =====================
   DETAIL
===================== */
function showDetail(id) {
    const a = data.find(x => x.id == id);
    document.getElementById("content").innerHTML = `
        <h2>${a.judul}</h2>
        <small>${a.tanggal}</small>
        <p>${a.isi}</p>
        <button onclick="showList()">← Kembali</button>
    `;
}

showList();
</script>
