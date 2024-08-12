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
                        <a href="course.php" class="txt-primary" style="font-size: 30px !important;"><i
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
                                <h4 class="card-title">Add Course</h4>
                                <!-- <p class="card-description"> Basic form elements </p> -->
                                <form class="forms-sample" id="courseForm" action="BackendAPI/addCourseApi.php"
                                    method="post">
                                    <div class="form-group">
                                        <label for="CourseName">Course Name</label>
                                        <input type="text" class="form-control" id="CourseName" name="courseName"
                                            placeholder="Enter Course Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description"
                                            rows="4"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                                    <!-- <button class="btn btn-light">Cancel</button> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>
                    $(document).ready(function () {
                        var form = $('#courseForm');
                        $('#courseForm').submit(function (e) {
                            e.preventDefault();

                            var out = $('#message');
                            var courseName = $('#CourseName').val().trim(); // Trim to remove leading and trailing spaces
                            var description = $('#description').val().trim(); // Trim to remove leading and trailing spaces

                            // Validate if courseName and description are not empty
                            if (courseName === "" || description === "") {
                                out.html("<div class='alert alert-danger alert-dismissible'>" +
                                    "<strong>Please fill in both Course Name and Description</strong></div>");
                                return;
                            }

                            var formData = {
                                'courseName': courseName,
                                'description': description
                            };

                            $.ajax({
                                type: 'POST',
                                url: 'BackendAPI/addCourseApi.php',
                                contentType: 'application/json',
                                data: JSON.stringify(formData),
                                success: function (response) {
                                    var jsonResponse = JSON.parse(response);

                                    if (jsonResponse.status === "success") {
                                        out.html("<div class='alert alert-success alert-dismissible'>" +
                                            "<strong>" + jsonResponse.message + "</strong></div>");

                                    } else {
                                        out.html("<div class='alert alert-danger alert-dismissible'>" +
                                            "<strong>" + jsonResponse.message + "</strong></div>");
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