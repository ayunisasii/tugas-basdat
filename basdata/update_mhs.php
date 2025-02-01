<?php
include 'koneksi.php';

if(isset($_POST['update_mahasiswa'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jk = $_POST['jk'];
    $ttl = $_POST['ttl'];
    $alamat = $_POST['alamat'];
    $kode_prodi = $_POST['kode_prodi'];
    $angkatan = $_POST['angkatan'];

    $query = "UPDATE tb_mahasiswa SET 
              nama='$nama', 
              jenis_kelamin='$jk', 
              ttl='$ttl', 
              alamat='$alamat', 
              kode_prodi='$kode_prodi', 
              angkatan='$angkatan' 
              WHERE nim='$nim'";
    
    if($conn->query($query) === TRUE) {
        echo "<script>alert('Data berhasil diupdate');window.location='datamhs.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
