<?php
  require '../authguard.php';
  if (!isset($_SESSION['username'])) {
    header("Location: ../");
    exit();
  }
  if (!isset($_SESSION['STARTED'])) {
    $_SESSION['STARTED'] = time();
  } else if (time() - $_SESSION['STARTED'] > 3600) {
      // session started more than 1h
      header("Location: logout.php"); // logout
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="../assets/img/brand/favicon.png">
  <title>Dashboard</title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link href="./assets/css/font-awesome.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="./assets/css/argon-design-system.css?v=1.2.2" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class="index-page">
  <!-- Navbar -->
  <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg bg-white navbar-light position-sticky top-0 shadow py-2">
    <div class="container">
      <a class="navbar-brand mr-lg-5" href="index.php">
        <img src="../assets/img/brand/blue.png">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse collapse" id="navbar_global">
        <div class="navbar-collapse-header">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="./index.html">
                <img src="../assets/img/brand/blue.png">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <ul class="navbar-nav align-items-lg-center ml-lg-auto">
          <li class="nav-item">
            <a class="nav-link nav-link-icon" href="logout.php">
                  <i class="fa fa-sign-out"></i>
                  <span class="nav-link-inner--text">Logout</span>
                </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="wrapper">
    <div class="section section-hero section-shaped">
      <div class="shape shape-style-1 shape-primary">
        <span class="span-150"></span>
        <span class="span-50"></span>
        <span class="span-50"></span>
        <span class="span-75"></span>
        <span class="span-100"></span>
        <span class="span-75"></span>
        <span class="span-50"></span>
        <span class="span-100"></span>
        <span class="span-50"></span>
        <span class="span-100"></span>
      </div>
      <div class="page-header">
        <div class="container shape-container d-flex align-items-center py-lg">
          <div class="col px-0">
            <div class="row align-items-center justify-content-center">
              <div class="col-lg-6 text-center">
                <img src="./assets/img/background.jpg" style="width: 160px;" class="img-fluid rounded-circle">
                <div class="lead text-white">
                  <h3 class="text-white">Project Name<span class="font-weight-light text-white"> v1.0</span></h3>
                  Small Description Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do.
                </div>
                <div class="btn-wrapper mt-5">
                  <a href="#" class="btn btn-lg btn-white btn-icon mb-3 mb-sm-0">
                    <span class="btn-inner--icon"><i class="fa fa-download"></i></span>
                    <span class="btn-inner--text">Download</span>
                  </a>
                  <a href="#" class="btn btn-lg btn-github btn-icon mb-3 mb-sm-0" target="_blank">
                    <span class="btn-inner--icon"><i class="fa fa-coffee"></i></span>
                    <span class="btn-inner--text">Buy Me a <span class="text-warning">Coffee</span></span>
                  </a>
                </div>
                <div class="mt-5">
                  <small class="font-weight-bold mb-0 mr-2 text-white">*proudly coded by</small>
                  <img src="./assets/img/developper.png" style="height: 28px;">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <div class="section section-components pb-0" id="section-components">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <!-- Basic elements -->
            <h2 class="mb-5">
              <span>General Info</span>
            </h2>
            <!-- Buttons -->
            <h3 class="h4 text-success font-weight-bold mb-4" id="info">Account Info</h3>
            <div class="mb-3">
              <small class="text-uppercase font-weight-bold">View your account information here.</small>
            </div>
            <div class="row py-3 align-items-center">
              <div class="col-sm-3">
                <small class="text-uppercase text-muted font-weight-bold">ID</small>
              </div>
              <div class="col-sm-9">
                <p class="mb-0"><?php echo $_SESSION["id"]; ?></p>
              </div>
            </div>
            <div class="row py-3 align-items-center">
              <div class="col-sm-3">
                <small class="text-uppercase text-muted font-weight-bold">username</small>
              </div>
              <div class="col-sm-9">
                <p class="mb-0"><?php echo $_SESSION["username"]; ?></p>
              </div>
            </div>
            <div class="row py-3 align-items-center">
              <div class="col-sm-3">
                <small class="text-uppercase text-muted font-weight-bold">email</small>
              </div>
              <div class="col-sm-9">
                <p class="mb-0"><?php echo $_SESSION["email"]; ?></p>
              </div>
            </div>
            <div class="row py-3 align-items-center">
              <div class="col-sm-3">
                <small class="text-uppercase text-muted font-weight-bold">expiry</small>
              </div>
              <div class="col-sm-9">
                <p class="mb-0 text-warning"><?php echo $_SESSION["expiry"]; ?></p>
              </div>
            </div>
            <div class="row py-3 align-items-center">
              <div class="col-sm-3">
                <small class="text-uppercase text-muted font-weight-bold">level</small>
              </div>
              <div class="col-sm-9">
                <p class="mb-0 text-primary"><?php echo $_SESSION["level"]; ?></p>
              </div>
            </div>
            <div class="row py-3 align-items-center">
              <div class="col-sm-3">
                <small class="text-uppercase text-muted font-weight-bold">hwid</small>
              </div>
              <div class="col-sm-9">
                <p class="mb-0"><?php echo $_SESSION["hwid"]; ?></p>
              </div>
            </div>
            <div class="row py-3 align-items-center">
              <div class="col-sm-3">
                <small class="text-uppercase text-muted font-weight-bold">lastlogin</small>
              </div>
              <div class="col-sm-9">
                <p class="mb-0 text-info"><?php echo $_SESSION["lastlogin"]; ?></p>
              </div>
            </div>
            <div class="row py-3 align-items-center">
              <div class="col-sm-3">
                <small class="text-uppercase text-muted font-weight-bold">variables</small>
              </div>
              <div class="col-sm-9">
                <p class="mb-0"><?php echo json_decode($_SESSION["variables"])->varname; //Please change 'varname' with your variable name :) ?></p>
              </div>
            </div>
            <div class="row py-3 align-items-center">
              <div class="col-sm-3">
                <small class="text-uppercase text-muted font-weight-bold">totalclients</small>
              </div>
              <div class="col-sm-9">
                <p class="mb-0"><?php echo $_SESSION["totalclients"]; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="section pb-0 section-components">
      <div class="container mb-5">
        <!-- Basic elements -->
        <h2 class="mb-5">
          <span>Account Settings</span>
        </h2>
        <!-- Inputs -->
        <h3 class="h4 text-success font-weight-bold mb-4">Change Password</h3>
        <div class="mb-3">
          <small class="text-uppercase font-weight-bold">Change your password to your current account here.</small>
        </div>
        <form method="POST">
        <div class="row">
          <div class="col-lg-4 col-sm-6">
            <div class="form-group">
              <div class="input-group mb-4">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                </div>
                <input class="form-control" placeholder="Current Password" type="text" name="password">
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="form-group">
              <div class="input-group mb-4">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                </div>
                <input class="form-control" placeholder="New Password" type="text" name="newpassword">
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <button class="form-control btn-primary" type="submit" name="changepassword">Update Password</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  <footer class="footer has-cards">
    <div class="container container-lg">
      <div class="row">
        <div class="col-md-6 mb-5 mb-md-0">
          <div class="card card-lift--hover shadow border-0">
            <a href="javascript:;" title="Landing Page">
              <img src="./assets/img/landing.jpg" class="card-img">
            </a>
          </div>
        </div>
        <div class="col-md-6 mb-5 mb-lg-0">
          <div class="card card-lift--hover shadow border-0">
            <a href="javascript:;" title="Profile Page">
              <img src="./assets/img/landing.jpg" class="card-img">
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row row-grid align-items-center my-md">
        <div class="col-lg-6">
          <h3 class="text-primary font-weight-light mb-2">Thank you for supporting us!</h3>
          <h4 class="mb-0 font-weight-light">Let's get in touch on any of these platforms.</h4>
        </div>
        <div class="col-lg-6 text-lg-center btn-wrapper">
          <button target="_blank" href="#" rel="nofollow" class="btn-icon-only rounded-circle btn btn-facebook" data-toggle="tooltip" data-original-title="Like us">
            <span class="btn-inner--icon"><i class="fab fa-facebook"></i></span>
          </button>
          <button target="_blank" href="#" rel="nofollow" class="btn btn-icon-only btn-twitter rounded-circle" data-toggle="tooltip" data-original-title="Follow us">
            <span class="btn-inner--icon"><i class="fa fa-twitter"></i></span>
          </button>
          <button target="_blank" href="#" rel="nofollow" class="btn btn-icon-only btn-instagram rounded-circle" data-toggle="tooltip" data-original-title="Follow us">
            <span class="btn-inner--icon"><i class="fa fa-instagram"></i></span>
          </button>
          <button target="_blank" href="#" rel="nofollow" class="btn btn-icon-only btn-github rounded-circle" data-toggle="tooltip" data-original-title="Star on Github">
            <span class="btn-inner--icon"><i class="fa fa-github"></i></span>
          </button>
        </div>
      </div>
      <hr>
      <div class="row align-items-center justify-content-md-between">
        <div class="col-md-6">
          <div class="copyright">
            Copyright <a href="https://authguard.net" target="_blank">AuthGuard</a> 2021 &copy; All Rights Reserved.
          </div>
        </div>
        <div class="col-md-6">
          <ul class="nav nav-footer justify-content-end">
            <li class="nav-item">
              <a href="javascript:;" class="nav-link">Privacy Policy</a>
            </li>
            <li class="nav-item">
              <a href="javascript:;" class="nav-link">Terms of service</a>
            </li>
            <li class="nav-item">
              <a href="javascript:;" class="nav-link">Support</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  </div>
  <!--   Core JS Files   -->
  <script src="./assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <?php
    AuthGuard::Initialize();

    if (isset($_POST["changepassword"]))
    {
      $password = $_POST['password'];
      $newpass = $_POST['newpassword'];

      if (AuthGuard::ChangePassword($password, $newpass))
      {
        AuthGuard::success('Success');
      }
    }
  ?>
  <script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="./assets/js/core/bootstrap.min.js" type="text/javascript"></script>
</body>

</html>