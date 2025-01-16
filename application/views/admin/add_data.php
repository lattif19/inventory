<div class="row">
<!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
    </div><!-- /.box-header -->
    <!-- form start -->
      <form role="form" action="<?php echo base_url(); ?>index.php/admin/save" method="post" enctype="multipart/form-data">
        <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Nama</label>
              <input type="text" class="form-control" id="nama" name="displayname" placeholder="Please Insert Your Name">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Employe Type</label>
              <input type="text" class="form-control" id="employetype" name="employetype" placeholder="Please Insert Employe Type">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Please Insert Your Email">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Location</label>
              <input type="text" class="form-control" id="location" name="location" placeholder="Please Insert Your Location">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Status Date</label>
              <input type="date" class="form-control" id="status_date" name="status_date" placeholder="Please Insert Date">
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
              <input type="text" class="form-control" id="username" name="username" placeholder="Please Insert Your Username">
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
            <div class="box-footer">
            	<button type="submit" class="btn btn-primary">Submit</button>
          	</div>
          </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col (left) -->