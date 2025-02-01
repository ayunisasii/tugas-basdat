<?php
include 'koneksi.php';
// Handle form submission for adding new student
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_mahasiswa'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $ttl = $_POST['ttl'];
    $alamat = $_POST['alamat'];
    $kode_fakultas = $_POST['kode_fakultas'];
    $kode_prodi = $_POST['kode_prodi'];
    $jenis_kelamin = $_POST['jk'];
    $angkatan = $_POST['angkatan'];
    $sql = "INSERT INTO tb_mahasiswa (nim, nama, ttl, alamat, kode_fakultas, kode_prodi, jenis_kelamin, angkatan) 
            VALUES ('$nim', '$nama', '$ttl', '$alamat', '$kode_fakultas', '$kode_prodi', '$jenis_kelamin', '$angkatan')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil disimpan!!');
    window.location='datamhs.php';</script>";
} else {
    echo "<script>alert('Data gagal disimpan!!');
    window.location='datamhs.php';</script>"; 
}
}
?>