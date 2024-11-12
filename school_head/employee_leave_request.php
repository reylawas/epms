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
        Leaves
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Leaves</li>
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
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>Date</th>
                  <th>Name</th>
                  <th>Leave Type</th>
                  <th>Reason</th>
                  <th>Date from - Date to</th>
                  <th>Status</th>
                </thead>
                <tbody>
<?php
    $sql = "SELECT *, leaves.id AS lid, employees.employee_id AS empid FROM leaves LEFT JOIN employees ON employees.id=leaves.employee_id ORDER BY leaves.date DESC";
    $query = $conn->query($sql);
    while($row = $query->fetch_assoc()){
      $statusClass = '';
      $showEditButton = true; // Default to showing the edit button
      if($row['status'] == 'Approved'){
          $statusClass = 'status-approved';
          $showEditButton = false; // Hide edit button for Approved status
      } elseif($row['status'] == 'Declined'){
          $statusClass = 'status-declined';
          $showEditButton = false; // Hide edit button for Declined status
      } else {
          $statusClass = 'status-pending';
      }
  
      echo "
          <tr>
              <td class='hidden'></td>
              <td>".date('M d, Y', strtotime($row['date']))."</td>
              <td>".$row['firstname'].' '.$row['lastname']."</td>
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
$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.delete').click(function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'employee_leave_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.lid').val(response.lid);
      $('.leaves_id').html(response.leaves_id);
      $('.del_employee_name').html(response.firstname+' '+response.lastname);
      $('.employee_name').html(response.firstname+' '+response.lastname);
      $('#status_val').val(response.status).html(response.status);
    }
  });
}
</script>
</body>
</html>
