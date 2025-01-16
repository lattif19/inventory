<div class="box box-default">
  <div class="box-header with-border">
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th>TRX Adjustment :</th>
              <th><?php echo $trx_code; ?></th>
            </tr>
          </thead>
          <thead>
            <tr>
              <th>Date :</th>
              <td><?php echo $trx_timestamp; ?></td>
            </tr>
          </thead>
          <thead>
            <tr>
              <th>Name :</th>
              <td><?php echo $enterby; ?></td>
            </tr>
          </thead>
          <thead>
            <tr>
              <th>IP Address :</th>
              <td><?php echo $ip_address; ?></td>
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
      <table class="table no-margin" id="detail_adjustment">
        <thead>
          <tr>
            <th>Item Number</th>
            <th>Description</th>
            <th>Commodity</th>
             <th>Condition Code</th>
             <th>Issue Unit</th>
            <th>Qty System</th>
            <th>Qty Physical</th>
            <th>Qty Adjustment</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($itemAdj as $key => $value) { ?>
          <tr>
            <td><?= $value->item_number; ?></td>
            <td><?= $value->DESCRIPTION; ?></td>
            <td><?= $value->COMMODITYGROUP; ?></td>
            <td><?= $value->condition_code; ?></td>
            <td><?= $value->issueunit; ?></td>
            <td><?= $value->system_qty; ?></td>
            <td><?= $value->actual_qty; ?></td>
            <td><?= $value->adjustment_qty; ?></td>
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
    var table = $('#detail_adjustment').DataTable();
    
    $('#detail_adjustment tbody').on( 'click', 'tr', function () {
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