<?php
include 'koneksi.php';

if(isset($_GET['nim'])) {
    $nim = $_GET['nim'];
    $result = $conn->query("SELECT * FROM tb_mahasiswa WHERE nim = '$nim'");
    $data = $result->fetch_assoc();
} else {
    echo "<script>alert('NIM tidak ditemukan');window.location='index.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
<h2 class="text-center mb-2">Edit Data Mahasiswa</h2>
<form method="POST" action="update_mhs.php">
    <div class="form-group row">
        <label for="nim" class="col-sm-2 col-form-label">NIM:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $data['nim']; ?>" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="nama" class="col-sm-2 col-form-label">Nama:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $data['nama']; ?>" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin:</label>
        <div class="col-sm-10">
            <select class="form-control" id="jk" name="jk" required>
                <option value="L" <?php echo ($data['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="P" <?php echo ($data['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="ttl" class="col-sm-2 col-form-label">Tanggal Lahir:</label>
        <div class="col-sm-10">
            <input type="date" class="form-control" id="ttl" name="ttl" value="<?php echo $data['ttl']; ?>" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="alamat" class="col-sm-2 col-form-label">Alamat:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $data['alamat']; ?>" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="kode_fakultas" class="col-sm-2 col-form-label">Fakultas:</label>
        <div class="col-sm-10">
            <select class="form-control" name="kode_fakulitas" required>
                <?php
                $result = $conn->query("SELECT kode_fakultas, nama_fakultas FROM tb_fakultas");
                while ($row = $result->fetch_assoc()) {
                    $selected = ($row['kode_fakultas'] == $data['kode_fakultas']) ? 'selected' : '';
                    echo "<option value='" . $row['kode_fakultas'] . "' $selected>" . $row['nama_fakultas'] . "</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="kode_prodi" class="col-sm-2 col-form-label">Program Studi:</label>
        <div class="col-sm-10">
            <select class="form-control" name="kode_prodi" required>
                <?php
                $result = $conn->query("SELECT kode_prodi, nama_prodi FROM tb_prodi");
                while ($row = $result->fetch_assoc()) {
                    $selected = ($row['kode_prodi'] == $data['kode_prodi']) ? 'selected' : '';
                    echo "<option value='" . $row['kode_prodi'] . "' $selected>" . $row['nama_prodi'] . "</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="angkatan" class="col-sm-2 col-form-label">Angkatan:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="angkatan" name="angkatan" value="<?php echo $data['angkatan']; ?>" required>
        </div>
    </div>
    <div class="text-center">
        <input type="submit" name="update_mahasiswa" value="Update Mahasiswa" class="btn btn-primary">
    </div>
</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>
<?php
$conn->close();
?>
