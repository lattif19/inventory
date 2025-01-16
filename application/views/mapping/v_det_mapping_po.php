<div class="box box-default">
  <div class="box-header with-border">
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th>TRX Code :</th>
              <th><?php echo $trx_code; ?></th>
              <th>Shipper ID :</th>
              <td><?php echo $shipper; ?></td>
            </tr>
          </thead>
          <thead>
            <tr>
              <th>Date :</th>
              <td><?php echo $trx_timestamp; ?></td>
              <th>PO Number :</th>
              <td>
              <?php
                if ($ponum) {
                  echo $ponum;
                 } else {
                  echo '<input type="text" class="form-control" placeholder="PO Number">';
                }
              ?>
              </td>
            </tr>
          </thead>
          <thead>
            <tr>
              <th>Name :</th>
              <td><?php echo $enterby; ?></td>
              <th>PO Detail :</th>
              <td>
              </td>
            </tr>
          </thead>
          <thead>
            <tr>
              <th>IP Address :</th>
              <td><?php echo $ipaddress; ?></td>
              <th>PO Date :</th>
              <td>
              </td>
            </tr>
          </thead>
        </table>
      </div>
    </div><!-- /.row -->
  </div><!-- /.box-body -->
</div><!-- /.box -->

<div class="box box-info">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table no-margin" id="detail_receiving">
        <thead>
          <tr>
            <th>Item Number</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Location</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($dataItem as $row) { ?>
          <tr>
            <td><?php echo $row->item_number; ?></td>
            <td><?php echo $row->DESCRIPTION; ?></td>
            <td><?php echo $row->orderqty; ?></td>
            <td><?php echo $row->name; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div><!-- /.table-responsive -->
    <div class="box-footer">
      <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-warning btn-sm pull-left"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  </div><!-- /.box-body -->
</div><!-- /.box -->
<script>
  $(document).ready(function() {
    var table = $('#detail_receiving').DataTable();
       
    $('#detail_receiving tbody').on( 'click', 'tr', function () {
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