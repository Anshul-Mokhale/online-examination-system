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
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
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
                  <div class='alert alert-success alert-dismissible'>
                        <strong>" . $msg . "</strong></div>
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
                        <a href="students.php" class="txt-primary" style="font-size: 30px !important;"><i
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
                <?php
                $sq = "SELECT * FROM students WHERE id = '$id'";
                $resu = $mysql_connection->query($sq);
                if ($resu->num_rows > 0) {
                    $row = $resu->fetch_assoc();
                }
                ?>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Student Image Update</h4>
                                <form class="forms-sample" action="BackendAPI/updateProfile.php" method="POST"
                                    enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" name="id" value="<?= $id ?>" style="display:none;">
                                        <label>Image upload</label>
                                        <input type="file" name="img1" class="file-upload-default" name="img1">
                                        <div class="input-group col-xs-12">
                                            <input type="file" class="form-control file-upload-info"
                                                placeholder="Upload Image" name="img1">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Signature upload</label>
                                        <input type="file" name="img2" class="file-upload-default" name="img2">
                                        <div class="input-group col-xs-12">
                                            <input type="file" class="form-control file-upload-info"
                                                placeholder="Upload Image" name="img2">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            include_once('components/footer.php');
            ?>

        </div>
    </div>
</div>