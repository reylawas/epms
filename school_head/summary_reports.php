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
        Summary Reports
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Summary Reports</li>
      </ol>
    </section>
    <style>
      .dataTables_filter label {
        display: none;
      }
      .filter-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      .form-left {
        text-align: left;
      }
      .form-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
      }
      .form-right .form-group {
        margin-left: 10px;
      }
    </style>
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
              <!-- Select Month and Year and Print Button -->
              <button onclick="printSummaryReports()" class="btn btn-success btn-sm btn-flat">
                <span class="glyphicon glyphicon-print"></span> Print
              </button>
              <div class="form-inline" style="display: inline-block; float: right;">
                <div class="form-group">
                  <label for="month">Select Month and Year:</label>
                  <input type="month" id="month" name="month" class="form-control" required onchange="enablePrintButton()">
                </div>
                <button type="submit" class="btn btn-primary btn-sm btn-flat">
                    <i class="fa fa-search"></i> Search
                  </button>
              </div>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th rowspan="2">NO.</th>
                    <th rowspan="2">EMPLOYEE ID NO.</th> 
                    <th colspan="3">NAME OF EMPLOYEE</th>
                    <th colspan="1"></th>
                    <th colspan="5">WITH PAY</th>
                    <th rowspan="2">DIVISION ACTION</th>
                    <th colspan="5">WITHOUT PAY</th>
                    <th rowspan="2">DIVISION ACTION</th>
                    <th rowspan="2">NO. OF TIMES TARDY</th>
                    <th rowspan="2">NO. OF TIMES UNDERTIME</th>
                    <th rowspan="2">REMARKS</th>
                </tr>
                <tr>
                    <th>LAST</th>
                    <th>FIRST</th>
                    <th>M.I</th>
                    <th>EXT</th>
                    <th>EXCLUSIVE DATES</th>
                    <th>DAY</th>
                    <th>HOUR</th>
                    <th>MINUTES</th>
                    <th>CAUSE OF LEAVE</th>
                    <th>EXCLUSIVE DATES</th>
                    <th>DAY</th>
                    <th>HOUR</th>
                    <th>MINUTES</th>
                    <th>CAUSE OF LEAVE</th>
                </tr>
            </thead>
                <tbody>
                </tbody>
              </table>
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
  function enablePrintButton() {
    const monthInput = document.getElementById("month").value;
    const printButton = document.getElementById("print_button");
    printButton.disabled = !monthInput; // Enable if month is selected
  }

  function printSummaryReports() {
    const month = document.getElementById("month").value;
    if (!month) return; // Ensure month is selected

    const iframe = document.getElementById('print_frame');
    iframe.src = `summary_reports_print.php?month=${month}`;
    iframe.onload = function() {
      this.contentWindow.focus();
      this.contentWindow.print();
    };
  }
</script>
</body>
</html>
