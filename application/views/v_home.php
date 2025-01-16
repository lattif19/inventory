<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>INVENTORY SYSTEM | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <link href="<?php echo base_url(); ?>assets/dist/img/logo.png" rel="shortcut icon" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bower/bootstrap/dist/css/font-awesome.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"> -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker-bs3.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower/select2/dist/css/select2.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower/datatables.net-bs/css/dataTables.bootstrap.css">
    <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->


        <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/datatables/dataTables.bootstrap.css"/> -->
        <!-- <script src=" base_url(); ?>assets/datatables/dataTables.bootstrap.js"></script> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script  src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <style>
          .pilih:hover{
            cursor: pointer;
          }
          .color-palette {
            height: 35px;
            line-height: 35px;
            text-align: center;
          }
          .color-palette-set {
            margin-bottom: 15px;
          }
          .color-palette span {
            display: none;
            font-size: 12px;
          }
          .color-palette:hover span {
            display: block;
          }
          .color-palette-box h4 {
            position: absolute;
            top: 100%;
            left: 25px;
            margin-top: -40px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
            display: block;
            z-index: 7;
          }
          #example tr td {
            height: 10px;
          }
          table.table tbody tr:nth-child(even):hover td{
            background-color: #98effd; /* #d6d6d6; */
          }

          table.table tbody tr:nth-child(odd):hover td {
            background-color:  #98effd; /* #dfe4e5; */
          }
        </style>



        <!-- ANGULAR SCRIPT -->

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-filter/0.5.14/angular-filter.min.js" integrity="sha256-jNsHipmANwi6Iin1zoXdZgw/0qP6ZaBtnj8kyKmFjMM=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bower/bootstrap/js/angular-underscore-module.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-animate.js"></script>
  
        <!-- <script src="<?php echo base_url(); ?>assets/bower/jquery/dist/core.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/3.4.6/minified.js"></script>
        <!-- <script src="<?php echo base_url(); ?>assets/js/issue.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/rtrn_vendor.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/rtrn_warehouse.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/stockopname.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/mapping_receive.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/mapping_issue.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/non_po_receive.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/non_wo_issue.js"></script> -->
       
        <script src="<?php echo base_url(); ?>assets/bower/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery-ui.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery-ui.min.js"></script>

      </head>
      <body class="hold-transition skin-blue sidebar-mini <?php if ($this->uri->segment(1) == 'home') {echo 'sidebar-collapse';} ?>"  ng-app="warehouse">
        <div class="wrapper">
          <header class="main-header">

            <!-- Logo -->
            <a href="#" class="logo">
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class="logo-mini"><b>S2P</b></span>
              <!-- logo for regular state and mobile devices -->
              <span class="logo-lg"><b>INVENTORY</b></span>
            </a>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
              <!-- Sidebar toggle button-->
              <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
              </a>
              <!-- Navbar Right Menu -->
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <!-- User Account: style can be found in dropdown.less -->
                  <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="<?php echo base_url(); ?>assets/uploads/notavailable.png" class="user-image" alt="User Image">
                      <span class="hidden-xs"><?php echo $this->session->userdata('displayname'); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- User image -->
                      <li class="user-header">
                        <img src="<?php echo base_url(); ?>assets/uploads/notavailable.png" class="img-circle" alt="User Image">
                        <p>
                         <?php echo $this->session->userdata('displayname'); ?>
                         <small></small>
                       </p>
                     </li>
                     <!-- Menu Footer-->
                     <li class="user-footer">

                      <div class="pull-left">
                        <a href="<?php echo base_url(); ?>admin/profil/" class="btn btn-info btn-flat">Profile</a>
                      </div>
                      <div class="pull-right">
                        <a href="<?php echo base_url(); ?>home/logout" class="btn btn-danger btn-flat">Log out</a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>


            <div class="navbar-custom-menu pull-left">
              <ul class="nav navbar-nav">
                <li <?php if ($this->uri->segment(1) == 'home') { echo 'class="active"'; } ?>>
                  <?php if($this->session->userdata('level')=='0'){ ?>
                  <a href="<?php echo base_url();?>home" >
                    <i class="fa fa-dashboard">
                      Dashboard</i>
                    </a>
                  </li>
                  <li <?php if ($this->uri->segment(1) == 'master-data') { echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url();?>master-data/barcode" id="master1">
                      <i class="fa fa-laptop"> Master</i>
                    </a>
                  </li>
                  <li <?php if ($this->uri->segment(1) == 'transaction') { echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url();?>transaction/receiving" id="transaction1">
                      <i class="fa fa-laptop"> Transaction</i>
                    </a>
                  </li>
                  <li <?php if ($this->uri->segment(1) == 'report') { echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url();?>report/receiving" id="report1">
                      <i class="fa fa-print"> Report</i>
                    </a>
                  </li>
                  <li <?php if ($this->uri->segment(1) == 'admin') { echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url();?>admin" id="user1">
                      <i class="fa fa-users"> Users </i>
                    </a>
                  </li>
                  <?php } elseif ($this->session->userdata('level')=='1') { ?>

                  <li <?php if ($this->uri->segment(1) == 'home') { echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url();?>home" >
                      <i class="fa fa-dashboard">
                        Dashboard</i>
                      </a>
                    </li>
                    <li <?php if ($this->uri->segment(1) == 'master-data') { echo 'class="active"'; } ?>>
                      <a href="<?php echo base_url();?>master-data/barcode" id="master1">
                        <i class="fa fa-laptop"> Master</i>
                      </a>
                    </li>
                    <li <?php if ($this->uri->segment(1) == 'transaction') { echo 'class="active"'; } ?>>
                      <a href="<?php echo base_url();?>transaction/receiving" id="transaction1">
                        <i class="fa fa-laptop"> Transaction</i>
                      </a>
                    </li>
                    <li <?php if ($this->uri->segment(1) == 'report') { echo 'class="active"'; } ?>>
                      <a href="<?php echo base_url();?>report/receiving" id="report1">
                        <i class="fa fa-print"> Report</i>
                      </a>
                    </li>

                    <?php } elseif ($this->session->userdata('level')=='2') { ?>

                    <li <?php if ($this->uri->segment(1) == 'home') { echo 'class="active"'; } ?>>
                      <a href="<?php echo base_url();?>home" >
                        <i class="fa fa-dashboard">
                          Dashboard</i>
                        </a>
                      </li>
                      <li <?php if ($this->uri->segment(1) == 'master-data') { echo 'class="active"'; } ?>>
                        <a href="<?php echo base_url();?>master-data/barcode" id="master1">
                          <i class="fa fa-laptop"> Master</i>
                        </a>
                      </li>
                      <li <?php if ($this->uri->segment(1) == 'transaction') { echo 'class="active"'; } ?>>
                        <a href="<?php echo base_url();?>transaction/receiving" id="transaction1">
                          <i class="fa fa-laptop"> Transaction</i>
                        </a>
                      </li>
                      <li <?php if ($this->uri->segment(1) == 'report') { echo 'class="active"'; } ?>>
                        <a href="<?php echo base_url();?>report/receiving" id="report1">
                          <i class="fa fa-print"> Report</i>
                        </a>
                      </li>

                      <li <?php if ($this->uri->segment(1) == 'admin') { echo 'class="active"'; } ?>>
                        <a href="<?php echo base_url();?>admin" id="user1">
                          <i class="fa fa-users"> Users </i>
                        </a>
                      </li>

                      <!-- <li <?php if ($this->uri->segment(1) == 'help') { echo 'class="active"'; } ?>>
                        <a href="<?php echo base_url();?>assets/user_guide/wic.pdf" id="user1">
                          <i class="fa fa-info"> Help </i>
                        </a>
                      </li> -->

<!-- 
                      <li <?php if ($this->uri->segment(1) == 'monitoring') { echo 'class="active"'; } ?>>
                        <a href="<?php echo base_url();?>monitoring/monitoring" id="monitoring">
                          <i class="fa fa-desktop"> Monitoring </i>
                        </a>
                      </li> -->

                     <?php } ?>
                    </ul>
                  </div><!-- /.navbar-collapse -->

                  <div class="navbar-custom-menu pull-right">
                    <ul class="nav navbar-nav">
                      <!-- Messages: style can be found in dropdown.less-->
                      <li>
                        <a href="<?php echo base_url();?>assets/user_guide/wic.pdf">
                          <i class="fa fa-info-circle"> Help</i>
                          <!-- <span class="label label-success">4</span> -->
                        </a>
                      </li>
                    </ul>
                  </div><!-- /.navbar-collapse -->

                </nav>
              </header>
              <!-- Left side column. contains the logo and sidebar -->
              <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                  <!-- Sidebar user panel -->
                  <div class="user-panel">
                    <div class="pull-left image">
                      <img src="<?php echo base_url(); ?>assets/uploads/notavailable.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                      <p><?= $this->session->userdata('displayname') ?></p>
                      <a href="#"><i class="fa fa-circle text-success"></i><?=  $this->session->userdata('status') ?></a>
                    </div>
                  </div>
                  <!-- sidebar menu: : style can be found in sidebar.less -->
                  <?php $this->load->view('v_menu'); ?>
                </section>
                <!-- /.sidebar -->
              </aside>

              <!-- Content Wrapper. Contains page content -->
              <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                  <h1>
                    <?php echo $judul; ?>
                    <small><?php echo $sub_judul;?></small>
                  </h1>
                  <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>home"><i class="fa fa-dashboard"></i><?php echo $judul;?></a></li>
                    <li <?php if ($this->uri->segment(2)) { echo 'class="active"'; } ?>><a href="<?php echo $_SERVER['HTTP_REFERER'] ; ?>"><?php echo $sub_judul;?> </a></li>
                    <?php
                    if (!$class) {
                      echo $class;
                    } else {
                     echo "<li>$class</li>";
                   }
                   ?>
                 </section>

                 <!-- Main content -->
                 <section class="content" id="content">

                  <?php $this->load->view($content); ?>
                </section><!-- /.content -->
              </div><!-- /.content-wrapper -->

              <footer class="main-footer">
                <div class="pull-right hidden-xs">
                  <b>Version</b> Beta 1.0
                </div>
                <strong>Warehouse Inventory, PT. SUMBER SEGARA PRIMADAYA.</strong> Copyright &copy; 2016. ENTWO ELECTRONIC &amp; ENGINERING.
              </footer>

              <!-- Control Sidebar -->

      <!-- Add the sidebar's background. This div must be placed
      immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>

    </div><!-- ./wrapper -->
    
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>assets/bower/fastclick/lib/fastclick.js"></script>
    <script src="<?php echo base_url(); ?>assets/bower/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/bower/select2/dist/js/select2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
    
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script> -->
    <!-- <script src="<?php echo base_url(); ?>assets/custom.js"></script> -->
    
    <!-- jvectormap -->
    <script src="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="<?php echo base_url(); ?>assets/bower/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="<?php echo base_url(); ?>assets/bower/chart.js/Chart.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard2.js"></script> -->

    <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
    <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": false,
          "autoWidth": false
        });
      });
    </script>

    <script>
     function myFunction() {
      var x = document.getElementById('menu');
      if (x.style.visibility === 'visible') {
        x.style.visibility = 'hidden';
      } else {
        x.style.visibility = 'visible';
      }
    }
  </script>
  <!-- <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();


        $('#reservation').daterangepicker();
      });
    </script> -->
  </body>
  </html>
