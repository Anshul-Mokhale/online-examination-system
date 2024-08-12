<?php include_once('components/includes/connection.php');
include_once('components/includes/function.php');
include_once('components/header.php');
$msg = '';
if (isset($_GET['msg']) && $_GET['msg'] == "login") {
  $msg = "<div class='alert alert-success alert-dismissible'>
          <strong>Login successfully!</strong>
        </div>";
} else {
  $msg = "";
}
if ($_SESSION['status'] != 1) {
  header("location: logout.php");
}
$active_user = getResultAsArray("SELECT COUNT(`id`) as `cnt` FROM `students` WHERE `status` = 2");
$Course = getResultAsArray("SELECT COUNT(`id`) as `cnt` FROM `course`");
$exams = getResultAsArray("SELECT COUNT(`id`) as `cnt` FROM `exams`");
?>
<div class="container-scroller">
  <?php include_once('components/navbar.php'); ?>
  <div class="container-fluid page-body-wrapper">
    <?php include_once('components/sidebar.php'); ?>
    <div class="main-panel">
      <div class="content-wrapper">
        <?php
        if ($msg) {
          echo "     
            <section>                   
              <div class='container-fluid'>
                <div class='row'>
                  " . $msg . "
                </div>
              </div>
            </section>
            ";
        }
        ?>
        <section>
          <div class='container-fluid'>
            <div class='row' id="message">

            </div>
          </div>
        </section>
        <div class="page-header">
          <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
              <i class="mdi mdi-home"></i>
            </span> Dashboard
          </h3>
          <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
              </li>
            </ul>
          </nav>
        </div>
        <div class="row">
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-primary card-img-holder text-white">
              <div class="card-body index-card">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h5 class="font-weight-normal mb-1">Total Students <i
                    class="mdi mdi-account-multiple-outline mdi-24px float-right"></i>
                </h5>
                <h2 class="mb-1">
                  <?= $active_user[0]['cnt'] ?>

                </h2>
                <h6 class="card-text">Total Students</h6>
              </div>
            </div>
          </div>
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-primary card-img-holder text-white">
              <div class="card-body index-card">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h5 class="font-weight-normal mb-1">Total Courses <i
                    class="mdi mdi-account-multiple-outline mdi-24px float-right"></i>
                </h5>
                <h2 class="mb-1">
                  <?= $Course[0]['cnt'] ?>
                </h2>
                <h6 class="card-text">Total Course</h6>
              </div>
            </div>
          </div>
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-primary card-img-holder text-white">
              <div class="card-body index-card">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h5 class="font-weight-normal mb-1">Total Exams <i
                    class="mdi mdi-account-multiple-outline mdi-24px float-right"></i>
                </h5>
                <h2 class="mb-1">
                  <?= $exams[0]['cnt'] ?>
                </h2>
                <h6 class="card-text">Total Exams</h6>
              </div>
            </div>
          </div>

        </div>

      </div>
      <!-- content-wrapper ends -->
      <?php include_once('components/footer.php'); ?>