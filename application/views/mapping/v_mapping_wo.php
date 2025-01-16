<div class="box">
  <div class="box-header">
  <!-- <a href="" class="btn btn-default btn-sm"><i class="fa fa-print"></i></a> -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table id="mappingWO" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Receiving Number</th>
            <th>Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($dataWO as $row) { ?>
          <tr>
            <td><?php echo $row->trx_timestamp; ?></td>
            <td><?php echo $row->trx_code; ?></td>
            <td><?php echo $row->enterby; ?></td>
            <td>
              <a href="<?php echo base_url(); ?>transaction/mapping-wo/detail-wo/<?php echo $row->trx_id; ?>" class="btn btn-info btn-sm"><i class="fa fa-info"> Detail</i></a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div><!-- /.table-resWOnsive -->
    <!-- <div class="box-footer">
      <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-warning btn-sm pull-left"><i class="fa fa-arrow-left"></i> Back</a>
    </div> -->
  </div><!-- /.box-body -->
</div><!-- /.box -->
<script>
  $(document).ready(function() {
    var table = $('#mappingWO').DataTable();
       
    $('#mappingWO tbody').on( 'click', 'tr', function () {
      if ( $(this).hasClass('selected') ) {
        $(this).removeClass('selected');
      } else {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
      }
    } );
       
    $('#button').click( function () {
      table.row('.selected').remove().draw( false );
    } );
  } );
</script>