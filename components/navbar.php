<!-- partial:partials/_navbar.html -->
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo" href="index.php"><img src="assets/images/IMAGELOGO.svg" alt="logo" /></a>
    <a class="navbar-brand brand-logo-mini" href="index.php"><img src="assets/images/lefere.svg" alt="logo" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown" title="<?= isset($_SESSION['name']) ? $_SESSION['name'] : 'User' ?>">
        <a class="nav-link" id="profileDropdown" href="#">
          <div class="nav-profile-img">

            <img src="assets/images/faces/user.webp" alt="image">
            <span class="availability-status online" title="online"></span>
          </div>
          <div class="nav-profile-text text-center">
            <p class="mb-1 text-black" title="<?= isset($_SESSION['name']) ? $_SESSION['name'] : 'User' ?>">
              <?= isset($_SESSION['name']) ? $_SESSION['name'] : 'User' ?>
            </p>
            <p class="mb-1 text-black" title="<?= isset($_SESSION['phone']) ? $_SESSION['phone'] : '' ?>"><span
                class="text-secondary text-small">
                <?= isset($_SESSION['phone']) ? $_SESSION['phone'] : '' ?>
              </span></p>
          </div>
        </a>
      </li>
      <!-- <li class="nav-item d-lg-block full-screen-link" title="Fullscreen">
        <a class="nav-link">
          <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
        </a>
      </li> -->
      <li class="nav-item nav-logout d-lg-block" title="Logout">
        <a class="nav-link" href="logout.php">
          <i class="mdi mdi-power"></i>
        </a>
      </li>
      <li class="nav-item nav-settings d-lg-block" title="Back to Top">
        <a class="nav-link" href="#">
          <i class="mdi mdi-format-line-spacing"></i>
        </a>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
      data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
<!-- partial -->