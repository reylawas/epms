<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/getSchedulesByUserId.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
        Schedule
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Schedule</li>
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
                  <th>Time</th>
                  <th>Monday</th>
                  <th>Tuesday</th>
                  <th>Wednesday</th>
                  <th>Thursday</th>
                  <th>Friday</th>
                </thead>
                <tbody>
<?php
    $userId = $_SESSION['admin']; // Replace 'user' with your session variable

    $schedules = getSchedulesByUserId($conn, $userId);
    foreach ($schedules as $row) {
        echo "
            <tr>
                <td class='hidden'></td>
                <td>".date('h:i A', strtotime($row['time_in']))." - ".date('h:i A', strtotime($row['time_out']))."</td>
                <td>".$row['monday']."</td>
                <td>".$row['tuesday']."</td>
                <td>".$row['wednesday']."</td>
                <td>".$row['thursday']."</td>
                <td>".$row['friday']."</td>
            </tr>
        ";
    }
?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/teaching_load_modal.php'; ?>
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
