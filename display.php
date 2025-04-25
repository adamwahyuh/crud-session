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
$tugasList = getAllTugasById($id);
// cek kalo tugas kosong 
if (!$tugasList) {
    header('Location: /');
    exit();
}
$tugas = $tugasList[0] ?? ['deskripsi' => '', 'waktu' => ''];

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
                <li><?= htmlspecialchars($tugas['deskripsi']); ?></li>
                <h2 style="text-align: center;">Waktu :</h2>
                <li><?= htmlspecialchars($tugas['waktu']); ?> Jam</li>
            </ol>
        </div>
        <a href="index.php">Kembali</a>
    </div>
</body>
</html>