<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Todo App - Adam Wahyu H</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php 
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tugas = $_POST['tugas'];
        $waktu = $_POST['waktu'];

        // cek kalo inputan kosong -> redirect ke /
        if(empty($tugas) || empty($waktu)){
            header('Location: ' . $_SERVER['SCRIPT_NAME']);

        }
        else {
            // cek kalo session tugas udah ada
            if(isset($_SESSION['tugas'])){
                // push ke session tugas
                array_push($_SESSION['tugas'], ['tugas' => $tugas, 'waktu' => $waktu]);
            }
            else {
                // kalo session tugas belum ada, buat session tugas
                $_SESSION['tugas'] = [['tugas' => $tugas, 'waktu' => $waktu]];
            }
            header('Location: ' . $_SERVER['SCRIPT_NAME']);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $delete = isset($_GET['d']) ? $_GET['d'] : false;
        if($delete !== false){
            unset($_SESSION['tugas'][$delete]);
            header('Location: ' . $_SERVER['SCRIPT_NAME']);
        }
    }
?>
<div class="container-flex">
    <div class="form-container">
        <form action="/" method="post">
            <label for="tugas">Masukan tugasmu</label>
            <input type="text" name="tugas" id="tugas" required>
            <!-- <label for="waktu">Waktu mengerjakan: </label> -->
            <select name="waktu" id="waktu" >
                <option value="0" disabled selected>Pilih waktu pengerjaan</option>
                <?php 
                    for($i = 1; $i <= 24; $i++) {
                        echo "<option value='$i'>$i</option>";
                    }
                ?>
            </select>
            <button type="submit">simpan</button>
        </form>
    </div>
    <div class="list-tugas">
    <?php if(isset($_SESSION['tugas'])): ?>
        <h2>Daftar Tugas</h2>
        <ul>
            <?php foreach($_SESSION['tugas'] as $idx => $value): ?>
                <li>
                    <div class="tugas">
                        <p><?= $value['tugas'] ?></p>
                    </div>
                    <div class="waktu">
                        <p><?= $value['waktu'] ?> jam</p>
                    </div>
                    <div class="act-button">
                        <a class="hapus" href="?d=<?= $idx ?>"><i class="bi bi-trash3-fill"></i></a>
                        <a class="edit" href="u.php?u=<?= $idx ?>"><i class="bi bi-pencil-fill"></i></a>
                        <a class="info" href="display.php?u=<?= $idx ?>"><i class="bi bi-eye-fill"></i></a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php else :?>
            <p>Belum ada tugas</p>
    <?php endif;
    ?>
    </div>
</div>

</body>
</html>