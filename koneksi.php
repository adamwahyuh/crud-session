<?php

try {
    $conn = new \PDO('sqlite:./database.db');
    echo'Duck is Ducking in the river';
}catch (\PDOException $e) {
    echo $e->getMessage();
}