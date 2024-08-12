<?php
require_once 'components/includes/connection.php';
require_once 'components/includes/function.php';
require_once 'components/header.php';

$msg = '';

if (!empty($_GET['msg']) && $_GET['msg'] === "login") {
    $msg = "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              <strong>Login successfully!</strong>
            </div>";
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

<body>
    <div class="container-scroller">
        <?php require_once 'components/navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php require_once 'components/sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <?php
                    if ($msg) {
                        echo "
                            <section>                   
                                <div class='container-fluid'>
                                    <div class='row'>
                                        $msg
                                    </div>
                                </div>
                            </section>
                        ";
                    }
                    ?>
                    <section>
                        <div class='container-fluid'>
                            <div class='row' id="message">
                                <!-- Content for #message, if any -->
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
                                    <a href="addStudent.php"
                                        class="page-title-icon bg-gradient-primary text-white me-2 mark">Add Students
                                        <i class="mdi mdi-account-plus"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <table class="table table-bordered" id="courseTable">
                                        <thead>
                                            <tr>
                                                <th> Sr </th>
                                                <th> Student Name </th>
                                                <th> Email </th>
                                                <th> Phone </th>
                                                <th> Action </th>
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
                    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
                    <script>
                        $(document).ready(function () {
                            var out = $('#message');

                            // Function to populate the table with user details
                            function populateTable(data) {
                                var tableBody = $("#courseTable tbody");
                                tableBody.empty(); // Clear existing rows
                                var i = 1;
                                var sessionRole = <?= json_encode($_SESSION['staff']) ?>;
                                if (data.length === 0) {
                                    // If no data is present, display a message
                                    tableBody.append("<tr><td colspan='10' class='text-center'>No data available</td></tr>");
                                } else {
                                    // Iterate through the data and append rows to the table
                                    if (sessionRole == 0) {
                                        $.each(data, function (index, item) {
                                            var row = "<tr>" +
                                                "<td>" + item['id'] + "</td>" +
                                                "<td>" + item['name'] + "</td>" +
                                                "<td>" + item['email'] + "</td>" +
                                                "<td>" + item['phone'] + "</td>" +
                                                "<td><a href='updateStudent.php?id=" + item['id'] + "' class='btn-gradient-light' style ='padding: 5px; text-decoration: none;'>Update</a> <a href='updateImg.php?id=" + item['id'] + "' class='btn-gradient-success' style ='padding: 5px; text-decoration: none;'>Update Images</a> <button class='btn btn-danger btn-sm deleteBtn' data-id='" + item['id'] + "'>Delete</button></td>"
                                            "</tr>";
                                            i++;
                                            tableBody.append(row);
                                        });
                                    } else {
                                        $.each(data, function (index, item) {
                                            var row = "<tr>" +
                                                "<td>" + item['id'] + "</td>" +
                                                "<td>" + item['name'] + "</td>" +
                                                "<td>" + item['email'] + "</td>" +
                                                "<td>" + item['phone'] + "</td>" +
                                                "<td><a href='updateStudent.php?id=" + item['id'] + "' class='btn-gradient-light' style ='padding: 5px; text-decoration: none;'>Update</a> <a href='updateImg.php?id=" + item['id'] + "' class='btn-gradient-success' style ='padding: 5px; text-decoration: none;'>Update Images</a> </td>"
                                            "</tr>";
                                            i++;
                                            tableBody.append(row);
                                        });
                                    }

                                    $(".deleteBtn").on("click", function () {
                                        var studentId = $(this).data("id");
                                        // Make an AJAX request to delete the course
                                        deleteCourse(studentId);
                                    });
                                }
                            }

                            // Make an AJAX request to fetch user data
                            $.ajax({
                                type: "GET",
                                url: "BackendAPI/getStudents.php", // Replace with the actual path to your PHP file
                                dataType: "json",
                                success: function (data) {
                                    // Populate the table with user details
                                    populateTable(data);
                                    $('#courseTable').DataTable(); // Initialize DataTable
                                },
                                error: function (error) {
                                    console.log("Error fetching data:", error);
                                }
                            });

                            function deleteCourse(studentId) {
                                $.ajax({
                                    type: "POST",
                                    url: "BackendAPI/deleteStudent.php", // Replace with the actual path to your deleteCourse.php file
                                    data: { id: studentId },
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
                                                // out.html('');
                                                location.reload();
                                            }, 2000);

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
                    <?php require_once 'components/footer.php'; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>