<?php
session_start();
require_once 'config/database.php';

if (isset($_SESSION['login'])) {
    header("Location: admin/index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];

        header("Location: admin/index.php");
        exit;

    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Employee Management System</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            min-height: 100vh;
        }

        .login-wrapper {
            min-height: 100vh;
        }

        .login-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
        }

        .login-brand {
            background: #212529;
            color: white;
            padding: 45px;
        }

        .login-form {
            padding: 45px;
            background: white;
        }

        .brand-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.12);
            font-size: 28px;
            margin-bottom: 25px;
        }

        .form-control {
            padding: 12px 14px;
            border-radius: 10px;
        }

        .btn-login {
            padding: 12px;
            border-radius: 10px;
        }

        @media (max-width: 767px) {
            .login-brand {
                display: none;
            }

            .login-form {
                padding: 30px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="row justify-content-center align-items-center login-wrapper">

        <div class="col-lg-9 col-xl-8">

            <div class="card login-card">

                <div class="row g-0">

                    <!-- LEFT SIDE -->

                    <div class="col-md-6 login-brand">

                        <div class="brand-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>

                        <h2 class="fw-bold">
                            Employee<br>
                            Management
                        </h2>

                        <p class="mt-3 text-white-50">
                            Manage employee information efficiently through
                            a simple and modern dashboard.
                        </p>

                        <div class="mt-5 small text-white-50">
                            PHP • MySQL • Bootstrap
                        </div>

                    </div>


                    <!-- LOGIN FORM -->

                    <div class="col-md-6 login-form">

                        <div class="mb-4">

                            <h3 class="fw-bold mb-2">
                                Welcome Back
                            </h3>

                            <p class="text-secondary">
                                Sign in to access your dashboard.
                            </p>

                        </div>


                        <?php if ($error): ?>

                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                <?= htmlspecialchars($error) ?>
                            </div>

                        <?php endif; ?>


                        <form method="POST">

                            <div class="mb-3">

                                <label class="form-label">
                                    Username
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-white">
                                        <i class="bi bi-person"></i>
                                    </span>

                                    <input
                                        type="text"
                                        name="username"
                                        class="form-control"
                                        placeholder="Enter username"
                                        required
                                    >

                                </div>

                            </div>


                            <div class="mb-4">

                                <label class="form-label">
                                    Password
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-white">
                                        <i class="bi bi-lock"></i>
                                    </span>

                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        placeholder="Enter password"
                                        required
                                    >

                                </div>

                            </div>


                            <button
                                type="submit"
                                class="btn btn-dark btn-login w-100 fw-semibold"
                            >
                                Sign In
                                <i class="bi bi-arrow-right ms-2"></i>
                            </button>

                        </form>


                        <div class="text-center mt-4">

                            <small class="text-secondary">
                                Employee Management System
                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>