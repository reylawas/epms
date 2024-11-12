<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pass Slip
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pass Slip</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <!-- Button for printing -->
              <button onclick="printPassSlip()" class="btn btn-success btn-sm btn-flat">
                <span class="glyphicon glyphicon-print"></span> Print
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Hidden iframe for printing -->
      <iframe id="print_frame" name="print_frame" style="display: none;"></iframe>
    </section>   
  </div>

  <?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
  function printPassSlip() {
    // Set the iframe's source to load the passlip_print.php
    document.getElementById('print_frame').src = 'passlip_print.php';
    
    // Wait for the iframe to load the content and then trigger print
    document.getElementById('print_frame').onload = function() {
      this.contentWindow.focus(); // Focus on the iframe's window
      this.contentWindow.print(); // Trigger the print dialog
    };
  }
</script>
</body>
</html>
