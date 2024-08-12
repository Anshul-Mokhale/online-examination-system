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
// $active_user = getResultAsArray("SELECT COUNT(`id`) as `cnt` FROM `admin` WHERE `status` = 1");
// $sid = $_GET['id'];
$examId = $_GET['examId'];
?>
<style>
    .container-scroller {

        font-family: 'Nunito Sans', sans-serif !important;
    }
</style>
<div class="container-scroller">
    <?php include_once('components/navbar.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('components/sidebar.php'); ?>
        <style>
            .card-body {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .row {
                margin-top: 2em !important;
            }
        </style>
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
                    <a href="index.php">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white me-2">
                                <i class="mdi mdi-home"></i>
                            </span>
                        </h3>
                    </a>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                                <span></span>Overview <i
                                    class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Leader Board Ranking</h4>
                                <!-- <p class="card-description"> Add class <code>.table-striped</code> -->
                                </p>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th> Rank </th>
                                            <th> Student name </th>
                                            <th> Exam name </th>
                                            <th> Percentage </th>
                                            <!-- <th> Deadline </th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $getResu = "SELECT * FROM `submissions` WHERE exam_id = '$examId' ORDER BY `submissions`.`total` DESC";
                                        $getResuAns = $mysql_connection->query($getResu);
                                        if ($getResuAns->num_rows > 0) {
                                            $Rank = 1;
                                            while ($row = $getResuAns->fetch_assoc()) {
                                                $studid = $row['student_id'];
                                                $getStud = "SELECT name FROM students WHERE id = '$studid'";
                                                $getStudAns = $mysql_connection->query($getStud);
                                                $reow = $getStudAns->fetch_assoc();

                                                $getStud2 = "SELECT exam_name FROM exams WHERE id = '$examId'";
                                                $getStudAns2 = $mysql_connection->query($getStud2);
                                                $reow2 = $getStudAns2->fetch_assoc();

                                                echo '<tr>
                                                <td class="py-1">
                                                ' . $Rank . '
                                                </td>
                                                <td>' . $reow['name'] . '</td>
                                                <td>' . $reow2['exam_name'] . '</td>
                                                <td>' . number_format($row['total'], 2) . '%</td>
                                            </tr>';
                                                $Rank++;
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://kit.fontawesome.com/ca0110489d.js" crossorigin="anonymous"></script>
            <!-- content-wrapper ends -->
            <?php include_once('components/footer.php'); ?>