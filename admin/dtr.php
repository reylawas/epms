<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>Daily Time Record</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Daily Time Record</li>
      </ol>
    </section>
    <style>
      .dataTables_filter label {
        display: none;
      }
      .dataTables_length {
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
              <!-- Filter Form -->
              <form action="" method="POST" class="form-inline filter-container">
                <div class="form-right">
                  <!-- Print Button Form -->
                  <a href="attendance_print.php?employee_id=<?php echo isset($_POST['employee_id']) ? $_POST['employee_id'] : ''; ?>&month=<?php echo isset($_POST['month']) ? $_POST['month'] : ''; ?>" target="print_frame" class="btn btn-success btn-sm btn-flat">
                    <span class="glyphicon glyphicon-print"></span> Print
                  </a>
                </div>
                <div class="form-left">
                  <div class="form-group">
                    <label for="employee_id"required>Select Employee:</label>
                    <select name="employee_id" id="employee_id" class="form-control" required>
                      <option value="" disabled selected>- Select -</option>
                      <?php
                        $sql = "SELECT id, firstname, middlename, lastname FROM employees";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                          $selected = (isset($_POST['employee_id']) && $_POST['employee_id'] == $row['id']) ? 'selected' : '';
                          echo "<option value='".$row['id']."' ".$selected.">".$row['firstname']." ".$row['middlename']." ".$row['lastname']."</option>";
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="month">Select Month and Year:</label>
                    <input type="month" id="month" name="month" class="form-control" required value="<?php echo isset($_POST['month']) ? $_POST['month'] : ''; ?>">
                  </div>
                  <button type="submit" class="btn btn-primary btn-sm btn-flat">
                    <i class="fa fa-search"></i> Search
                  </button>
                </div>
              </form>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>Arr./Dep.</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Name</th>
                </thead>
                <tbody>
                <?php
  // Check if filter parameters are set
  if (isset($_POST['employee_id']) && isset($_POST['month'])) {
    $employee_id = $_POST['employee_id'];
    $month = date('Y-m', strtotime($_POST['month']));
    
    // Fetch filtered attendance records based on employee_id and month
    $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid 
            FROM attendance 
            LEFT JOIN employees ON employees.id = attendance.employee_id 
            WHERE employees.id = '$employee_id' 
            AND DATE_FORMAT(attendance.date, '%Y-%m') = '$month' 
            ORDER BY attendance.date DESC, attendance.time_in DESC";
  } else {
    // Fetch all attendance records if no filters are applied
    $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid 
            FROM attendance 
            LEFT JOIN employees ON employees.id = attendance.employee_id 
            ORDER BY attendance.date DESC, attendance.time_in DESC";
  }

  // Execute the query
  $query = $conn->query($sql);
  $attendanceRecords = [];
  
  // Combine attendance data into a single array
while ($row = $query->fetch_assoc()) {
  // Assign status based on the attendance status
  $status = ($row['status']) ? '<span class="label label-warning pull-right">ontime</span>' : '<span class="label label-danger pull-right">undertime</span>';

  // Ensure both Arrival and Departure records have a 'status'
  if ($row['time_in'] != '00:00:00' && $row['time_in'] != null) {
      $attendanceRecords[] = [
          'type' => 'Arrival',
          'date' => $row['date'],
          'time' => $row['time_in'],
          'fullName' => $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'],
          'attid' => $row['attid'],
          'status' => $status // Add status here
      ];
  }

  if ($row['time_out'] != '00:00:00' && $row['time_out'] != null) {
      $attendanceRecords[] = [
          'type' => 'Departure',
          'date' => $row['date'],
          'time' => $row['time_out'],
          'fullName' => $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'],
          'attid' => $row['attid'],
          'status' => $status // Add status here
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
  $status = $record['status']; // Get the status (ontime/late)

  echo "
  <tr>
      <td class='hidden'></td>
      <td>{$record['type']}</td>
      <td>$dateFormatted</td>
      <td>$timeFormatted</td>
      <td>{$record['fullName']}</td>
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

  <iframe id="print_frame" name="print_frame" style="display: none;"></iframe>

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
