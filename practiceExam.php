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

?>

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
                    <h3 class="page-title">Practice Exam</h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                                <span></span>Overview <i
                                    class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                            </li>
                        </ul>
                    </nav>
                </div>
                <?php
                $coursesJson = $_SESSION['course'];

                // Convert the JSON string to an array
                $courses = json_decode($coursesJson, true);

                // Define an empty array to store course details
                $courseDetails = array();

                // Check if $courses is an array
                if (is_array($courses)) {
                    // Iterate over each course ID
                    foreach ($courses as $courseId) {
                        // Execute SQL query for the current course ID
                        $sql = "SELECT * FROM course WHERE id = '$courseId'";
                        $result = $mysql_connection->query($sql);

                        // Check if query was successful
                        if ($result) {
                            // Fetch the row from the result set
                            while ($row = $result->fetch_assoc()) {
                                $cname = $row['Name'];
                                echo '<div class="row">
                            <h1>' . $cname . '</h1>';
                                $sql1 = "SELECT * FROM demoexam WHERE course = '$cname'";
                                $result2 = $mysql_connection->query($sql1);
                                if ($result2 && $result2->num_rows > 0) {
                                    while ($rows = $result2->fetch_assoc()) {
                                        echo '<div class="row">';
                                        for ($em = 1; $em <= $rows['numofexam']; $em++) {
                                            echo "<div class='col-md-4'>
                                            <div class='card'>
                                            <div class='card-body'>
                                            <h1 class='card-title'>" . $rows['examName'] . " " . $em . "</h1>
                                            <h6 class='card-subtitle mb-2 text-body-secondary'>Exam Time Limit:" . $rows['timeLimit'] . "</h6>";
                                            $si = $_SESSION['id'];
                                            $ei = $rows['id'];
                                            $getSub = "SELECT * FROM msub WHERE student_id = '$si' AND exam_id = '$ei'";
                                            $reu = $mysql_connection->query($getSub);
                                            if ($reu->num_rows > 0) {
                                                echo "<a onclick=\"alert('You have already given the exam')\" class='btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn'>Attempted</a>";
                                            } else {
                                                $examUrl = "giveExam2.php?id=" . $si . "&examId=" . $ei . "&no=" . $em;
                                                echo "<a class='btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn' style='cursor:pointer;text-decoration:none;' onclick=\"openRestrictedWindow('$examUrl')\">Give Exam</a>";
                                            }

                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                        echo "</div>";
                                    }
                                } else {
                                    echo "Nothing found";
                                }
                                echo '</div>';
                            }
                        } else {
                            // Handle query error
                            echo "Error executing query: " . $mysql_connection->error;
                        }
                    }
                } else {
                    // Handle invalid input in $_SESSION['course']
                    echo "Invalid input for course data.";
                }
                ?>
                <button id="scrollTopBtn" class="btn btn-primary scroll-top-btn" title="Go to top"><i
                        class="mdi mdi-arrow-up"></i></button>

                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>
                    function openRestrictedWindow(url) {
                        // Define features for the new window
                        var features = "width=1200,height=780,resizable=no,scrollbars=yes";

                        // Open the URL in a new window with the specified features
                        var popup = window.open(url, "_blank", features);

                        // Attach event listener to detect when the popup window is closed
                        popup.onbeforeunload = function () {
                            // Reload the page when the popup window is closed
                            location.reload();
                        };
                    }

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
                <?php include_once('components/footer.php'); ?>