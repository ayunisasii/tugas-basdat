<?php
include 'koneksi.php';

// Handle form submission for adding new program
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_prodi'])) {
    // Pastikan semua input tersedia dan aman
    if (isset($_POST['kode_prodi'], $_POST['nama_prodi'], $_POST['kode_fakultas'])) {
        $kode_prodi = mysqli_real_escape_string($conn, $_POST['kode_prodi']);
        $nama_prodi = mysqli_real_escape_string($conn, $_POST['nama_prodi']);
        $kode_fakultas = mysqli_real_escape_string($conn, $_POST['kode_fakultas']);

        // Query SQL untuk memasukkan data
        $sql = "INSERT INTO tb_prodi (kode_prodi, nama_prodi, kode_fakultas) 
                VALUES ('$kode_prodi', '$nama_prodi', '$kode_fakultas')";

        // Eksekusi query
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New prodi added successfully');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: Semua input harus diisi.";
    }
}

// Handle form submission for editing program
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_prodi'])) {
    $kode_prodi = $_POST['kode_prodi'];
    $nama_prodi = $_POST['nama_prodi'];
    $sql = "UPDATE tb_prodi SET nama_prodi='$nama_prodi' WHERE kode_prodi='$kode_prodi'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Prodi updated successfully'); window.location='dataprodi.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle deletion of program
if (isset($_GET['delete_prodi'])) {
    $kode_prodi = $_GET['delete_prodi'];
    $sql = "DELETE FROM tb_prodi WHERE kode_prodi='$kode_prodi'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Prodi deleted successfully'); window.location='dataprodi.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Program Studi</title>
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
                    <a class="nav-link" href="index.php">Keluar<span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <span class="navbar-text">
                Fakultas Teknik Universitas Wiralodra
            </span>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Data Program Studi</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProdiModal">
            Tambah Program Studi
        </button>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Kode Prodi</th>
                    <th>Nama Prodi</th>
                    <th>Kode Fakultas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query SQL untuk mengambil data prodi beserta nama fakultas
                
                // Asumsi Anda sudah memiliki koneksi ke database dalam variabel $conn
                $result = $conn->query("SELECT m.kode_prodi, m.nama_prodi, p.kode_fakultas
                    FROM tb_prodi m 
                    JOIN tb_fakultas p ON m.kode_fakultas = p.kode_fakultas

                ");
                            
                // Periksa apakah query berhasil dieksekusi
                if ($result === false) {
                    echo "Error executing query: " . $conn->error;
                } else {
                    // Periksa apakah ada baris yang dikembalikan
                    if ($result->num_rows > 0) {
                        // Tampilkan data dalam bentuk tabel
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['kode_prodi'] . "</td>";
                            echo "<td>" . $row['nama_prodi'] . "</td>";
                            echo "<td>" . $row['kode_fakultas'] . "</td>";
                            echo "<td>";
                            echo "<a href='edit_prodi.php?kode_prodi=" . $row['kode_prodi'] . "' class='btn btn-warning btn-sm'>Edit</a>";
                            echo "<a href='dataprodi.php?delete_prodi=" . $row['kode_prodi'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No records found</td></tr>";
                    }
                    // Selalu pastikan untuk melepaskan hasil query setelah selesai menggunakannya
                    $result->free_result();
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Prodi -->
    <div class="modal fade" id="addProdiModal" tabindex="-1" role="dialog" aria-labelledby="addProdiModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProdiModalLabel">Tambah Program Studi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode_prodi">Kode Prodi</label>
                            <input type="text" class="form-control" name="kode_prodi" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_prodi">Nama Prodi</label>
                            <input type="text" class="form-control" name="nama_prodi" required>
                        </div>
                        <div class="form-group">
                            <label for="kode_fakultas">Kode Fakultas</label>
                            <input type="text" class="form-control" name="kode_fakultas" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="add_prodi" class="btn btn-primary">Tambah Prodi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>

</html>

<?php
$conn->close();
?>
