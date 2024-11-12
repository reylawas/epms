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
        Leave Request
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Leave</li>
        <li class="active">Leave Request</li>
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
                  <th>Leave Type</th>
                  <th>Reason</th>
                  <th>Date from - Date to</th>
                  <th>Status</th>
                </thead>
                <tbody>
                  <?php
                    $userId = $_SESSION['admin']; // Assuming the user ID is stored in the session as 'admin'
                    $leaves = getLeavesByUserId($conn, $userId);
                    foreach ($leaves as $row) {
                        $statusClass = '';
                        if($row['status'] == 'Approved'){
                            $statusClass = 'status-approved';
                        } elseif($row['status'] == 'Declined'){
                            $statusClass = 'status-declined';
                        } else {
                            $statusClass = 'status-pending';
                        }

                        echo "
                            <tr>
                                <td class='hidden'></td>
                                <td>".date('M d, Y', strtotime($row['date']))."</td>
                                <td>".$row['leave_type']."</td>
                                <td>".$row['reason']."</td>
                                <td>".date('M d, Y', strtotime($row['date_from']))." to ".date('M d, Y', strtotime($row['date_to']))."</td>
                                <td class='$statusClass'>".$row['status']."</td>
                            </tr>
                        ";
                    }
                  ?>
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
  <?php include 'includes/leave_request_modal.php'; ?>
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
