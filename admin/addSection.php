<?php
include_once('components/includes/connection.php');
include_once('components/includes/function.php');
include_once('components/header.php');
$msg = '';
if (isset($_GET['msg']) && $_GET['msg'] == "login") {
    $msg = "<div class='alert alert-success alert-dismissible'>
          <strong>Login successfully!</strong>
        </div>";
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        header("location: exam.php");
    }
} else {
    $msg = "";
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
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
                <div class="overlay"></div> <!-- Dark overlay -->
                <div class="pupup">
                    <div class="modal-content">
                        <div class="col stretch-card">
                            <div class="card">
                                <div class="card-body ">
                                    <h4 class="card-title">Add Section</h4>
                                    <form class="forms-sample" method="post" action="BackendAPI/addSection.php">
                                        <div class="form-group">
                                            <input type="text" value="<?= $id ?>" name="id" style="display: none;">
                                            <input type="text" class="form-control" id="inputSecton" name="section"
                                                placeholder="">
                                        </div>

                                        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                                        <button type="button" class="btn btn-light cancel-btn">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-header">
                    <h3 class="page-title">
                        <a href="exam.php" class="txt-primary" style="font-size: 30px !important;"><i
                                class="mdi mdi-arrow-left"></i></a>
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#" class="page-title-icon bg-gradient-primary text-white me-2 mark"
                                    id="addSectionBtn">Add
                                    Section
                                    <i class="mdi mdi-plus"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="row">

                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body table-responsive">
                                <h4 class="card-title">Sections</h4>
                                <!-- <p class="card-description"> Add class <code>.table</code> -->
                                </p>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">sr</th>
                                            <th class="text-center">Section Name</th>
                                            <th class="text-center">Action</th>
                                            <!-- <th>Status</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sqle = "SELECT * FROM sections WHERE id = '$id'";
                                        $result = $mysql_connection->query($sqle);
                                        $i = 1;
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>"; // Start a new row
                                                echo "<td class='text-center'>" . $i . "</td>"; // Use <td> instead of <th> for table data
                                                echo "<td class='text-center'>" . $row['name'] . "</td>";
                                                echo "<td class='text-center'><a href='viewQuestion.php?id=$id&sec=" . $row['sr'] . "' class='page-title-icon bg-gradient-primary text-white me-2 mark' id='addSectionBtn'>Add Questions</a><a href='BackendAPI/deleteSection.php?id=$id&sec=" . $row['sr'] . "' class='page-title-icon bg-danger text-white me-2 mark' id='addSectionBtn'>Delete</a></td>";
                                                echo "</tr>"; // End the row
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

                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const addSectionBtn = document.getElementById("addSectionBtn");
                            const editSectionBtns = document.querySelectorAll(".editSectionBtn");
                            const pupup = document.querySelector(".pupup");
                            const overlay = document.querySelector(".overlay");
                            const cancelBtn = document.querySelector(".cancel-btn");
                            const submitBtn = document.querySelector(".submit-btn");

                            addSectionBtn.addEventListener("click", function (event) {
                                event.preventDefault(); // Prevent the default anchor tag behavior
                                pupup.classList.add("active"); // Display the popup with animation
                                overlay.classList.add("active"); // Display the overlay with animation
                                // Reset form fields if needed
                                // Example: document.getElementById("inputSecton").value = "";
                            });

                            editSectionBtns.forEach(function (btn) {
                                btn.addEventListener("click", function (event) {
                                    event.preventDefault();
                                    const sectionId = this.getAttribute("data-id");
                                    const sectionName = document.querySelector(`tr[data-id='${sectionId}'] .section-name`).innerText;

                                    // Assuming input fields are named similarly for both add and edit section
                                    document.getElementById("inputSecton").value = sectionName;

                                    // Assuming your form action is different for add and edit section, modify it accordingly
                                    document.querySelector(".forms-sample").action = "BackendAPI/editSection.php";

                                    pupup.classList.add("active");
                                    overlay.classList.add("active");
                                });
                            });

                            cancelBtn.addEventListener("click", function () {
                                pupup.classList.remove("active"); // Hide the popup with animation
                                overlay.classList.remove("active"); // Hide the overlay with animation
                            });

                            // You can also handle form submission if needed
                            submitBtn.addEventListener("click", function () {
                                // Your form submission logic here
                            });
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
                    <?php include_once('components/footer.php');
