<div class="box box-info">
    <div class="box-body">
      <div class="table-responsive">
        <table class="table no-margin" id="detail_warehouse">
          <thead>
          <tr>
            <th>Date</th>
            <th>Receiving Number</th>
            <th>Receive Qty</th>
            <th>Name</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($dataPO as $row) { ?>
            <tr>
              <td><?php echo $row->trx_timestamp; ?></td>
              <td><?php echo $row->trx_code; ?></td>
              <td><?php echo $row->enterby; ?></td>
              <td><?php echo $row->orderqty; ?></td>
              <td>
                <a href="<?php echo base_url();?>transaction/mapping-po/detail-po/<?php echo $row->trx_id; ?>" class="btn btn-info btn-sm"><i class="fa fa-info"> Detail</i></a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div><!-- /.table-responsive -->
    </div><!-- /.box-body -->
   <!--  <div class="box-footer">
      <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-warning btn-sm pull-left"><i class="fa fa-arrow-left"></i> Back</a>
    </div> -->
  </div><!-- /.box -->
<script>
  $(document).ready(function() {
    var table = $('#detail_warehouse').DataTable();
    $('#detail_warehouse tbody').on( 'click', 'tr', function () {
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
