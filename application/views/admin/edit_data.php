<div class="row">
<!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
    </div><!-- /.box-header -->
    <!-- form start -->
      <form role="form" action="<?php echo base_url(); ?>index.php/admin/update" method="post">
        <div class="box-body">
        <?php foreach ($data as $key => $value) { ?>
            <input type="hidden"  class="form-control" id="id" name="id" value="<?= $value->user_id ?>" >
            <div class="form-group">
              <label for="exampleInputEmail1">Nama</label>
              <input type="text" class="form-control" id="nama" name="displayname" value="<?= $value->displayname ?>" >
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Employe Type</label>
              <input type="text" class="form-control" id="employetype" name="employetype" value="<?= $value->employetype ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="<?= $value->email ?>" >
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Location</label>
              <input type="text" class="form-control" id="location" name="location" value="<?= $value->location_site ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Status Date</label>
              <input type="text" class="form-control" id="status_date" name="status_date" value="<?= $value->status_date ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Status</label>
              <select name="status" id="status" class="form-control select2" style="width: 100%;">
                <option value="Active">Active</option>
                <option value="Non Active">Non Active</option>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Username</label>
              <input type="text" class="form-control" id="username" name="username"  value="<?= $value->username ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="text" class="form-control" id="password" name="password" placeholder="Please Insert Your Password">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Level</label>
              <select name="level" id="level" class="form-control select2" style="width: 100%;">
                <option value="0">Admin</option>
                <option value="1">User</option>
              </select>
            </div>
            <?php } ?>
          </div><!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div><!-- /.box -->
    </div><!--/.col (left) -->
            <!-- right column -->
</div><!--/.col (right) -->
</div>   <!-- /.row -->