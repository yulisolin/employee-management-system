<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../config/database.php';

$pageTitle = "Employees";

/* SEARCH */
$keyword = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($keyword !== '') {

    $search = "%" . $keyword . "%";

    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM pegawai
         WHERE nama LIKE ?
         OR nip LIKE ?
         OR jabatan LIKE ?
         OR email LIKE ?
         ORDER BY id DESC"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssss",
        $search,
        $search,
        $search,
        $search
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

} else {

    $result = mysqli_query(
        $conn,
        "SELECT * FROM pegawai ORDER BY id DESC"
    );
}

$totalData = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Employees | Employee Management</title>

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

/* SIDEBAR */

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

/* MAIN */

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

.table-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,.04);
}

.employee-avatar {
    width: 40px;
    height: 40px;
    background: #212529;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.search-box {
    max-width: 350px;
}

.action-btn {
    width: 35px;
    height: 35px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
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

<!-- MAIN CONTENT -->

<div class="main-content">


<?php require 'partials/topbar.php'; ?>

<!-- TITLE -->

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">

<div>

<h3 class="fw-bold mb-1">
Employee Directory
</h3>

<p class="text-secondary mb-0">

<?= $totalData ?> employee(s) found

</p>

</div>


<a href="tambah.php" class="btn btn-dark">

<i class="bi bi-plus-lg me-2"></i>

Add Employee

</a>

</div>



<!-- SUCCESS MESSAGE -->

<?php if (isset($_GET['status'])): ?>

<?php if ($_GET['status'] === 'added'): ?>

<div class="alert alert-success alert-dismissible fade show">

<i class="bi bi-check-circle me-2"></i>

Employee successfully added.

<button
type="button"
class="btn-close"
data-bs-dismiss="alert">
</button>

</div>

<?php elseif ($_GET['status'] === 'updated'): ?>

<div class="alert alert-success alert-dismissible fade show">

<i class="bi bi-check-circle me-2"></i>

Employee successfully updated.

<button
type="button"
class="btn-close"
data-bs-dismiss="alert">
</button>

</div>

<?php elseif ($_GET['status'] === 'deleted'): ?>

<div class="alert alert-success alert-dismissible fade show">

<i class="bi bi-check-circle me-2"></i>

Employee successfully deleted.

<button
type="button"
class="btn-close"
data-bs-dismiss="alert">
</button>

</div>

<?php elseif ($_GET['status'] === 'error'): ?>

<div class="alert alert-danger alert-dismissible fade show">

    <i class="bi bi-exclamation-circle me-2"></i>

    Something went wrong. Please try again.

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

<?php endif; ?>

<?php endif; ?>



<!-- TABLE CARD -->

<div class="card table-card">

<div class="card-body p-4">


<!-- SEARCH -->

<div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">

<form method="GET" class="search-box w-100">

<div class="input-group">

<span class="input-group-text bg-white">

<i class="bi bi-search"></i>

</span>

<input
type="text"
name="search"
class="form-control"
placeholder="Search employees..."
value="<?= htmlspecialchars($keyword) ?>"
>

<button class="btn btn-dark">
Search
</button>

</div>

</form>


<?php if ($keyword !== ''): ?>

<a
href="pegawai.php"
class="btn btn-outline-secondary">

<i class="bi bi-x-lg me-1"></i>

Clear Search

</a>

<?php endif; ?>

</div>



<!-- TABLE -->

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th>Employee</th>
<th>Employee ID</th>
<th>Position</th>
<th>Email</th>
<th>Phone</th>
<th class="text-end">Actions</th>

</tr>

</thead>


<tbody>

<?php if ($totalData > 0): ?>

<?php while ($pegawai = mysqli_fetch_assoc($result)): ?>

<tr>

<td>

<div class="d-flex align-items-center">

<div class="employee-avatar me-3">

<?= strtoupper(substr($pegawai['nama'], 0, 1)) ?>

</div>

<div>

<div class="fw-semibold">

<?= htmlspecialchars($pegawai['nama']) ?>

</div>

<small class="text-secondary">

<?= htmlspecialchars($pegawai['alamat']) ?>

</small>

</div>

</div>

</td>


<td>

<span class="badge text-bg-light">

<?= htmlspecialchars($pegawai['nip']) ?>

</span>

</td>


<td>

<?= htmlspecialchars($pegawai['jabatan']) ?>

</td>


<td>

<?= htmlspecialchars($pegawai['email']) ?>

</td>


<td>

<?= htmlspecialchars($pegawai['telepon']) ?>

</td>


<td class="text-end">

<a
href="edit.php?id=<?= $pegawai['id'] ?>"
class="btn btn-outline-dark btn-sm action-btn"
title="Edit">

<i class="bi bi-pencil"></i>

</a>


<form
    method="POST"
    action="hapus.php"
    class="d-inline"
    onsubmit="return confirm('Are you sure you want to delete this employee?');"
>

    <input
        type="hidden"
        name="id"
        value="<?= $pegawai['id'] ?>"
    >

    <button
        type="submit"
        class="btn btn-outline-danger btn-sm action-btn"
        title="Delete"
    >

        <i class="bi bi-trash"></i>

    </button>

</form>

</td>

</tr>

<?php endwhile; ?>


<?php else: ?>

<tr>

<td colspan="6" class="text-center py-5">

<i class="bi bi-search fs-2 text-secondary"></i>

<h6 class="mt-3">
No employees found
</h6>

<p class="text-secondary small mb-0">

Try another search keyword.

</p>

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</div>

<div class="text-center text-secondary small mt-4 mb-2">
    Employee Management System • PHP & MySQL
</div>

</div>


<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>