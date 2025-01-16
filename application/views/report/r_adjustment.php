<div class="box">
  <div class="box-header">
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table id="r_compare" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Transaction Number</th>
            <th>Warehouse</th>
            <th>Type</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($reportAdj as $key => $value) { ?>
          <tr>
            <td><?= $value->trx_timestamp ?></td>
            <td><?= $value->trx_code ?></td>
            <td><?= $value->name ?></td>
            <td>
              <?php
                if ($value->type == 2) {
                    echo "Automatic";
                  } else {
                    echo "Manual";
                  }
              ?>
            </td>
            <td>
              <a href="<?php echo base_url();?>report/detail-report-adjustment/<?= $value->trx_id ?>" class="btn btn-success btn-sm"><i class="fa fa-download"></i>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box-body -->
  <script>
     $(document).ready(function() {
          var table = $('#r_compare').DataTable();
       
          $('#r_compare tbody').on( 'click', 'tr', function () {
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
