<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../config/database.php';

/* Hanya izinkan request POST */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: pegawai.php");
    exit;
}

/* Validasi ID */
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    header("Location: pegawai.php");
    exit;
}

$id = (int) $_POST['id'];

/* Hapus menggunakan prepared statement */
$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM pegawai WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {

    header("Location: pegawai.php?status=deleted");
    exit;

} else {

    header("Location: pegawai.php?status=error");
    exit;
}
?>