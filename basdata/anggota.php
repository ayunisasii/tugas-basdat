<?php
include 'koneksi.php';

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data pada tabel anggota
$sql = "SELECT nim, nama, prodi, foto FROM anggota";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ------------------- ICON PADA TAB --------------------- -->
    <link rel="icon" href="img/icon.png" type="image/x-icon">

    <!-- -------------------TITLE --------------------- -->
    <title>Anggota Kelompok</title>

    <!-- -------------------BOOTSTRAP --------------------- -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .card {
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <div>
        <!-- ------------------- NAV BAR --------------------- -->
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" style="color: white;">KELOMPOK III</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-link active">
                            <a class="nav-link" style="color: white;" href="index.php"> HOME</a>
                        </li>
                        <li class="nav-link active">
                            <a class="nav-link" style="color: white;" href="data_fakultas.php">FAKULTAS</a>
                        </li>
                        <li class="nav-link active">
                            <a class="nav-link" style="color: white;" href="data_prodi.php">PRODI</a>
                        </li>
                        <li class="nav-link active">
                            <a class="nav-link" style="color: white;" href="data_anggota.php">ANGGOTA KELOMPOK</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <h2 class="text-center fw-bold mt-4"> DATA ANGGOTA KELOMPOK III</h2>


        <!-- -------------------CARD ANGGOTA KELOMPOK II --------------------- -->
        <div class="card-group my-5">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card" style="width: 18rem;">
                <img src="' . $row["foto"] . '" class="card-img-top" alt="Foto Mahasiswa">
                <div class="card-body">
                    <h5 class="card-title">' . $row["nama"] . '</h5>
                    <p class="card-text">
                        NIM : ' . $row["nim"] . '<br>
                        Program Studi : ' . $row["prodi"] . '
                    </p>
                </div>
            </div>';
                }
            } else {
                echo "Tidak ada data.";
            }
            $conn->close();
            ?>


        </div>
    </div>

</body>

</html>