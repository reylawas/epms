<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $user['firstname'].' '.$user['lastname']; ?></p>
          <a><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">REPORTS</li>
        <li class=""><a href="home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="header">MANAGE</li>
          <li><a href="employee_leave_request.php"><i class="fa fa-user-times"></i> <span>Leave</span></a></li>
          <li><a href="resolution_center.php"><i class="fa fa-cogs"></i> <span>Resolution Center</span></a></li>
        </li>
        <li class="header">VIEW</li>
        <li><a href="attendance_history.php"><i class="fa fa-calendar"></i> <span>Biologs</span></a></li>
        <li><a href="teaching_load.php"><i class="fa fa-clock-o"></i> <span>Schedule</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
