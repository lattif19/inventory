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
              <th>WO Number :</th>
              <td><?php echo $wonum; ?></td>
            </tr>
          </thead>
          <thead>
            <tr>
              <th>Name :</th>
              <td><?php echo $enterby; ?></td>
              <th>WO Detail :</th>
              <td><?php echo $desc; ?></td>
            </tr>
          </thead>
          <thead>
            <tr>
              <th>IP Address :</th>
              <td><?php echo $ipaddress; ?></td>
              <th>WO Date :</th>
              <td><?php echo $date; ?></td>
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
        <table class="table no-margin" id="detail_warehouse">
          <thead>
            <tr>
              <th>Item Number</th>
              <th>Description</th>
              <th>Qty</th>
              <th>Condition Code</th>
              <th>Status</th>
              <th>Location</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($dataItem as $row) { ?>
            <tr>
              <td><?php echo $row->item_number; ?></td>
              <td><?php echo $row->DESCRIPTION; ?></td>
              <td><?php echo $row->returnqty; ?></td>
              <td><?php echo $row->conditioncode; ?></td>
              <td>
              <?php if ($row->export_status == 1) {
                     echo "<span class='label label-success'>Complete</span>";
                  } else{
                    echo "<span class='label label-warning'>Not Exported</span>";
              } ?>
              </td>
              <td><?php echo $row->name; ?></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div><!-- /.table-responsive -->
    </div><!-- /.box-body -->
    <div class="box-footer">
      <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-warning btn-sm pull-left"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
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