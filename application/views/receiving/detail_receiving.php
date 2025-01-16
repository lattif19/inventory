<div class="box box-default">
  <div class="box-header with-border">
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
      <?php if($this->uri->segment(5)=="success"){?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i>Saved!</h4>
            Success save Transaction as Complete.
        </div>
      <?php } ?>

        <table class="table table-bordered">
          <thead>
            <tr>
              <th>TRX Code :</th>
              <th><?php echo $trx_code; ?></th>
              <th>Shipper ID :</th>
              <td><?php echo $shipper_barcode; ?> - <?php echo $shipper; ?> - <?php echo $company; ?></td>
            </tr>
          </thead>
          <thead>
            <tr>
              <th>Company :</th>
              <td><?php echo "<strong>$company</strong>"; ?></td>
              <th>Transaction Date :</th>
              <td><?php echo $trx_timestamp; ?></td>
            </tr>
          </thead>
          <thead>
            <tr>
              <th>Enter By :</th>
              <td><?php echo $enterby; ?></td>
              <th>IP Address :</th>
              <td><?php echo $ipaddress; ?></td>
            </tr>
          </thead>
<!--           <thead>
            <tr>
              <th>IP Address :</th>
              <td><?php echo $ipaddress; ?></td>
              <th>PO Date :</th>
              <td>
                <?php if ($ponum) {
                  echo $date;
                } else {

                }
                ?>
                <?php if ($trx_status == '1') {
                   echo "<span class='label label-success'>Complete</span>";
                } elseif ($trx_status == '0') {
                  echo "<span class='label label-warning'>Not Complete</span>";
                } ?> 
              </td>
            </tr>
          </thead> -->
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
                <th>PO Number</th>
                <th>Export Status</th>
                <th>Time Transaction</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($dataItem as $row) { ?>
              <tr>
                <td><?php echo $row->item_number; ?></td>
                <td><?php echo $row->desc_detail; ?></td>
                <td><?php echo $row->receivedqty; ?></td>
                <td><?php echo $row->name; ?></td>
                <td><?php echo $row->ponum  ; ?></td>
                <td>
                 <?php if ($row->export_status == 1) {
                         echo "<span class='label label-success'>Complete</span>";
                      } else{
                        echo "<span class='label label-warning'>Not Exported</span>";
                  } ?>

                </td>
                <td><?php echo $row->timestamp; ?></td>
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