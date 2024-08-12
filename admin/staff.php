<?php include_once ('components/includes/connection.php');
include_once ('components/includes/function.php');
include_once ('components/header.php');
$msg = '';
if (isset($_GET['msg']) && $_GET['msg'] == "login") {
    $msg = "<div class='alert alert-success alert-dismissible'>
          <strong>Login successfully!</strong>
        </div>";
} else {
    $msg = "";
}

if ($_SESSION['staff'] != 0) {
    header('location:index.php');
    exit;
}

?>
<style>
    .table-responsive {
        overflow-x: auto !important;
    }

    .remove-icon {
        margin-left: 5px;
        cursor: pointer;
    }

    .scroll-top-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none;
        /* Initially hide the button */
        z-index: 9999;
        /* Set a high z-index to ensure it appears above other elements */
    }
</style>

<div class="container-scroller">
    <?php include_once ('components/navbar.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once ('components/sidebar.php'); ?>
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
                                <a href="add_staff.php"
                                    class="page-title-icon bg-gradient-primary text-white me-2 mark">Add Staff
                                    <i class="mdi mdi-library-plus"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body table-responsive">
                                <!-- <h4 class="card-title">Bordered table</h4> -->
                                <table class="table table-bordered" id="courseTable">
                                    <thead>
                                        <tr>
                                            <th> Sr </th>
                                            <th> Staff Name </th>
                                            <th> Email </th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Table body will be populated dynamically using AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <button id="scrollTopBtn" class="btn btn-primary scroll-top-btn" title="Go to top"><i
                        class="mdi mdi-arrow-up"></i></button>
                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>
                    $(document).ready(function () {
                        // Function to populate the table with data
                        var out = $('#message');
                        function populateTable(data) {
                            var tableBody = $("#courseTable tbody");
                            tableBody.empty(); // Clear existing rows
                            var i = 1;
                            // Iterate through the data and append rows to the table
                            $.each(data, function (index, item) {
                                var row = "<tr>" +
                                    "<td>" + i + "</td>" +
                                    "<td>" + item['name'] + "</td>" +
                                    "<td>" + item['email'] + "</td>" +
                                    "<td><button class='btn btn-danger btn-sm deleteBtn' data-id='" + item['id'] + "'>Delete</button></td>" +
                                    "</tr>";
                                i++;
                                tableBody.append(row);
                            });

                            // Attach event handler for delete buttons
                            $(".deleteBtn").on("click", function () {
                                var courseId = $(this).data("id");
                                // Make an AJAX request to delete the course
                                deleteCourse(courseId);
                            });
                        }

                        // Make an AJAX request to fetch course data
                        $.ajax({
                            type: "GET",
                            url: "BackendAPI/getStaff.php", // Replace with the actual path to your PHP file
                            dataType: "json",
                            success: function (data) {
                                // Populate the table with data
                                populateTable(data);
                            },
                            error: function (error) {
                                console.log("Error fetching data:", error);
                            }
                        });

                        // Function to delete a course
                        function deleteCourse(courseId) {
                            $.ajax({
                                type: "POST",
                                url: "BackendAPI/deleteCourse.php", // Replace with the actual path to your deleteCourse.php file
                                data: { id: courseId },
                                success: function (response) {
                                    try {
                                        var jsonResponse = JSON.parse(response);
                                        if (jsonResponse.status === "success") {
                                            // Display success message
                                            out.html("<div class='alert alert-success alert-dismissible'>" +
                                                "<strong>" + jsonResponse.msg + "</strong></div>");
                                        } else {
                                            // Display error message
                                            out.html("<div class='alert alert-danger alert-dismissible'>" +
                                                "<strong>Failed!</strong></div>");
                                        }

                                        // Reset form and clear output after a delay
                                        setTimeout(function () {
                                            // form.trigger('reset');
                                            out.html('');
                                        }, 2000);
                                        location.reload();

                                    } catch (e) {
                                        console.log("Error parsing JSON response:", e);
                                    }
                                },
                                error: function (error) {
                                    console.log("Error deleting course:", error);
                                }
                            });
                        }
                    });

                    $(window).scroll(function () {
                        // If user has scrolled more than 20px from the top
                        if ($(this).scrollTop() > 20) {
                            // Show the scroll-to-top button
                            $('#scrollTopBtn').fadeIn();
                        } else {
                            // Otherwise, hide the button
                            $('#scrollTopBtn').fadeOut();
                        }
                    });

                    // Function to handle button click
                    $('#scrollTopBtn').click(function () {
                        // Scroll to the top of the page with animation
                        $('html, body').animate({ scrollTop: 0 }, 800);
                    });
                </script>


                <!-- content-wrapper ends -->
                <?php include_once ('components/footer.php'); ?>