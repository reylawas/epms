<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Leave Request Form</b></h4>
          	</div>
          	<div class="modal-body">
			  <form class="form-horizontal" method="POST" action="resolution_center_add.php">
          		  <div class="form-group">
                  	<label for="employee" class="col-sm-3 control-label">Employee ID</label>
                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="employee" name="employee" readonly>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="mins" class="col-sm-3 control-label">Reason</label>

                  	<div class="col-sm-9">
                      <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Enter reason"></textarea>
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