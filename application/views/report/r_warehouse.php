<div class="box">
  <div class="box-header">
    <a href="<?php echo base_url();?>transaction/rtrn-warehouse/download-rtrn-warehouse" class="btn btn-primary pull-right">
      <i class="fa fa-download"></i>
      Download
    </a>
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table id="r_warehouse" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Transaction Number</th>
            <th>WO</th>
            <th>Name</th>
            <th>Note</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($reportWarehouse as $key => $value) { ?>
          <tr>
            <td><?= $value->trx_timestamp ?></td>
            <td><?= $value->trx_code ?></td>
            <td><?= $value->wonum ?></td>
            <td><?= $value->enterby ?></td>
            <td><?= $value->note ?></td>
            <td>
              <a href="<?php echo base_url();?>report/reportwarehouse/<?= $value->trx_id ?>" class="btn btn-success btn-sm"><i class="fa fa-download"></i>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box-body -->
  <script>
     $(document).ready(function() {
          var table = $('#r_warehouse').DataTable();
       
          $('#r_warehouse tbody').on( 'click', 'tr', function () {
              if ( $(this).hasClass('selected') ) {
                  $(this).removeClass('selected');
              }
              else {
                  table.$('tr.selected').removeClass('selected');
                  $(this).addClass('selected');
              }
          } );
       
          $('#button').click( function () {
              table.row('.selected').remove().draw( false );
          } );
      } );
      </script>         
</div><!-- /.box -->
