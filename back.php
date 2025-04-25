<?php
function masukData($tugas, $waktu){
    global $kon;
    $sql = "INSERT INTO tugas (deskripsi, waktu) VALUES ('$tugas', '$waktu')";
    $kon->exec($sql);
}
function hapusData($d){
    global $kon;
    $sql = "DELETE FROM tugas WHERE id = " . $d;
    $kon->exec($sql);
}
function getAllTugas(){
    global $kon;
    $stmt = $kon->query("SELECT * FROM tugas ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function hapusSemuaData(){
    global $kon;
    $kon->exec("DELETE FROM tugas");
}
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