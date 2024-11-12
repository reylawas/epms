<?php 
include 'includes/session.php'; 
include 'includes/header.php'; 
include 'includes/request_functions.php'; // Include the new functions file
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Resolution Center
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Resolution Center</li>
      </ol>
    </section>
    
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
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>Date</th>
                  <th>Reason</th>
                  <th>Status</th>
                </thead>
                <tbody>
                </tbody>
                <style>
                .status-approved {
                  color: green;
                  font-weight: bold;
                }
                .status-declined {
                  color: red;
                  font-weight: bold;
                }
                .status-pending {
                  color: black;
                  font-weight: bold;
                }            
                </style>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/resolution_center_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
    $(document).ready(function() {
        $('#addnew').on('show.bs.modal', function () {
            // Fetch employee_id using AJAX
            $.ajax({
                url: 'fetch_employee_id.php', // A PHP file to fetch the employee_id
                type: 'GET',
                success: function(data) {
                    $('#employee').val(data); // Set employee_id in the input field
                }
            });
        });
    });
</script>

</body>
</html>
