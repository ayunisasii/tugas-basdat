<?php
include 'koneksi.php';

if(isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    $query = "DELETE FROM tb_mahasiswa WHERE nim='$nim'";
    
    if($conn->query($query) === TRUE) {
        echo "<script>alert('Data berhasil dihapus');window.location='index.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "<script>alert('NIM tidak ditemukan');window.location='index.php';</script>";
}
?>
