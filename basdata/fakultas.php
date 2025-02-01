<?php
include 'koneksi.php';

// Handle POST request for Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_fakultas'])) {
        $kode_fakultas = $_POST['kode_fakultas'];
        $nama_fakultas = $_POST['nama_fakultas'];
        $kode_prodi = $_POST['kode_prodi'];

        // Sanitize input to avoid SQL injection
        $kode_fakultas = $conn->real_escape_string($kode_fakultas);
        $nama_fakultas = $conn->real_escape_string($nama_fakultas);
        $kode_prodi = $conn->real_escape_string($kode_prodi);

        // Check if kode_prodi exists in tb_prodi
        $sql_check_prodi = "SELECT kode_prodi FROM tb_prodi WHERE kode_prodi = '$kode_prodi'";
        $result = $conn->query($sql_check_prodi);

        if ($result === FALSE) {
            echo "Error in query: " . $conn->error;
            exit;
        }

        if ($result->num_rows > 0) {
            // If kode_prodi exists, insert into tb_fakultas
            $sql = "INSERT INTO tb_fakultas (kode_fakultas, nama_fakultas, kode_prodi)
                    VALUES ('$kode_fakultas', '$nama_fakultas', '$kode_prodi')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('New fakultas added successfully'); window.location='fakultas.php';</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error: Kode prodi '$kode_prodi' tidak ditemukan dalam tabel tb_prodi";
        }
    } elseif (isset($_POST['edit_fakultas'])) {
        $kode_fakultas = $_POST['kode_fakultas'];
        $nama_fakultas = $_POST['nama_fakultas'];
        $kode_prodi = $_POST['kode_prodi'];

        // Sanitize input to avoid SQL injection
        $kode_fakultas = $conn->real_escape_string($kode_fakultas);
        $nama_fakultas = $conn->real_escape_string($nama_fakultas);
        $kode_prodi = $conn->real_escape_string($kode_prodi);

        $sql = "UPDATE tb_fakultas SET nama_fakultas='$nama_fakultas', kode_prodi='$kode_prodi' 
                WHERE kode_fakultas='$kode_fakultas'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Fakultas updated successfully'); window.location='fakultas.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Handle deletion of fakultas
if (isset($_GET['delete_fakultas'])) {
    $kode_fakultas = $_GET['delete_fakultas'];
    $sql = "DELETE FROM tb_fakultas WHERE kode_fakultas='$kode_fakultas'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Fakultas deleted successfully'); window.location='fakultas.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Fakultas</title>
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
        <h2>Data Fakultas</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFakultasModal">
            Tambah Fakultas
        </button>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Kode Fakultas</th>
                    <th>Nama Fakultas</th>
                    <th>Kode Prodi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT m.kode_fakultas, m.nama_fakultas, p.kode_prodi
                                        FROM tb_fakultas m 
                                        JOIN tb_prodi p ON m.kode_prodi = p.kode_prodi");
                if ($result === FALSE) {
                    echo "<tr><td colspan='4'>Error in query: " . $conn->error . "</td></tr>";
                } else {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['kode_fakultas'] . "</td>";
                        echo "<td>" . $row['nama_fakultas'] . "</td>";
                        echo "<td>" . $row['kode_prodi'] . "</td>";
                        echo "<td>";
                        echo "<a href='edit_fakultas.php?kode_fakultas=" . $row['kode_fakultas'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                        echo "<a href='fakultas.php?delete_fakultas=" . $row['kode_fakultas'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah/Edit Fakultas -->
    <div class="modal fade" id="addFakultasModal" tabindex="-1" role="dialog" aria-labelledby="addFakultasModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addFakultasModalLabel">Tambah Fakultas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode_fakultas">Kode Fakultas</label>
                            <input type="text" class="form-control" name="kode_fakultas" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_fakultas">Nama Fakultas</label>
                            <input type="text" class="form-control" name="nama_fakultas" required>
                        </div>
                        <div class="form-group">
                            <label for="kode_prodi">Kode Prodi</label>
                            <input type="text" class="form-control" name="kode_prodi" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="add_fakultas" class="btn btn-primary">Tambah Fakultas</button>
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
