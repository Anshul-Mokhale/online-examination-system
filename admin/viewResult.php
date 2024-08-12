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
                    <a href="index.php">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white me-2">
                                <i class="mdi mdi-home"></i>
                            </span>
                        </h3>
                    </a>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb"></ul>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-center">View Result</h4>
                                <p class="card-description text-center"> View Result Accoding to Student</p>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th> Sr no. </th>
                                            <th> Student Name </th>
                                            <th> email </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sqq = "SELECT * FROM students";
                                        $resu = $mysql_connection->query($sqq);
                                        if ($resu->num_rows > 0) {
                                            $i = 1;
                                            while ($row = $resu->fetch_assoc()) {
                                                echo ' <tr>
                                                <td class="py-1">
                                                  ' . $i . '
                                                </td>
                                                <td>
                                                  ' . $row['name'] . '
                                                </td>
                                                <td> 
                                                ' . $row['email'] . '
                                                </td>
                                                <td>
                                                <a href="resultShow.php?id=' . $row['id'] . '" class="btn-gradient-success" style ="padding: 5px; text-decoration: none;">View Result</a>
                                                </td>
                                              </tr>';
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <button id="scrollTopBtn" class="btn btn-primary scroll-top-btn" title="Go to top"><i
                                class="mdi mdi-arrow-up"></i></button>
                    </div>

                </div>

                <!-- Include jQuery library -->
                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

                <script>
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


                <?php include_once('components/footer.php'); ?>