<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
        <div class="box-body">
          <form action="<?php echo base_url();?>transaction/stockopname/update-periode" method="post">
                <input type="hidden" class="form-control" id="id_so" name="id_so" value="<?php echo $id_so;?>" readonly>
            <div class="form-group">
              <label>Name</label>
                <input type="text" class="form-control" id="so_name" name="so_name" value="<?php echo $so_name;?>" readonly>
            </div><!-- /.form group -->
            <div class="form-group">
              <label>Start Date</label>
                <input type="text" class="form-control" id="start_date" name="start_date" value="<?php echo $so_start_date;?>" readonly>
            </div><!-- /.form group -->
            <div class="form-group">
              <label>End Date</label>
                <input type="text" class="form-control" id="end_date" name="end_date" value="<?php echo $so_end_date;?>" readonly>
            </div><!-- /.form group -->
            <div class="form-group">
              <label>Note</label>
                <input type="text" class="form-control" name="so_note" id="so_note" value="<?php echo $so_note;?>" readonly>
            </div><!-- /.form group -->
            <div class="form-group">
              <label>Location</label>
                <select class="form-control select2" id="location_id" name="location_id" style="width: 100%;">
                  <option value="<?php echo $so_location; ?>"><?php echo $name;?></option>
                </select>
            </div><!-- /.form-group -->
            <div class="form-group">
              <label>Status</label>
                <select class="form-control select2" id="so_status" name="so_status" style="width: 100%;">
                  <option>Select Status</option>
                  <option value="0">Active</option>
                  <option value="1">Closed</option>
                  <option value="2">Posted</option>
                  <option value="3">Canceled</option>
                </select>
            </div><!-- /.form-group --> 
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm pull-right"><i class="fa fa-save"></i> Save</button>
              <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-warning btn-sm pull-left"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
          </form>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col (left) -->
</div>