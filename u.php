<?php
    session_start();
    $idx = isset($_GET['u']) ? $_GET['u'] : false;

    // kalo index tidak ada atau blom ada sessionnya -> redirect -> /
    if ($idx === false || !isset($_SESSION['tugas'][$idx])) {
        header('Location: /');
    }

    // ambil data dari session
    $tugas = $_SESSION['tugas'][$idx]['tugas'];
    $waktu = $_SESSION['tugas'][$idx]['waktu'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tugas = $_POST['tugas'];
        $waktu = $_POST['waktu'];

        // jika 2 data yang diinputkan tidak kosong maka simpan data yang baru trus redirect -> /
        if (!empty($tugas) && !empty($waktu)) {
            $_SESSION['tugas'][$idx] = ['tugas' => $tugas, 'waktu' => $waktu];
            header('Location: /');
            exit; 
        }
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit - <?= $tugas ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container-flex">
        <div class="form-container">
            <form action="" method="post"> 
                <label for="tugas">Masukkan tugasmu</label>
                <input type="text" name="tugas" id="tugas" value="<?= htmlspecialchars($tugas); ?>" required>
                <label for="waktu">Waktu mengerjakan:</label>
                <select name="waktu" id="waktu">
                    <?php 
                        for ($i = 1; $i <= 24; $i++) {
                            // loop sampai ketemu waktu yang ke select
                            $selected = ($i == $waktu) ? 'selected' : ''; 
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