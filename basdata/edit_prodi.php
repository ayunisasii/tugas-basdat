<?php
include 'koneksi.php';
$kode_prodi = $_GET['kode_prodi'];
$sql = "SELECT * FROM tb_prodi WHERE kode_prodi='$kode_prodi'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No prodi found with kode_prodi: $kode_prodi";
    exit();
}

// Handle form submission for editing program
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_prodi'])) {
    $kode_prodi = $_POST['kode_prodi'];
    $nama_prodi = $_POST['nama_prodi'];
    $sql = "UPDATE tb_prodi SET nama_prodi='$nama_prodi' WHERE kode_prodi='$kode_prodi'";
    if ($conn->query($sql) === TRUE) {
        echo "Prodi updated successfully";
        header("Location: dataprodi.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Program Studi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Program Studi</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card justify-items-center">
                <div class="modal-body ">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Kode Prodi</label><br>
                            <input type="text" name="kode_prodi" value="<?php echo $row['kode_prodi']; ?>" required><br>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nama Prodi</label><br>
                            <input type="text" name="nama_prodi" value="<?php echo $row['nama_prodi']; ?>" required><br>
                        </div>
                        <input type="submit" name="edit_prodi" value="Update Prodi">
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="dataprodi.php"><button type="button">close</button></a>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>

<?php
$conn->close();
?>