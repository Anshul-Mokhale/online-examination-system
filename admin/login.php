<?php
include_once ('components/includes/connection.php');
include_once ('components/includes/function.php');
include_once ('components/header.php');
if (isset($_SESSION['email'])) {
  header('location:index.php');
  exit;
}
$msg = "";
if (isset($_GET['msg']) && $_GET['msg'] == "successreset") {
  $msg = "<div class='alert alert-success alert-dismissible'>
          <strong>Password reset successfully!</strong>
        </div>";
} else if (isset($_GET['msg']) && $_GET['msg'] == "errorreset") {
  $msg = "<div class='alert alert-danger alert-dismissible' role='alert' >
            <strong>Something went wrong!!</strong>
        </div>";
} else {
  $msg = "";
}
$error = "";
if (!empty($_POST['login'])) {
  $pwd = $_POST['password'];
  if ($pwd == "") {
    $error .= "Please enter new Password!<br>";
  } else {
    $pwd = md5($_POST['password']);
  }
  if (isset($_POST['email'])) {
    $email = $_POST['email'];
    if ($email == "") {
      $error .= "Please enter Email id!<br>";
    }
  }
}
if ($error != "") {
  $msg = "<div class='alert alert-danger alert-dismissible' role='alert' >
            <strong>" . $error . "</strong>
          </div>";
} else if (!empty($_POST['login']) && $error == "") {
  if (isset($_POST['email'])) {
    $admin = executeSelectSingle('admin', array(), array('email' => $_POST['email'], 'status' => 1));
  }
  if (count($admin) > 0) {
    $id_login = $admin['id'];
    $email_login = $admin['email'];
    $password_login = $admin['password'];
    $name_login = $admin['name'];
    $staff = $admin['staff'];

    if ($staff == 0) {
      if ($password_login != $pwd) {
        $msg = " <div class='alert alert-danger alert-dismissible' role='alert' >
                  <strong>Password is Incorrect!!</strong>
              </div>";
      } else {
        $session_token = md5(time() . $email_login);
        $_SESSION['id'] = $id_login;
        $_SESSION['name'] = $name_login;
        $_SESSION['email'] = $email_login;
        $_SESSION['password'] = $password_login;
        $_SESSION['status'] = 1;
        $_SESSION['staff'] = 0;
        header('location:index.php?msg=login');
      }
    } else {
      if ($password_login != $pwd) {
        $msg = " <div class='alert alert-danger alert-dismissible' role='alert' >
                  <strong>Password is Incorrect!!</strong>
              </div>";
      } else {
        $session_token = md5(time() . $email_login);
        $_SESSION['id'] = $id_login;
        $_SESSION['name'] = $name_login;
        $_SESSION['email'] = $email_login;
        $_SESSION['password'] = $password_login;
        $_SESSION['status'] = 1;
        $_SESSION['staff'] = 1;
        header('location:index.php?msg=login');
      }
    }



  } else if (isset($_POST['email'])) {
    $msg = " <div class='alert alert-danger alert-dismissible' role='alert' >
                  <strong>E-mail is Incorrect!!</strong>
              </div>";
  }
}
?>
<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth"
      style="background-image: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3)), url(assets/images/Ban/pexels-pixabay-289737.jpg); background-repeat: no-repeat; background-size:cover">
      <div class="row flex-grow" style="align-items:center;">
        <!-- <div class="col-lg-4 mx-auto">
          <img src="assets/images/Ban/Exams-bro.svg" class="img-fluid" alt="">
        </div> -->
        <div class="col-lg-4 mx-auto">
          <div class="auth-form-light text-center p-5"
            style="border-radius: 10px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);">
            <div class="brand-logo" style="display:flex; align-items:center; justify-content:center;">
              <a href="index.php"><img src="assets/images/IMAGELOGO.svg"></a>
            </div>
            <h4>Hello! Teacher</h4>
            <h6 class="font-weight-light">Sign in to continue.</h6>
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
            <form class="pt-3" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
              <div class="form-group" id="email">
                <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1"
                  placeholder="Email">
              </div>
              <div class="form-group">
                <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1"
                  placeholder="Password">
              </div>
              <div class="mt-3">
                <input type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn"
                  name="login" value="SIGN IN" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
  </div>
  <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<?php include_once ('components/footer.php'); ?>