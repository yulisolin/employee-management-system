<div class="topbar d-flex justify-content-between align-items-center">

    <div>

        <h4 class="mb-1 fw-bold">
            <?= htmlspecialchars($pageTitle ?? 'Employee Management') ?>
        </h4>

        <small class="text-secondary">
            Employee Management System
        </small>

    </div>

    <div class="text-end">

        <small class="text-secondary">
            Logged in as
        </small>

        <div class="fw-semibold">
            <?= htmlspecialchars($_SESSION['nama']) ?>
        </div>

    </div>

</div>