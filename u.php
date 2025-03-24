<?php
session_start();
$idx = isset($_GET['u']) ? $_GET['u'] : false;

if ($idx === false || !isset($_SESSION['tugas'][$idx])) {
    header('Location: /');
}

// Fetch frm session
$tugas = $_SESSION['tugas'][$idx]['tugas'];
$waktu = $_SESSION['tugas'][$idx]['waktu'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tugas = $_POST['tugas'];
    $waktu = $_POST['waktu'];

    if (!empty($tugas) && !empty($waktu)) { // Gunakan AND agar dua-duanya harus ada
        $_SESSION['tugas'][$idx] = ['tugas' => $tugas, 'waktu' => $waktu];
        header('Location: /');
        exit; 
    }
}
?>

<form action="" method="post"> 
    <label for="tugas">Masukkan tugasmu</label>
    <input type="text" name="tugas" id="tugas" value="<?php echo htmlspecialchars($tugas); ?>" required>

    <label for="waktu">Waktu mengerjakan:</label>
    <select name="waktu" id="waktu">
        <?php 
            for ($i = 1; $i <= 24; $i++) {
                $selected = ($i == $waktu) ? 'selected' : ''; 
                echo "<option value='$i' $selected>$i</option>";
            }
        ?>
    </select>
    
    <button type="submit">Simpan</button>
</form>
