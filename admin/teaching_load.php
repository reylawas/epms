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
        Teaching Load
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Teaching Load</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php
        if (isset($_SESSION['error'])) {
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
          unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <div class="d-flex justify-content-between align-items-center">
                <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
                
                <!-- Filter Form -->
                <form action="" method="POST" class="form-inline">
                  <div class="form-group">
                    <label for="employee_id" required>Select Employee:</label>
                    <select name="employee_id" id="employee_id" class="form-control" required>
                      <option value="" disabled selected>- Select -</option>
                      <?php
                        $sql = "SELECT id, firstname, middlename, lastname FROM employees";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                          $selected = (isset($_POST['employee_id']) && $_POST['employee_id'] == $row['id']) ? 'selected' : '';
                          echo "<option value='" . $row['id'] . "' " . $selected . ">" . $row['firstname'] . " " . $row['middlename'] . " " . $row['lastname'] . "</option>";
                        }
                      ?>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary btn-sm btn-flat">
                    <i class="fa fa-search"></i> Search
                  </button>
                </form>
              </div>
            </div>

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
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    if (isset($_POST['employee_id'])) {
                      $employee_id = $_POST['employee_id'];

                      $sql = "SELECT *, schedules.id AS lid, employees.employee_id AS empid 
                              FROM schedules 
                              LEFT JOIN employees ON employees.id=schedules.employee_id 
                              WHERE employees.id = '$employee_id' 
                              ORDER BY schedules.time_in ASC";
                      $query = $conn->query($sql);
                      while ($row = $query->fetch_assoc()) {
                        echo "
                          <tr>
                              <td class='hidden'></td>
                              <td>" . date('h:i A', strtotime($row['time_in'])) . " - " . date('h:i A', strtotime($row['time_out'])) . "</td>
                              <td>" . $row['monday'] . "</td>
                              <td>" . $row['tuesday'] . "</td>
                              <td>" . $row['wednesday'] . "</td>
                              <td>" . $row['thursday'] . "</td>
                              <td>" . $row['friday'] . "</td>
                              <td>
                                  <button class='btn btn-success btn-sm btn-flat edit' data-id='" . $row['lid'] . "'><i class='fa fa-edit'></i> Edit</button>
                                  <button class='btn btn-danger btn-sm btn-flat delete' data-id='" . $row['lid'] . "'><i class='fa fa-trash'></i> Delete</button>
                              </td>
                          </tr>
                        ";
                      }
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
$(function() {
  $('.edit').click(function(e) {
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.delete').click(function(e) {
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
});

function getRow(id) {
  $.ajax({
    type: 'POST',
    url: 'teaching_load_row.php',
    data: {id: id},
    dataType: 'json',
    success: function(response) {
      $('#edit_id').val(response.id);
      $('#edit_employee').val(response.employee_id);
      $('#edit_time_in').val(response.time_in);
      $('#edit_time_out').val(response.time_out);
      $('#edit_monday').val(response.monday);
      $('#edit_tuesday').val(response.tuesday);
      $('#edit_wednesday').val(response.wednesday);
      $('#edit_thursday').val(response.thursday);
      $('#edit_friday').val(response.friday);
      $('.del_employee_name').html(response.firstname + ' ' + response.lastname);
      $('.employee_id').html(response.employee_id);
    }
  });
}
</script>

<style>
  .hide-column {
    display: none;
  }
  .d-flex {
    display: flex;
  }
  .justify-content-between {
    justify-content: space-between;
  }
  .align-items-center {
    align-items: center;
  }
  .dataTables_filter label {
        display: none;
      }
      .dataTables_length {
  display: none;
}
</style>
</body>
</html>
