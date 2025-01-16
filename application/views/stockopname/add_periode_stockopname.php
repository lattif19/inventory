<div class="row">
	<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Input Stock Opname</h3>
        </div>
        <div class="box-body">
          <form action="<?php echo base_url();?>transaction/stockopname/save_periode" method="post">
            <div class="form-group">
              <label>Name</label>
                <input type="text" class="form-control" id="so_name" name="so_name">
            </div><!-- /.form group -->
            <div class="form-group">
              <label>Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date">
            </div><!-- /.form group -->
            <div class="form-group">
              <label>End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date">
            </div><!-- /.form group -->
            <div class="form-group">
              <label>Note</label>
                <textarea class="form-control" name="so_note" id="so_note"></textarea>
            </div><!-- /.form group -->
            <div class="form-group">
              <label>Location</label>
                <select class="form-control select2" id="location_id" name="location_id" style="width: 100%;">
                <?php foreach ($location as $row) : ?>
                  <option value="<?php echo $row->location_id; ?>">
                    <?php echo $row->name; ?>
                  </option>
                <?php endforeach; ?>
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