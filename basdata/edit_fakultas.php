<?php
include 'koneksi.php';
$kode_fakultas = $_GET['kode_fakultas'];
$sql = "SELECT * FROM tb_fakultas WHERE kode_fakultas='$kode_fakultas'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
} else {
  echo "No fakultas found with kode_fakultas: $kode_fakultas";
  exit();
}

// Handle form submission for editing program
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_fakultas'])) {
  $kode_fakultas_baru = $_POST['kode_fakultas_baru'];
  $nama_fakultas = $_POST['nama_fakultas'];
  $sql = "UPDATE tb_fakultas SET nama_fakultas='$nama_fakultas', kode_fakultas='$kode_fakultas_baru' WHERE kode_fakultas='$kode_fakultas'";
  if ($conn->query($sql) === TRUE) {
    echo "Fakultas updated successfully";
    header("Location: fakultas.php");
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Edit Fakultas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Fakultas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="card justify-items-center">
        <div class="modal-body ">
          <form method="POST">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Kode Fakultas Lama</label><br>   
              <input type="text" name="kode_fakultas" value="<?php echo $row['kode_fakultas']; ?>" readonly><br>
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Kode Fakultas Baru</label><br>   
              <input type="text" name="kode_fakultas_baru" value="<?php echo $row['kode_fakultas']; ?>" required><br>
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Nama Fakultas</label><br>   
              <input type="text" name="nama_fakultas" value="<?php echo $row['nama_fakultas']; ?>" required><br>
            </div>
            <input type="submit" name="edit_fakultas" value="Update Fakultas">
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <a href="fakultas.php"><button type="button">Close</button></a>
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
