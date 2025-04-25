<?php
include("koneksi.php");
$id = isset($_GET['u']) ? $_GET['u'] : false;

function getAllTugasById($id) {
    global $kon;
    if (!$id) {
        header('Location: /');
        exit();
    } else {
        $stmt = $kon->prepare("SELECT * FROM tugas WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

function updateTugas($id, $deskripsi, $waktu){
    global $kon;
    if (empty($deskripsi) || empty($waktu)){
        header('Location: /');
        exit();
    }
    
    $stmt = $kon->prepare("UPDATE tugas SET deskripsi = :deskripsi, waktu = :waktu WHERE id = :id");
    $stmt->bindParam(':deskripsi', $deskripsi);
    $stmt->bindParam(':waktu', $waktu, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

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
        // Menggunakan $tugasPost untuk update
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
