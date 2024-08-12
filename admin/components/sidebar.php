<!-- partial:partials/_sidebar.html -->
<style>
    .sidebar {
        font-family: 'Nunito Sans', sans-serif !important;
    }
</style>
<nav class="sidebar sidebar-offcanvas " id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link" title="<?= isset($_SESSION['name']) ? $_SESSION['name'] : 'User' ?>">
                <div class="nav-profile-image">
                    <img src="assets/images/faces/user.webp" alt="profile">
                    <span class="login-status online" title="online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">
                        <?= isset($_SESSION['name']) ? $_SESSION['name'] : 'User' ?>
                    </span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge" title="online"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <?php
        if ($_SESSION['staff'] == 0) {
            ?>
            <li class="nav-item">
                <a class="nav-link" href="staff.php">
                    <span class="menu-title">Staff</span>
                    <i class="mdi mdi-account menu-icon"></i>
                </a>
            </li>
            <?php
        }
        ?>
        <li class="nav-item">
            <a class="nav-link" href="course.php">
                <span class="menu-title">Courses</span>
                <!-- <i class="menu-arrow"></i> -->
                <i class="mdi mdi-note-text menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="students.php">
                <span class="menu-title">Students</span>
                <!-- <i class="menu-arrow"></i> -->
                <i class="mdi mdi-account menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#examses" aria-expanded="false" aria-controls="examses">
                <span class="menu-title">Exams</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-note-plus menu-icon"></i>
            </a>
            <div class="collapse" id="examses">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="exam.php">Offical Exams</a></li>
                    <li class="nav-item"> <a class="nav-link" href="demoexam.php">Demo Exams</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#resultst" aria-expanded="false"
                aria-controls="resultst">
                <span class="menu-title">Results</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-shield menu-icon"></i>
            </a>
            <div class="collapse" id="resultst">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="viewResult.php">Result</a></li>
                    <li class="nav-item"> <a class="nav-link" href="viewPracresult.php">Result of Practice Test</a></li>
                    <li class="nav-item"> <a class="nav-link" href="leaderboard.php">LeaderBoard</a></li>
                </ul>
            </div>
        </li>

    </ul>
</nav>
<!-- partial -->