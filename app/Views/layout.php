<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>MyBooth</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="/assets/vendors/feather/feather.css">
  <link rel="stylesheet" href="/assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="/assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="/assets/js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="/assets/css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="/assets/css/menu/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="/assets/images/favicon.png" />
  <script src="/assets/js/jquery-3.6.0.min.js"></script>
  <script src="/assets/js/sweetalert.min.js"></script>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5 font-weight-bold" href="<?php echo base_url('/'); ?>"><img src="/assets/images/app/MyBooth.png" class="mr-2" alt="logo" />MyBooth</a>
        <a class="navbar-brand brand-logo-mini" href="<?php base_url('/') ?>"><img src="/assets/images/app/MyBooth.png" alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator" href="<?php echo base_url('logout'); ?>">
              <i class="ti-power-off mx-0"></i>
            </a>

          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <!-- <div class="theme-setting-wrapper">
        <div id="settings-trigger"><i class="ti-settings"></i></div>
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close ti-close"></i>
          <p class="settings-heading">SIDEBAR SKINS</p>
          <div class="sidebar-bg-options selected" id="sidebar-light-theme">
            <div class="img-ss rounded-circle bg-light border mr-3"></div>Light
          </div>
          <div class="sidebar-bg-options" id="sidebar-dark-theme">
            <div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark
          </div>
          <p class="settings-heading mt-2">HEADER SKINS</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default"></div>
          </div>
        </div>
      </div> -->

      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('/'); ?>">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('employees'); ?>">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Employees</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('goods'); ?>">
              <i class="icon-stack menu-icon"></i>
              <span class="menu-title">Goods</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('transaction'); ?>">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Make a Transaction</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('report'); ?>">
              <i class="icon-paper-stack menu-icon"></i>
              <span class="menu-title">Transaction Report</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('levels'); ?>">
              <i class="icon-briefcase menu-icon"></i>
              <span class="menu-title">Job Level</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <!-- CONTENT -->
          <?= $this->renderSection('content') ?>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2022. My Booth from Choaz Randa. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="/assets/vendors/chart.js/Chart.min.js"></script>
  <script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="/assets/js/dataTables.select.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="/assets/js/off-canvas.js"></script>
  <script src="/assets/js/hoverable-collapse.js"></script>
  <script src="/assets/js/template.js"></script>
  <script src="/assets/js/settings.js"></script>
  <script src="/assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="/assets/js/dashboard.js"></script>
  <script src="/assets/js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
  <script>
    $(document).on("submit", "form", function(e) {
      e.preventDefault();
    });

    function tableEmpty(id) {
      let content = $(id).find('tbody');
      $(content).empty()
      html = ''
      html += '<tr class="empty_tbl">'
      html += '<td class="text-center" colspan="100%">'
      html += "there's no data yet"
      html += '</td>'
      html += '</tr>'
      content.html(html)
    }
  </script>
</body>

</html>