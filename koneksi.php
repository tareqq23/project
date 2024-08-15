<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'esurvey';

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}
?>
