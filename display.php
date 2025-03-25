<?php 
    session_start();

    $idx = isset($_GET['u']) ? $_GET['u'] : false;

    if ($idx === false || !isset($_SESSION['tugas'][$idx])) {
        header('Location: /');
    }

    $tugas = $_SESSION['tugas'][$idx]['tugas'];
    $waktu = $_SESSION['tugas'][$idx]['waktu'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show - <?= $tugas ?></title>
    <link rel="stylesheet" href="display.css">
</head>
<body>
    
    <div class="container-flex">
        <h2>Tugas :</h2>
        <div class="list-tugas">
            <ol>
                <li><?= $tugas ?></li>
                <li><?= $waktu ?></li>
            </ol>
        </div>
        <a href="index.php">Kembali</a>
    </div>
</body>
</html>