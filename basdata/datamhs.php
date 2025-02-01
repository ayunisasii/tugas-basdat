<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
<nav class="navbar mb-5 navbar-expand-lg navbar-dark bg-info">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link text-dark" href="index.php">Keluar<span class="sr-only">(current)</span></a>
      </li>
    </ul>
    <span class="navbar-text text-dark">
      Fakultas Teknik Universitas Wiralodra
    </span>
  </div>
</nav>
<div class="container mt-5">
<h2 class="text-center mb-2">Data Mahasiswa</h2>
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalTambahMahasiswa">
        Tambah Data Mahasiswa
        </button>
        <table class="table table-hover table-info mt-3">
    <tr>
        <th>NO</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>TTL</th>
        <th>Alamat</th>
        <th>Fakultas</th>
        <th>Prodi</th>
        <th>Jenis Kelamin</th>
        <th>Angkatan</th>
        <th>Actions</th>
    </tr>
    <?php
    $result = $conn->query("SELECT m.nim, m.nama, m.ttl, m.alamat, p.nama_prodi, f.nama_fakultas, m.jenis_kelamin, m.angkatan 
                            FROM tb_mahasiswa m 
                            JOIN tb_prodi p ON m.kode_prodi = p.kode_prodi
                            JOIN tb_fakultas f ON m.kode_fakultas = f.kode_fakultas");
    $no = 3;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<th scope='row'>" . $no++ . "</th>";
        echo "<td>" . $row['nim'] . "</td>";
        echo "<td>" . $row['nama'] . "</td>";
        echo "<td>" . $row['ttl'] . "</td>";
        echo "<td>" . $row['alamat'] . "</td>";
        echo "<td>" . $row['nama_fakultas'] . "</td>";
        echo "<td>" . $row['nama_prodi'] . "</td>";
        echo "<td>" . $row['jenis_kelamin'] . "</td>";
        echo "<td>" . $row['angkatan'] . "</td>";
        echo "<td>";
        echo "<a href='edit_mhs.php?nim=" . $row['nim'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
        echo "<a href='delete_mhs.php?nim=" . $row['nim'] . "' class='btn btn-danger btn-sm'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>

<!-- Modal -->
<div class="modal fade" id="modalTambahMahasiswa" tabindex="-1" role="dialog" aria-labelledby="modalTambahMahasiswaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahMahasiswaLabel">Tambah Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="proses.php">
                    <div class="form-group row">
                        <label for="nim" class="col-sm-2 col-form-label">NIM:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nim" name="nim" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="jk" name="jk" required>
                            <option value="Pilih-JK">-Pilih Jenis Kelamin-</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ttl" class="col-sm-2 col-form-label">Tanggal Lahir:</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="ttl" name="ttl" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_fakultas" class="col-sm-2 col-form-label">Fakultas:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="kode_fakultas" required>
                                <?php
                                $result = $conn->query("SELECT kode_fakultas, nama_fakultas FROM tb_fakultas");
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['kode_fakultas'] . "'>" . $row['nama_fakultas'] . "</option>";
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
                                    echo "<option value='" . $row['kode_prodi'] . "'>" . $row['nama_prodi'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="angkatan" class="col-sm-2 col-form-label">Angkatan:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="angkatan" name="angkatan" required>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="add_mahasiswa" value="Tambah Mahasiswa" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>
<?php
$conn->close();
?>
