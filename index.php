<?php 
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tugas = $_POST['tugas'];
        $waktu = $_POST['waktu'];
        
        if(empty($tugas) || empty($waktu)){
            header('Location: ' . $_SERVER['SCRIPT_NAME']);

        }
        else {
            if(isset($_SESSION['tugas'])){
                array_push($_SESSION['tugas'], ['tugas' => $tugas, 'waktu' => $waktu]);
            }
            else {
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

<form action="/" method="post">
    <label for="tugas">Masukan tugasmu</label>
    <input type="text" name="tugas" id="tugas" required>
    <label for="waktu">Waktu mengerjakan: </label>
    <select name="waktu" id="waktu" >
        <?php 
            for($i = 1; $i <= 24; $i++) {
                echo "<option value='$i'>$i</option>";
            }
        ?>
    </select>
    <button type="submit">simpan</button>
</form>

<?php if(isset($_SESSION['tugas'])): ?>
    <h2>Daftar Tugas</h2>
    <ul>
        <?php foreach($_SESSION['tugas'] as $idx => $value): ?>
            <li>
                <p><?= $value['tugas'] ?></p>
                <p><?= $value['waktu'] ?> jam</p>
                <a href="?d=<?= $idx ?>">Hapus</a>
                <a href="u.php?u=<?= $idx ?>">Edit</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php else :?>
        <p>Belum ada tugas</p>
<?php endif;
?>