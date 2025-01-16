<div class="box">
  <div class="box-header">
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table id="r_stockopname" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Stock Opname Number</th>
            <th>Location</th>
            <th>Type</th>
            <th>File</th>
            <th>Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($reportStockopname as $key => $value) { ?>
          <tr>
            <td><?= $value->trx_so_date ?></td>
            <td><?= $value->trx_so_code ?></td>
            <td><?= $value->location_id ?></td>
            <td><?= $value->trx_so_type ?></td>
            <td><?= $value->trx_so_file ?></td>
            <td><?= $value->so_name ?></td>
            <td>
              <a href="<?php echo base_url();?>report/reportstockopname/<?= $value->trx_so_id ?>" class="btn btn-success btn-sm"><i class="fa fa-download"></i>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box-body -->
  <script>
     $(document).ready(function() {
          var table = $('#r_stockopname').DataTable();
       
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
