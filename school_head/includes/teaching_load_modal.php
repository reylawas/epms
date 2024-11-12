<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Teaching Load Form</b></h4>
          	</div>
          	<div class="modal-body">
              <form class="form-horizontal" method="POST" action="teaching_load_add.php">
                    <div class="form-group">
                        <label for="employee" class="col-sm-3 control-label">Employee ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="employee" name="employee" required placeholder="Enter Employee ID">
                        </div>
                    </div>
                    <div class="form-group">
                  	<label for="time_in" class="col-sm-3 control-label">Time In</label>

                  	<div class="col-sm-9">
                  		<div class="bootstrap-timepicker">
                    		<input type="text" class="form-control timepicker" id="time_in" name="time_in">
                    	</div>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="time_out" class="col-sm-3 control-label">Time Out</label>

                  	<div class="col-sm-9">
                  		<div class="bootstrap-timepicker">
                    		<input type="text" class="form-control timepicker" id="time_out" name="time_out">
                    	</div>
                  	</div>
                </div>

                    <!-- Days of the week -->
                    <div class="form-group">
                        <label for="monday" class="col-sm-3 control-label">Monday</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="monday" name="monday" placeholder="Enter subject(s)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tuesday" class="col-sm-3 control-label">Tuesday</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="tuesday" name="tuesday" placeholder="Enter subject(s)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="wednesday" class="col-sm-3 control-label">Wednesday</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="wednesday" name="wednesday" placeholder="Enter subject(s)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="thursday" class="col-sm-3 control-label">Thursday</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="thursday" name="thursday" placeholder="Enter subject(s)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="friday" class="col-sm-3 control-label">Friday</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="friday" name="friday" placeholder="Enter subject(s)">
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
<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Edit Teaching Load</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="teaching_load_edit.php">
                    <input type="hidden" id="edit_id" name="edit_id"> <!-- Hidden field to store the teaching load ID -->

                    <div class="form-group">
                        <label for="edit_employee" class="col-sm-3 control-label">Employee ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_employee" name="employee" required placeholder="Enter Employee ID">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_time_in" class="col-sm-3 control-label">Time In</label>
                        <div class="col-sm-9">
                            <input type="time" class="form-control" id="edit_time_in" name="time_in" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_time_out" class="col-sm-3 control-label">Time Out</label>
                        <div class="col-sm-9">
                            <input type="time" class="form-control" id="edit_time_out" name="time_out" required>
                        </div>
                    </div>

                    <!-- Days of the week -->
                    <div class="form-group">
                        <label for="edit_monday" class="col-sm-3 control-label">Monday</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_monday" name="monday" placeholder="Enter subject(s)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_tuesday" class="col-sm-3 control-label">Tuesday</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_tuesday" name="tuesday" placeholder="Enter subject(s)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_wednesday" class="col-sm-3 control-label">Wednesday</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_wednesday" name="wednesday" placeholder="Enter subject(s)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_thursday" class="col-sm-3 control-label">Thursday</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_thursday" name="thursday" placeholder="Enter subject(s)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_friday" class="col-sm-3 control-label">Friday</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_friday" name="friday" placeholder="Enter subject(s)">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-primary btn-flat" name="edit"><i class="fa fa-save"></i> Save Changes</button>
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
            	<h4 class="modal-title"><b><span class="edit_id"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="teaching_load_delete.php">
            		<input type="hidden" class="edit_employee" name="id">
            		<div class="text-center">
	                	<p>DELETE TEACHING LOAD</p>
	                	<h2 class="bold del_employee_name"></h2>
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