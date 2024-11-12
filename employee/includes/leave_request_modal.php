<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Leave Request Form</b></h4>
          	</div>
          	<div class="modal-body">
			  <form class="form-horizontal" method="POST" action="leave_add.php">
          		  <div class="form-group">
                  	<label for="employee" class="col-sm-3 control-label">Employee ID</label>
                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="employee" name="employee" readonly>
                  	</div>
                </div>
                <div class="form-group">
  <label for="datepicker_add" class="col-sm-3 control-label">Date</label>
  <div class="col-sm-9"> 
    <div class="date">
      <input type="text" class="form-control" id="datepicker_add" name="date" required>
      <input type="hidden" id="date_from" name="date_from">
      <input type="hidden" id="date_to" name="date_to">
    </div>
  </div>
</div>
                <div class="form-group">
                  	<label for="hours" class="col-sm-3 control-label">Type of Leave</label>

                  	<div class="col-sm-9">  
                    <select class="form-control" id="leave_type" name="leave_type">
					<option value="" disabled selected>- Select -</option>
                    <option value="Personal Leave">Personal Leave</option>
                    <option value="Sick Leave">Sick Leave</option>
                    </select>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="mins" class="col-sm-3 control-label">Reason</label>

                  	<div class="col-sm-9">
                      <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Enter reason for leave"></textarea>
                  	</div>
                </div>
				<div class="form-group hidden-status">
                  	<label for="hours" class="col-sm-3 control-label">Status</label>

                  	<div class="col-sm-9">  
                    <select class="form-control" id="status" name="status">
                    <option value="Pending">Pending</option>
                    </select>
                  	</div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<style>
.hidden-status {
    display: none;
}
</style>


<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b><span class="employee_name"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="overtime_edit.php">
            		<input type="hidden" class="otid" name="id">
                 <div class="form-group">
                    <label for="rate_edit" class="col-sm-3 control-label">Tools</label>

                    <div class="col-sm-9">
					<select class="form-control" id="leave_type" name="leave_type">
                    <option value="Approved">Approved</option>
                    <option value="Decline">Declined</option>
                    </select>
                    </div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b><span id="overtime_date"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="overtime_delete.php">
            		<input type="hidden" class="otid" name="id">
            		<div class="text-center">
	                	<p>DELETE OVERTIME</p>
	                	<h2 class="employee_name bold"></h2>
	            	</div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
            	</form>
          	</div>
        </div>
    </div>
</div>


     