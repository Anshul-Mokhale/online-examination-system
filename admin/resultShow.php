<?php
include_once('components/includes/connection.php');
include_once('components/includes/function.php');
include_once('components/header.php');
$msg = '';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = "";
}

?>
<style>
    .selected-values {
        margin-top: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        display: flex;
        flex-wrap: wrap;
    }

    .selected-value {
        margin: 5px;
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        border-radius: 20px;
        display: flex;
        align-items: center;
    }

    .remove-icon {
        margin-left: 5px;
        cursor: pointer;
    }
</style>
<div class="container-scroller">
    <?php include_once('components/navbar.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('components/sidebar.php'); ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <?php
                if ($msg) {
                    echo "<section><div class='container-fluid'><div class='row'>" . $msg . "</div></div></section>";
                }
                ?>
                <section>
                    <div class='container-fluid'>
                        <div class='row' id="message"></div>
                    </div>
                </section>
                <div class="page-header">
                    <h3 class="page-title">
                        <a href="viewResult.php" class="txt-primary" style="font-size: 30px !important;"><i
                                class="mdi mdi-arrow-left"></i></a>
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb"></ul>
                    </nav>
                </div>
                <div class="row">
                    <?php
                    $sqq = "SELECT * FROM submissions WHERE student_id = '$id'";
                    $resu = $mysql_connection->query($sqq);
                    $resultArray = array();
                    if ($resu->num_rows > 0) {
                        while ($row = $resu->fetch_assoc()) {
                            $resultArray[] = $row;
                        }
                    }
                    $sqq2 = "SELECT name FROM students WHERE id = '$id'";
                    $resu2 = $mysql_connection->query($sqq2);
                    if ($resu2->num_rows > 0) {
                        $row2 = $resu2->fetch_assoc();
                    }
                    ?>
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <?= $row2['name'] ?>'s Result
                                </h4>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th> Sr no. </th>
                                            <th> Course Name </th>
                                            <th> Exam Name </th>
                                            <th> Score </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($resultArray as $val) {
                                            echo '<tr>
                                                    <td class="py-1">' . $i . '</td>';
                                            $exid = $val['exam_id'];
                                            $sqq3 = "SELECT * FROM exams WHERE id = '$exid'";
                                            $res11 = $mysql_connection->query($sqq3);
                                            if ($res11->num_rows > 0) {
                                                $vael = $res11->fetch_assoc();
                                            }
                                            echo '<td>' . $vael['course_name'] . '</td>
                                            <td>' . $vael['exam_name'] . '</td>
                                            <td>' . number_format($val['total'], 2) . '%</td>
                                         <td>
                                    <a href="examResult.php?id=' . $val['student_id'] . '&examId=' . $val['exam_id'] . '" class="btn-gradient-light" style="padding: 5px; text-decoration: none;">View Result</a>
                                </td>
                            </tr>';
                                            $i++;
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Include jQuery library -->
                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

                <script>

                </script>


                <?php include_once('components/footer.php'); ?>