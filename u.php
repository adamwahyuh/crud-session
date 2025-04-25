<?php
include("koneksi.php");
$id = isset($_GET['u']) ? $_GET['u'] : false;

// panggil func
$tugasList = getAllTugasById($id);
// cek kalo tugas kosong 
if (!$tugasList) {
    header('Location: /');
    exit();
}
// Ambil arr pertama setelah di ambil data dari id-nya di atas
$tugas = $tugasList[0] ?? ['deskripsi' => '', 'waktu' => ''];

// Update 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tugasPost = $_POST['tugas'];
    $waktuStr = $_POST['waktu'];  
    $waktu = (int) $waktuStr;
    if (empty($tugasPost) || empty($waktu)) {
        header('Location: ' . $_SERVER['SCRIPT_NAME']);
        exit;
    } else {
        updateTugas($id, $tugasPost, $waktu);
        header('Location: ' . $_SERVER['SCRIPT_NAME']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit - <?= htmlspecialchars($tugas['deskripsi']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container-flex">
        <div class="form-container">
            <form action="" method="post"> 
                <label for="tugas">Masukkan tugasmu</label>
                <input type="text" name="tugas" id="tugas" value="<?= htmlspecialchars($tugas['deskripsi']); ?>" required>

                <label for="waktu">Waktu mengerjakan:</label>
                <select name="waktu" id="waktu">
                    <?php 
                        for ($i = 1; $i <= 24; $i++) {
                            $selected = ($i == $tugas['waktu']) ? 'selected' : ''; 
                            echo "<option value='$i' $selected>$i</option>";
                        }
                    ?>
                </select>
                <button type="submit">Simpan</button>
                <a href="index.php">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>
