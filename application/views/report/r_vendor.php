<div class="box">
  <div class="box-header">
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table id="r_vendor" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Transaction Number</th>
            <th>PO</th>
            <th>Name</th>
            <th>Note</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($reportVendor as $key => $value) { ?>
          <tr>
            <td><?= $value->trx_timestamp ?></td>
            <td><?= $value->trx_code ?></td>
            <td><?= $value->ponum ?></td>
            <td><?= $value->enterby ?></td>
            <td><?= $value->note ?></td>
            <td>
              <!-- <a href="<?php echo base_url();?>report/reportvendor/<?= $value->trx_id ?>" class="btn btn-success btn-sm"><i class="fa fa-download"></i> -->
              <a href="<?php echo base_url();?>report/detail-report-vendor/<?= $value->trx_id ?>" class="btn btn-success btn-sm"><i class="fa fa-download"></i>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box-body -->
  <script>
     $(document).ready(function() {
          var table = $('#r_vendor').DataTable();
       
          $('#r_vendor tbody').on( 'click', 'tr', function () {
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
