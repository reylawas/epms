<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>Biologs</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Biologs</li>
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
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>Arr./Dep.</th>
                  <th>Date</th>
                  <th>Time</th>
                </thead>
                <tbody>
                  <?php
                    // Get the employee_id of the logged-in user from the session
                    $employee_id = $_SESSION['admin'];

                    // Fetch attendance records for the logged-in employee only
                    $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid 
                            FROM attendance 
                            LEFT JOIN employees ON employees.id = attendance.employee_id 
                            WHERE attendance.employee_id = '$employee_id' 
                            ORDER BY attendance.date DESC, attendance.time_in DESC";
                    $query = $conn->query($sql);
                    $attendanceRecords = [];

                    // Combine attendance data into a single array
                    while ($row = $query->fetch_assoc()) {
                        if ($row['time_in'] != '00:00:00' && $row['time_in'] != null) {
                            $attendanceRecords[] = [
                                'type' => 'Arrival',
                                'date' => $row['date'],
                                'time' => $row['time_in'],
                                'attid' => $row['attid']
                            ];
                        }
                        if ($row['time_out'] != '00:00:00' && $row['time_out'] != null) {
                            $attendanceRecords[] = [
                                'type' => 'Departure',
                                'date' => $row['date'],
                                'time' => $row['time_out'],
                                'attid' => $row['attid']
                            ];
                        }
                    }
                    
                    // Sort the combined records by date and time in descending order
                    usort($attendanceRecords, function($a, $b) {
                      if ($a['date'] == $b['date']) {
                          return strcmp($b['time'], $a['time']); // Reverse comparison for time
                      }
                      return strcmp($b['date'], $a['date']); // Reverse comparison for date
                    });
                    
                    // Display the sorted attendance records
                    foreach ($attendanceRecords as $record) {
                      $dateFormatted = date('M d, Y', strtotime($record['date'])); // Formatted date
                      $timeFormatted = date('h:i A', strtotime($record['time'])); // Formatted time
                    
                      echo "
                      <tr>
                          <td class='hidden'></td>
                          <td>{$record['type']}</td>
                          <td>$dateFormatted</td>
                          <td>$timeFormatted</td>
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
  <?php include 'includes/attendance_modal.php'; ?>
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
    url: 'attendance_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#datepicker_edit').val(response.date);
      $('#attendance_date').html(response.date);
      $('#edit_time_in').val(response.time_in);
      $('#edit_time_out').val(response.time_out);
      $('#attid').val(response.attid);
      $('#employee_name').html(response.firstname+' '+response.middlename+' '+response.lastname);
      $('#del_attid').val(response.attid);
      $('#del_employee_name').html(response.firstname+' '+response.middlename+' '+response.lastname);
    }
  });
}
</script>
</body>
</html>
