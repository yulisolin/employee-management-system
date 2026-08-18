<div class="sidebar">

    <div class="brand">

        <span class="brand-icon">
            <i class="bi bi-people-fill"></i>
        </span>

        <span class="brand-text">
            EMS
        </span>

    </div>

    <nav class="nav flex-column">

        <a
            href="index.php"
            class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>"
        >
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>

        <a
            href="pegawai.php"
            class="nav-link <?= in_array(basename($_SERVER['PHP_SELF']), ['pegawai.php','tambah.php','edit.php']) ? 'active' : '' ?>"
        >
            <i class="bi bi-people"></i>
            <span>Employees</span>
        </a>

        <a
            href="../logout.php"
            class="nav-link mt-4"
        >
            <i class="bi bi-box-arrow-left"></i>
            <span>Logout</span>
        </a>

    </nav>

</div>