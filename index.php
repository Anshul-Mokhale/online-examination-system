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
if ($_SESSION['status'] != 2) {
  header("location: logout.php");
}
// $active_user = getResultAsArray("SELECT COUNT(`id`) as `cnt` FROM `admin` WHERE `status` = 1");
?>

<div class="container-scroller">
  <?php include_once('components/navbar.php'); ?>
  <div class="container-fluid page-body-wrapper">
    <?php include_once('components/sidebar.php'); ?>
    <style>
      .carousel img {
        padding: 10px !important;
        border-radius: 10px !important;
      }

      .cg img {
        width: 100px;
      }



      .list-group-item {
        color: white;
      }

      .id-card {
        background-color: #fff;
        border-radius: 15px;
        /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
        padding: 30px;
        position: relative;
        background-color: transparent;

        /* Make the card a relative positioning context */
      }

      .id-header h1 {
        font-size: 28px;
        color: #333;
      }

      .id-header img {
        width: 150px;
        height: 150px;
        border: 6px solid #fff;
      }

      .id-details .list-group-item {
        background-color: transparent;
        border: none;
      }

      .signature {
        position: absolute;
        bottom: 10px;
        right: 10px;
      }

      .signature-img {
        max-width: 100px;
        height: auto;
      }

      .id-details .list-group-item strong {
        color: white;
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
          <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
              <i class="mdi mdi-home"></i>
            </span> Dashboard
          </h3>
          <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
              </li>
            </ul>
          </nav>
        </div>
        <?php
        $id = $_SESSION['id'];
        $sq = "SELECT * FROM students WHERE id = '$id'";
        $resu = $mysql_connection->query($sq);
        if ($resu->num_rows > 0) {
          $row = $resu->fetch_assoc();
        }

        $_SESSION['course'] = $row['courses'];
        function replaceDots($inputText)
        {
          // Replace ".." with "admin"
          $outputText = str_replace("..", "admin", $inputText);
          return $outputText;
        }
        // Example usage:
        $inputText = $row['Simage']; // Assuming you're getting input from a form
        $outputText = replaceDots($inputText);
        $input2Text = $row['Ssign'];
        $out2 = replaceDots($input2Text);
        ?>
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card bg-gradient-primary card-img-holder text-white">
              <div class="card-body index-card">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <div class="id-card">
                  <div class="id-header">
                    <h1 class="text-center mb-4">User ID Card</h1>
                    <div class="text-center">
                      <img src="<?= $outputText ?>" alt="User Image" class="img-fluid rounded-circle">
                    </div>
                  </div>
                  <div class="id-details mt-4">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"><strong>Name:</strong>
                        <?= $row['name'] ?>
                      </li>
                      <li class="list-group-item"><strong>Email:</strong>
                        <?= $row['email'] ?>
                      </li>
                      <li class="list-group-item"><strong>Phone:</strong>
                        <?= $row['phone'] ?>
                      </li>
                      <li class="list-group-item"><strong>Gender:</strong>
                        <?= $row['gender'] ?>
                      </li>
                      <li class="list-group-item"><strong>Date of Birth:</strong>
                        <?= $row['birth_date'] ?>
                      </li>
                      <li class="list-group-item"><strong>Address:</strong>
                        <?= $row['address'] ?>

                      </li>
                    </ul>
                  </div>
                  <div class="signature">
                    <img src="<?= $out2 ?>" alt="Signature" class="signature-img">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">

        </div>
        <!-- content-wrapper ends -->
        <?php include_once('components/footer.php'); ?>