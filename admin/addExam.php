<?php
include_once('components/includes/connection.php');
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
                        <a href="exam.php" class="txt-primary" style="font-size: 30px !important;"><i
                                class="mdi mdi-arrow-left"></i></a>
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <!-- <li class="breadcrumb-item active" aria-current="page">
                                <a href="#" class="page-title-icon bg-gradient-primary text-white me-2 mark">Add Course
                                    <i class="mdi mdi-library-plus"></i></a>
                            </li> -->
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Add Exam</h4>
                                <!-- <p class="card-description"> Basic form elements </p> -->
                                <form class="forms-sample" id="AddExam">
                                    <div class="form-group">
                                        <label for="exampleSelectCouse">Select Course</label>
                                        <select class="form-control" id="exampleSelectCourse" name="course">
                                            <option selected disabled>Select One</option>
                                            <?php
                                            $sql = "SELECT * FROM course";
                                            $result = $mysql_connection->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $courseName = htmlspecialchars($row['Name']);
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
                                        <input type="text" class="form-control" id="exampleInputName1"
                                            placeholder="Enter Name Here" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleSelectMode">Select Mode</label>
                                        <select class="form-control" id="exampleSelectMode" required>
                                            <option selected disabled>Select One</option>
                                            <option>Live</option>
                                            <option>Scheduled</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="dateTimeGroup" style="display: none;">
                                        <label for="exampleInputDateTime">Select Start Date Time</label>
                                        <input type="datetime-local" class="form-control" id="exampleInputDateTime"
                                            name="dateTime">
                                    </div>

                                    <div class="form-group" id="dateTimeGroup2" style="display: none;">
                                        <label for="exampleInputDateTime2">Select End Date Time</label>
                                        <input type="datetime-local" class="form-control" id="exampleInputDateTime2"
                                            name="dateTime2">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputTime">Time Limit(in minutes)</label>
                                        <input type="number" class="form-control" id="exampleInputTime"
                                            placeholder="Timelimit" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputQuestion">Number of Question</label>
                                        <input type="number" class="form-control" id="exampleInputQuestion"
                                            placeholder="Number of question" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pMark">Positive Marking</label>
                                        <input type="text" class="form-control" id="pMark"
                                            placeholder="Marks on Correct Answer" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nMark">Negative Marking</label>
                                        <input type="text" class="form-control" id="nMark"
                                            placeholder="Marks on wrong answer" required>
                                    </div>


                                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>
                    var out = $('#message');
                    var form = $('#AddExam');
                    $(document).ready(function () {
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

                        $("#AddExam").submit(function (event) {
                            event.preventDefault();

                            var formData = {
                                course: $("#exampleSelectCourse").val(),
                                examName: $("#exampleInputName1").val(),
                                mode: $("#exampleSelectMode").val(),
                                dateTime: $("#exampleInputDateTime").val(),
                                dateTime2: $("#exampleInputDateTime2").val(),
                                timeLimit: $("#exampleInputTime").val(),
                                numberOfQuestions: $("#exampleInputQuestion").val(),
                                pMark: $("#pMark").val(),
                                nMark: $("#nMark").val(),
                            };

                            console.log("Form Data:", formData);


                            for (var key in formData) {
                                if (key !== "dateTime" && key !== "dateTime2" && (formData[key] === null || formData[key] === "")) {
                                    alert("Please fill out all fields!");
                                    return;
                                }
                            }

                            if (formData.mode === "Scheduled" && formData.dateTime === "") {
                                alert("Please select the date and time for the scheduled exam!");
                                return;
                            }

                            console.log("Form Data:", formData);

                            $.ajax({
                                type: 'POST',
                                url: 'BackendAPI/addExam.php',
                                contentType: 'application/json',
                                data: JSON.stringify(formData),
                                success: function (response) {
                                    if (response.status === "success") {
                                        out.html("<div class='alert alert-success alert-dismissible'>" +
                                            "<strong>" + response.message + "</strong></div>");

                                    } else {
                                        out.html("<div class='alert alert-danger alert-dismissible'>" +
                                            "<strong>" + response.message + "</strong></div>");
                                    }
                                    setTimeout(function () {
                                        form.trigger('reset');
                                        out.html(''); // Clear the output after resetting
                                    }, 2000);
                                },

                                error: function (error) {
                                    console.error('Error:', error);
                                }
                            });
                        });
                    });
                </script>

                <!-- content-wrapper ends -->
                <?php include_once('components/footer.php');