<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>assets/uploads/shipper/<?php echo $foto; ?>" alt="User profile picture">
            <h3 class="profile-username text-center"><?php echo $name1; ?></h3>
            <p class="text-muted text-center"><?php echo $shipper_barcode ?></p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Name</b> <b class="pull-right"><?php echo $name; ?></b>
              </li>
              <li class="list-group-item">
                <b>Gender</b> <b class="pull-right"><?php echo $gender; ?></b>
              </li>
              <li class="list-group-item">
                <b>Office Phone</b> <b class="pull-right"><?php echo $PHONE; ?></b>
              </li>
              <li class="list-group-item">
                <b>Handhone</b> <b class="pull-right"><?php echo $phone; ?></b>
              </li>
              <li class="list-group-item">
                <b>Shipper Type</b> <b class="pull-right"><?php echo $type;?></b>
              </li>
            </ul>
            <a href="<?php echo base_url(); ?>admin/shipper" class="btn btn-warning btn-block"><i class="fa fa-arrow-left"></i> <b>Back</b></a>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
	</div>
</div>