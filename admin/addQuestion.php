<?php
include_once('components/includes/connection.php');
include_once('components/includes/function.php');
include_once('components/header.php');
$msg = '';
if (isset($_GET['msg']) && $_GET['msg'] == "login") {
    $msg = "<div class='alert alert-success alert-dismissible'>
          <strong>Login successfully!</strong>
        </div>";
    if (isset($_GET['id'], $_GET['sec'])) {
        $id = $_GET['id'];
        $sec = $_GET['sec'];
    } else {
        header("location: exam.php");
    }
} else {
    $msg = "";
    if (isset($_GET['id'], $_GET['sec'])) {
        $id = $_GET['id'];
        $sec = $_GET['sec'];
    } else {
        // $id = "";
        header("location: exam.php");
    }
}

?>
<style>
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .pupup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        z-index: 1000;
        width: 90%;
        /* Adjusted width to be responsive */
        max-width: 500px;
        /* Added max-width to prevent overly wide popup */
        opacity: 0;
        transition: opacity 0.3s ease, transform 0.3s ease;
        transform-origin: center;
    }

    .overlay.active,
    .pupup.active {
        display: block;
        opacity: 1;
    }

    .pupup.active {
        transform: translate(-50%, -50%) scale(1);
    }

    .table-responsive {
        overflow-x: auto !important;
    }

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
                        <a href="viewQuestion.php?id=<?= $id ?>" class="txt-primary"
                            style="font-size: 30px !important;"><i class="mdi mdi-arrow-left"></i></a>
                    </h3>

                    <nav aria-label="breadcrumb">
                        <!-- <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#" class="page-title-icon bg-gradient-primary text-white me-2 mark"
                                    id="addSectionBtn">Edit
                                    Section
                                    <i class="mdi mdi-pencil"></i></a>
                            </li>
                        </ul> -->
                    </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                $va = "";
                                $sqq = "SELECT exam_name FROM exams WHERE id = '$id'";
                                $resu = $mysql_connection->query($sqq);
                                if ($resu && $resu->num_rows > 0) {
                                    $rew = $resu->fetch_assoc();
                                    $va = $rew['exam_name'];
                                    echo "<h4 class='card-title'>Add question for " . $rew['exam_name'] . "</h4>";
                                } else {
                                    echo "<h4 class='card-title'>Exam not found</h4>";
                                }
                                ?>

                                <!-- <p class="card-description"> Basic form elements </p> -->
                                <form id="myForm" class="forms-sample">
                                    <input type="number" value="<?= $id ?>" id="examName" style="display:none;">
                                    <div class="form-group">
                                        <label for="Paragraph">Enter Paragraph</label>
                                        <textarea class="form-control" id="Paragraph" rows="4"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="Question">Enter Question</label>
                                        <input type="text" class="form-control" id="Question"
                                            placeholder="Enter Question">
                                    </div>
                                    <div class="form-group">
                                        <label for="CHA">Choice A</label>
                                        <input type="text" class="form-control" id="CHA" placeholder="Enter Option A">
                                    </div>
                                    <div class="form-group">
                                        <label for="CHB">Choice B</label>
                                        <input type="text" class="form-control" id="CHB" placeholder="Enter Option B">
                                    </div>
                                    <div class="form-group">
                                        <label for="CHC">Choice C</label>
                                        <input type="text" class="form-control" id="CHC" placeholder="Enter Option C">
                                    </div>
                                    <div class="form-group">
                                        <label for="CHD">Choice D</label>
                                        <input type="text" class="form-control" id="CHD" placeholder="Enter Option D">
                                    </div>
                                    <div class="form-group">
                                        <label for="CorrectAnswer">Correct Answer</label>
                                        <input type="text" class="form-control" id="CorrectAnswer"
                                            placeholder="Enter Correct Answer">
                                    </div>
                                    <button type="button" id="submitForm"
                                        class="btn btn-gradient-primary me-2">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>
                    var ot = $('#message');
                    $(document).ready(function () {
                        var form = $('#myForm');

                        $('#submitForm').click(function () {
                            var examName = $('#examName').val(); // Corrected selector
                            var paragraph = $('#Paragraph').val();
                            var question = $('#Question').val();
                            var choiceA = $('#CHA').val();
                            var choiceB = $('#CHB').val();
                            var choiceC = $('#CHC').val();
                            var choiceD = $('#CHD').val(); // Corrected variable name
                            var correctAnswer = $('#CorrectAnswer').val();

                            // Check if the correct answer matches one of the choices
                            if (correctAnswer === choiceA || correctAnswer === choiceB || correctAnswer === choiceC || correctAnswer === choiceD) {
                                // Construct data object
                                var formData = {
                                    examName: examName,
                                    paragraph: paragraph,
                                    question: question,
                                    choiceA: choiceA,
                                    choiceB: choiceB,
                                    choiceC: choiceC,
                                    choiceD: choiceD,
                                    correctAnswer: correctAnswer
                                };
                                console.log(formData);

                                // Send data to backend PHP script using AJAX
                                $.ajax({
                                    type: 'POST',
                                    url: 'BackendAPI/addQuestion.php',
                                    contentType: 'application/json',
                                    data: JSON.stringify(formData),
                                    success: function (response) {
                                        // Handle success response
                                        // console.log(response);
                                        if (response.success == true) {
                                            ot.html("<div class='alert alert-success alert-dismissible'>" +
                                                "<strong>" + response.message + "</strong></div>");
                                        }
                                        else {
                                            ot.html("<div class='alert alert-danger alert-dismissible'>" +
                                                "<strong>" + response.message + "</strong></div>");
                                        }
                                        setTimeout(function () {
                                            form.trigger('reset');
                                            ot.html(''); // Clear the output after resetting
                                        }, 2000);
                                    },
                                    error: function (xhr, status, error) {
                                        // Handle error response
                                        console.error('Request failed. Error code: ' + xhr.status);
                                    }
                                });
                            } else {
                                // Show error message
                                alert("Please enter a correct answer that matches one of the choices (A, B, C, D).");

                            }
                        });
                    });



                </script>

                <!-- content-wrapper ends -->
                <?php include_once('components/footer.php');


