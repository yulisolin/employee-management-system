<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../config/database.php';

$pageTitle = "Dashboard";

// Total pegawai
$queryTotal = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pegawai");
$totalPegawai = mysqli_fetch_assoc($queryTotal)['total'];

// Total jabatan unik
$queryJabatan = mysqli_query($conn, "SELECT COUNT(DISTINCT jabatan) AS total FROM pegawai");
$totalJabatan = mysqli_fetch_assoc($queryJabatan)['total'];

// Pegawai terbaru
$queryTerbaru = mysqli_query(
    $conn,
    "SELECT * FROM pegawai ORDER BY id DESC LIMIT 5"
);
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | Employee Management</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

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

        /* CONTENT */

        .main-content {
            margin-left: 260px;
            padding: 30px;
        }

        /* TOPBAR */

        .topbar {
            background: white;
            padding: 18px 22px;
            border-radius: 14px;
            margin-bottom: 25px;
        }

        /* STAT CARDS */

        .stat-card {
            border: none;
            border-radius: 15px;
            padding: 5px;
            box-shadow: 0 4px 15px rgba(0,0,0,.04);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f3f5;
            border-radius: 12px;
            font-size: 21px;
        }

        /* TABLE */

        .table-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,.04);
        }

        .employee-avatar {
            width: 38px;
            height: 38px;
            background: #212529;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        @media (max-width: 768px) {

            .sidebar {
                width: 75px;
            }

            .sidebar span,
            .brand-text {
                display: none;
            }

            .main-content {
                margin-left: 75px;
                padding: 15px;
            }

            .sidebar .nav-link {
                text-align: center;
            }

            .sidebar .nav-link i {
                margin-right: 0;
            }
        }

    </style>

</head>

<body>

<!-- SIDEBAR -->

<?php require 'partials/sidebar.php'; ?>


<!-- MAIN CONTENT -->

<div class="main-content">

    <!-- TOPBAR -->

    <?php require 'partials/topbar.php'; ?>


    <!-- WELCOME -->

    <div class="mb-4">

        <h3 class="fw-bold">
            Welcome back, <?= htmlspecialchars($_SESSION['nama']) ?> 👋
        </h3>

        <p class="text-secondary">
            Here's an overview of your employee data.
        </p>

    </div>


    <!-- STATISTICS -->

    <div class="row g-3 mb-4">

        <div class="col-md-4">

            <div class="card stat-card">

                <div class="card-body d-flex align-items-center">

                    <div class="stat-icon me-3">
                        <i class="bi bi-people"></i>
                    </div>

                    <div>

                        <small class="text-secondary">
                            Total Employees
                        </small>

                        <h3 class="mb-0 fw-bold">
                            <?= $totalPegawai ?>
                        </h3>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card stat-card">

                <div class="card-body d-flex align-items-center">

                    <div class="stat-icon me-3">
                        <i class="bi bi-briefcase"></i>
                    </div>

                    <div>

                        <small class="text-secondary">
                            Positions
                        </small>

                        <h3 class="mb-0 fw-bold">
                            <?= $totalJabatan ?>
                        </h3>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card stat-card">

                <div class="card-body d-flex align-items-center">

                    <div class="stat-icon me-3">
                        <i class="bi bi-database-check"></i>
                    </div>

                    <div>

                        <small class="text-secondary">
                            Database Status
                        </small>

                        <h5 class="mb-0 fw-bold">
                            Connected
                        </h5>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- RECENT EMPLOYEES -->

    <div class="card table-card">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h5 class="fw-bold mb-1">
                        Recent Employees
                    </h5>

                    <small class="text-secondary">
                        Latest employee records
                    </small>

                </div>


                <a
                    href="pegawai.php"
                    class="btn btn-dark btn-sm"
                >
                    View All
                </a>

            </div>


            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Employee</th>
                            <th>ID</th>
                            <th>Position</th>
                            <th>Email</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php while ($pegawai = mysqli_fetch_assoc($queryTerbaru)): ?>

                        <tr>

                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="employee-avatar me-3">

                                        <?= strtoupper(substr($pegawai['nama'], 0, 1)) ?>

                                    </div>

                                    <div class="fw-semibold">

                                        <?= htmlspecialchars($pegawai['nama']) ?>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <?= htmlspecialchars($pegawai['nip']) ?>

                            </td>


                            <td>

                                <span class="badge text-bg-light">

                                    <?= htmlspecialchars($pegawai['jabatan']) ?>

                                </span>

                            </td>


                            <td>

                                <?= htmlspecialchars($pegawai['email']) ?>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

<div class="text-center text-secondary small mt-4 mb-2">
    Employee Management System • PHP & MySQL
</div>

</div>

</body>

</html>