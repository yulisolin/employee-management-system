<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../config/database.php';

$pageTitle = "Edit Employee";

$error = "";

/* =========================
   AMBIL ID
========================= */

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: pegawai.php");
    exit;
}

$id = (int) $_GET['id'];


/* =========================
   AMBIL DATA PEGAWAI
========================= */

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM pegawai WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$pegawai = mysqli_fetch_assoc($result);

if (!$pegawai) {
    header("Location: pegawai.php");
    exit;
}


/* =========================
   PROSES UPDATE
========================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nip = trim($_POST['nip']);
    $nama = trim($_POST['nama']);
    $jabatan = trim($_POST['jabatan']);
    $email = trim($_POST['email']);
    $telepon = trim($_POST['telepon']);
    $alamat = trim($_POST['alamat']);

    if ($nip === '' || $nama === '' || $jabatan === '') {

    $error = "Employee ID, name, and position are required.";

} elseif ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {

    $error = "Please enter a valid email address.";

} else {

        $stmtUpdate = mysqli_prepare(
            $conn,
            "UPDATE pegawai
             SET nip = ?,
                 nama = ?,
                 jabatan = ?,
                 email = ?,
                 telepon = ?,
                 alamat = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmtUpdate,
            "ssssssi",
            $nip,
            $nama,
            $jabatan,
            $email,
            $telepon,
            $alamat,
            $id
        );

        if (mysqli_stmt_execute($stmtUpdate)) {

            header("Location: pegawai.php?status=updated");
            exit;

        } else {

            if (mysqli_errno($conn) === 1062) {
                $error = "Employee ID already exists.";
            } else {
                $error = "Failed to update employee.";
            }

        }

    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Employee | Employee Management</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
rel="stylesheet">

<style>

body {
    background: #f5f7fb;
}

.sidebar {
    width: 260px;
    min-height: 100vh;
    background: #212529;
    position: fixed;
    left: 0;
    top: 0;
    padding: 25px 18px;
}

.brand {
    color: white;
    font-weight: 700;
    font-size: 20px;
    margin-bottom: 35px;
}

.brand-icon {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,.1);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    margin-right: 10px;
}

.sidebar .nav-link {
    color: #adb5bd;
    padding: 12px 15px;
    margin-bottom: 7px;
    border-radius: 9px;
}

.sidebar .nav-link:hover,
.sidebar .nav-link.active {
    background: rgba(255,255,255,.1);
    color: white;
}

.sidebar .nav-link i {
    margin-right: 10px;
}

.main-content {
    margin-left: 260px;
    padding: 30px;
}

.topbar {
    background: white;
    padding: 18px 22px;
    border-radius: 14px;
    margin-bottom: 25px;
}

.form-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,.04);
}

.form-control {
    padding: 11px 13px;
    border-radius: 9px;
}

@media (max-width: 768px) {

    .sidebar {
        width: 75px;
    }

    .sidebar span,
    .brand-text {
        display: none;
    }

    .sidebar .nav-link {
        text-align: center;
    }

    .sidebar .nav-link i {
        margin-right: 0;
    }

    .main-content {
        margin-left: 75px;
        padding: 15px;
    }

}

</style>

</head>

<body>


<!-- SIDEBAR -->

<?php require 'partials/sidebar.php'; ?>

<!-- MAIN -->

<div class="main-content">


<!-- TOPBAR -->

<?php require 'partials/topbar.php'; ?>

<div class="row justify-content-center">

<div class="col-lg-9">


<div class="card form-card">

<div class="card-body p-4 p-md-5">


<div class="mb-4">

<h4 class="fw-bold mb-1">
Employee Information
</h4>

<p class="text-secondary mb-0">
Update the employee details below.
</p>

</div>


<?php if ($error): ?>

<div class="alert alert-danger">

<i class="bi bi-exclamation-circle me-2"></i>

<?= htmlspecialchars($error) ?>

</div>

<?php endif; ?>


<form method="POST">


<div class="row g-3">


<!-- ID -->

<div class="col-md-6">

<label class="form-label">

Employee ID
<span class="text-danger">*</span>

</label>

<input
type="text"
name="nip"
class="form-control"
value="<?= htmlspecialchars($_POST['nip'] ?? $pegawai['nip']) ?>"
required>

</div>


<!-- NAME -->

<div class="col-md-6">

<label class="form-label">

Full Name
<span class="text-danger">*</span>

</label>

<input
type="text"
name="nama"
class="form-control"
value="<?= htmlspecialchars($_POST['nama'] ?? $pegawai['nama']) ?>"
required>

</div>


<!-- POSITION -->

<div class="col-md-6">

<label class="form-label">

Position
<span class="text-danger">*</span>

</label>

<input
type="text"
name="jabatan"
class="form-control"
value="<?= htmlspecialchars($_POST['jabatan'] ?? $pegawai['jabatan']) ?>"
required>

</div>


<!-- EMAIL -->

<div class="col-md-6">

<label class="form-label">
Email
</label>

<input
type="email"
name="email"
class="form-control"
value="<?= htmlspecialchars($_POST['email'] ?? $pegawai['email']) ?>">

</div>


<!-- PHONE -->

<div class="col-md-6">

<label class="form-label">
Phone Number
</label>

<input
type="text"
name="telepon"
class="form-control"
value="<?= htmlspecialchars($_POST['telepon'] ?? $pegawai['telepon']) ?>">

</div>


<!-- ADDRESS -->

<div class="col-12">

<label class="form-label">
Address
</label>

<textarea
name="alamat"
class="form-control"
rows="4"><?= htmlspecialchars($_POST['alamat'] ?? $pegawai['alamat']) ?></textarea>

</div>


<div class="col-12 mt-4">

<div class="d-flex justify-content-end gap-2">


<a
href="pegawai.php"
class="btn btn-light px-4">

Cancel

</a>


<button
type="submit"
class="btn btn-dark px-4">

<i class="bi bi-check-lg me-2"></i>

Update Employee

</button>


</div>

</div>


</div>

</form>


</div>

</div>


</div>

</div>

<div class="text-center text-secondary small mt-4 mb-2">
    Employee Management System • PHP & MySQL
</div>

</div>

</body>

</html>