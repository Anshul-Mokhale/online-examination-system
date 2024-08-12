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
                        <a href="exam.php" class="txt-primary" style="font-size: 30px !important;"><i
                                class="mdi mdi-arrow-left"></i></a>
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb"></ul>
                    </nav>
                </div>
                <?php
                $sq = "SELECT * FROM `exams` WHERE id = '$id'";
                $resu = $mysql_connection->query($sq);
                if ($resu->num_rows > 0) {
                    $row = $resu->fetch_assoc();
                }
                ?>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Update Exam</h4>
                                <form class="forms-sample" id="EditExam">
                                    <div class="form-group">
                                        <label for="exampleSelectCourse">Select Course</label>
                                        <input type="text" id="id" value="<?= $id ?>" style="display:none;">
                                        <select class="form-control" id="exampleSelectCourse" name="course" required>
                                            <option value="<?= htmlspecialchars($row['course_name']) ?>" selected
                                                style="display:none;">
                                                <?= htmlspecialchars($row['course_name']) ?>
                                            </option>
                                            <?php
                                            $sql = "SELECT * FROM course";
                                            $resulte = $mysql_connection->query($sql);

                                            if ($resulte->num_rows > 0) {
                                                while ($rowe = $resulte->fetch_assoc()) {
                                                    $courseName = htmlspecialchars($rowe['Name']);
                                                    echo "<option value='$courseName'>$courseName</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No courses available</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputName1">Name of Exam</label>
                                        <input type="text" value="<?= htmlspecialchars($row['exam_name']) ?>"
                                            class="form-control" id="exampleInputName1" name="exam_name"
                                            placeholder="Enter Name Here" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInstruction">Instructions of Exam</label>
                                        <textarea class="form-control" id="exampleInstruction" name="instructions"
                                            rows="4"><?= htmlspecialchars($row['instructions']) ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleSelectMode">Select Mode</label>
                                        <select class="form-control" id="exampleSelectMode" name="mode" required>
                                            <option value="<?= htmlspecialchars($row['mode']) ?>" selected
                                                style="display:none;">
                                                <?= htmlspecialchars($row['mode']) ?>
                                            </option>
                                            <option value="Live">Live</option>
                                            <option value="Scheduled">Scheduled</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="dateTimeGroup" style="display: none;">
                                        <label for="exampleInputDateTime">Select Date Time</label>
                                        <input type="datetime-local" value="<?= htmlspecialchars($row['date_time']) ?>"
                                            class="form-control" id="exampleInputDateTime" name="date_time">
                                    </div>
                                    <div class="form-group" id="dateTimeGroup2" style="display: none;">
                                        <label for="exampleInputDateTime2">Select End Date Time</label>
                                        <input type="datetime-local" value="<?= htmlspecialchars($row['date_time2']) ?>"
                                            class="form-control" id="exampleInputDateTime2" name="dateTime2">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputTime">Time Limit (in minutes)</label>
                                        <input type="number" value="<?= htmlspecialchars($row['time_limit']) ?>"
                                            class="form-control" id="exampleInputTime" name="time_limit"
                                            placeholder="Time limit" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputQuestion">Number of Question</label>
                                        <input type="number"
                                            value="<?= htmlspecialchars($row['number_of_questions']) ?>"
                                            class="form-control" id="exampleInputQuestion" name="number_of_questions"
                                            placeholder="Number of questions" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pMark">Positive Marking</label>
                                        <input type="text" value="<?= htmlspecialchars($row['posititve']) ?>"
                                            class="form-control" id="pMark" placeholder="Marks on Correct Answer">
                                    </div>
                                    <div class="form-group">
                                        <label for="nMark">Negative Marking</label>
                                        <input type="text" value="<?= htmlspecialchars($row['negaitve']) ?>"
                                            class="form-control" id="nMark" placeholder="Marks on wrong answer">
                                    </div>
                                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                                    <!-- <button type="button" class="btn btn-light">Cancel</button> -->
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Include jQuery library -->
                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

                <script>
                    var out = $('#message');

                    $(document).ready(function () {
                        var form = $('#EditExam');
                        $("#exampleSelectMode").change(function () {
                            var selectedMode = $(this).val();

                            if (selectedMode === "Scheduled") {
                                $("#dateTimeGroup").show();
                                $("#dateTimeGroup2").show();
                            } else {
                                $("#dateTimeGroup").hide();
                                $("#dateTimeGroup2").hide();
                            }
                        });
                        form.submit(function (event) {
                            // Prevent the default form submission
                            event.preventDefault();

                            // Collect form data
                            var formData = {
                                id: $('#id').val(),
                                course: $("#exampleSelectCourse").val(),
                                examName: $("#exampleInputName1").val(),
                                instructions: $("#exampleInstruction").val(),
                                mode: $("#exampleSelectMode").val(),
                                dateTime: $("#exampleInputDateTime").val(),
                                dateTime2: $("#exampleInputDateTime2").val(),
                                timeLimit: $("#exampleInputTime").val(),
                                numberOfQuestions: $("#exampleInputQuestion").val(),
                                pMark: $("#pMark").val(),
                                nMark: $("#nMark").val(),
                            };

                            // Send the data to updateExam.php using AJAX
                            $.ajax({
                                type: "POST",
                                url: "BackendAPI/updateExam.php",
                                data: formData,
                                dataType: "json", // Specify the expected data type
                                success: function (response) {
                                    console.log(response);
                                    if (response.status === "success") {
                                        out.html("<div class='alert alert-success alert-dismissible'>" +
                                            "<strong>" + response.message + "</strong></div>");
                                    } else {
                                        out.html("<div class='alert alert-danger alert-dismissible'>" +
                                            "<strong>" + response.message + "</strong></div>");
                                    }

                                    // Scroll to the top of the page
                                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                                },
                                error: function (xhr, status, error) {
                                    console.log("AJAX Request Error:", error);
                                    alert("AJAX Request Error: " + error);
                                }
                            });
                        });
                    });
                </script>


                <?php include_once('components/footer.php'); ?>