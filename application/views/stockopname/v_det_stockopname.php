<?php 
      $info = $this->session->flashdata('info'); 
      if(!empty($info)){    
      ?>
      <div class="alert alert-block alert-danger">
        <button type="button" class="close" data-dismiss="alert">
          <i class="ace-icon fa fa-times"></i>
        </button>

        <i class="ace-icon fa fa-check green"></i>
          <strong class="green">
            <?php echo $info; ?>
          </strong>
      </div>

      <?php
      }
      ?>
<div class="box box-default">
  <div class="box-header with-border">
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th>TRX SO Code :</th>
              <th><?php echo $trx_so_code; ?></th>
              <td></td>
            </tr>
          </thead>
          <thead>
            <tr>
              <th>Date :</th>
              <td><?php echo $trx_so_date; ?></td>
            </tr>
          </thead>
          <thead>
            <tr>
              <th>Name :</th>
              <td><?php echo $trx_so_user; ?></td>
            </tr>
          </thead>
        </table>
      </div>
    </div><!-- /.row -->
  </div><!-- /.box-body -->
</div><!-- /.box -->

    <div class="box box-info">
      <div class="box-header">
        <a href="<?php echo base_url(); ?>transaction/stockopname/download-detail-stockopname/<?php echo $trx_so_id; ?>" class="btn btn-success"><i class="fa fa-download"></i></a>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin" id="detail_periode">
            <thead>
              <tr>
                <th>Item Number</th>
                <th>Description</th>
                <th>Commodity</th>
                <th>Condition Code</th>
                <th>Qty</th>
                <th>Name</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($itemSO as $row) { ?>
              <tr>
                <td>
                  <?php echo $row->item_number; ?>  
                </td>
                <td><?php echo $row->DESCRIPTION; ?></td>
                <td><?php echo $row->COMMODITYGROUP; ?></td>
                <td><?php echo $row->condition_code; ?></td>
                <td><?php echo $row->qty; ?></td>
                <td><?php echo $row->trx_so_user; ?></td>
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
    var table = $('#detail_periode').DataTable();
       
    $('#detail_periode tbody').on( 'click', 'tr', function () {
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