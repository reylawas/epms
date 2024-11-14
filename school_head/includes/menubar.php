<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
            <p><?php echo $user['firstname'] . ' ' . $user['middlename'] . ' ' . $user['lastname']; ?></p>
                <a><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">REPORTS</li>
            <li><a href="home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class="header">MANAGE</li>
            <li><a href="employee.php"><i class="fa fa-users"></i> Employees</a></li>
            <li><a href="employee_leave_request.php"><i class="fa fa-user-times"></i> Leaves</a></li>
            <li class="header">PRINTABLES</li>
            <li><a href="dtr.php"><i class="fa fa-book"></i> <span>Daily Time Record</span></a></li>
            <li><a href="passlip.php"><i class="fa fa-file-text"></i> <span>Pass Slip</span></a></li>
            <li><a href="teaching_load.php"><i class="fa fa-file-text-o"></i> <span>Teaching Load</span></a></li>
            <li><a href="summary_reports.php"><i class="fa fa-file"></i> <span>Summary Reports</span></a></li>
            <li class="header">VIEW</li>
            <li><a href="attendance.php"><i class="fa fa-calendar"></i> <span>Biologs</span></a></li>
            <li><a href="teaching_load_view.php"><i class="fa fa-clock-o"></i> <span>Schedule</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
