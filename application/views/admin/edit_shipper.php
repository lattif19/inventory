<div class="row">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-body">
        <!-- Date dd/mm/yyyy -->
        <form action="<?php echo base_url(); ?>admin/shipper-update" method="POST" enctype="multipart/form-data" accept-charset="utf-8">  
          <?php foreach ($dataShipper as $row) : ?>
          <input type="hidden" id="shipper_id" name="shipper_id" value="<?php echo $row->shipper_id ;?>" class="form-control" >
          <div class="form-group">
            <label>Nama:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <input type="text" id="name" name="name" value="<?php echo $row->name ;?>" class="form-control">
            </div><!-- /.input group -->
          </div><!-- /.form group -->

          <!-- Date mm/dd/yyyy -->
          <div class="form-group">
            <label>Handphone:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-phone"></i>
              </div>
              <input type="text" id="phone" name="phone" value="<?php echo $row->phone ;?>" class="form-control"  data-inputmask='"mask": "(999) 999-9999"' data-mask>
            </div><!-- /.input group -->
          </div><!-- /.form group -->

          <!-- phone mask -->
          <div class="form-group">
            <label>Gender :</label>
            <select class="form-control select2" id="gender" name="gender" style="width: 100%;">
                <option>Gender</option>
                <option value="L">Male</option>
                <option value="P">Female</option>
              </select>
          </div><!-- /.form group -->

          <!-- phone mask -->
          <div class="form-group">
            <label>Shipper Type</label>
              <select class="form-control select2" id="type" name="type" value="" style="width: 100%;">
                <option>Show All</option>
                <option value="1">Internal</option>
                <option value="2">External</option>
              </select>
          </div><!-- /.form group -->

          <!-- IP mask -->
          <div class="form-group">
            <label>Company Name</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-laptop"></i>
              </div>
              <div class="row">
                <div class="col-md-10">
                <?php foreach ($company as $data){ ?>
                  <input type="text" class="form-control" name="company_id" id="company_id" value="<?php echo $data->COMPANY; ?>" placeholder="<?php echo $data->NAME; ?>" readonly="" />
                </div>
                <div class="col-md-2">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" disabled>. . .</button>
                </div>
              </div>
            </div><!-- /.input group -->
          </div><!-- /.form group -->

          <!-- IP mask -->
          <div class="form-group">
            <label>Office Phone</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-laptop"></i>
              </div>
              <input type="text" class="form-control" value="<?php echo $data->PHONE; ?>" readonly="">
            </div><!-- /.input group -->
            <?php } ?>
          </div><!-- /.form group -->

          <div class="form-group">
            <label>Shipper Photo</label>
              <img class='img-responsive' src='<?php echo base_url(); ?>assets/uploads/shipper/<?php echo $row->shipper_photo; ?>' alt='Photo' style="
    margin-left: 200px;>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-file"></i>
              </div>
              <input type="file" name="filefoto" class="form-control">
            </div><!-- /.input group -->

            <!-- <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-file"></i>
              </div>
              <input type="file" name="filefoto" class="form-control">
            </div><!- /.input group -->
          <?php endforeach;?>
          </div><!-- /.form group -->
          <button type="submit" class="btn btn-primary btn-sm pull-right"><i class="fa fa-save"></i> Save</button>
        </form>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
  <div class="col-md-6">
  
</div><!-- /.col -->
</div><!-- /.box -->

  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- konten modal-->
      <div class="modal-content">
        <!-- heading modal -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">List Company</h4>
        </div>
        <!-- body modal -->
        <div class="modal-body">
          <table id="companyid" class="table table-bordered table-hover table-striped">
            <thead>
              <tr>
                <th>Company Name</th>
                <th>Phone</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($tableCompany->result() as $row) { ?>
              <tr class="pilih" data-company="<?php echo $row->COMPANY; ?>" data-phone="<?php echo $row->PHONE; ?>">
                <td><?php echo $row->NAME; ?></td>
                <td><?php echo $row->PHONE; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- footer modal -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Modal</button>
        </div>
      </div>
    </div>
  </div>



<script type="text/javascript">
  //jika dipilih, vendor akan masuk ke input dan modal di tutup
    $(document).on('click', '.pilih', function (e) {
        document.getElementById("company").value = $(this).attr('data-company');
        document.getElementById("officephone").value = $(this).attr('data-phone');
        $('#myModal').modal('hide');
    });

    $(document).ready(function() {
        $('#companyid').DataTable();
    } );

</script>

