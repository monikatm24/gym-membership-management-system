<div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-white shadow-sm rounded">

    <!-- LEFT SIDE: PAGE TITLE -->
    <div>
        <h5 class="mb-0"><?= $pageTitle ?? 'Gym System' ?></h5>
    </div>

    <!-- RIGHT SIDE: NAV BUTTONS -->
    <div class="d-flex gap-2">

        <a href="/gym_system/dashboard.php" class="btn btn-sm btn-dark">
            🏠 Dashboard
        </a>

        <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary">
            ⬅ Back
        </a>

    </div>

</div>