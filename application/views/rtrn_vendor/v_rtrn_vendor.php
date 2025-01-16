<div class="box">
  <div class="box-header">
    <a href="<?php echo base_url(); ?>transaction/rtrn_vendor/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
    <!-- <a href="" class="btn btn-default btn-sm"><i class="fa fa-print"></i></a> -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <table id="vendor" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Date</th>
          <th>Transaction</th>
          <th>Name</th>
          <th>PO Number</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($dataRtrnVendor->result() as $row) : ?>
        <tr>
          <td><?php echo $row->trx_timestamp; ?></td>
          <td><?php echo $row->trx_code; ?></td>
          <td><?php echo $row->enterby; ?></td>
          <td><?php echo $row->ponum; ?></td>
          <td>
            <a href="<?php echo base_url(); ?>transaction/rtrn_vendor/detail/<?php echo $row->trx_id; ?>" class="btn btn-info btn-sm"><i class="fa fa-info"></i> Detail</a>
              <a href="#" onclick="printTransaction('<?= $row->trx_id ?>')"  class="btn btn-warning btn-sm"><i class="fa fa-info"> Print</i></a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div><!-- /.box-body -->
</div><!-- /.box -->

<script>

   var doPrintPage;
    function printTransaction(trxId){
        var url = '<?php echo base_url(); ?>report/print_rtrn_vendor/'+trxId;
        var W = window.open(url);
    }
  $(document).ready(function() {
    // DataTable
    var table = $('#vendor').DataTable({
      "stateSaving" : true,
      "order":[[1,"desc"]]
    });

    $(document).ready(function(){
      $('input').blur(function(){
        //3sec after the user leaves the input, printPage will fire
        doPrintPage = setTimeout('printTransaction();', 3000);
      });
      $('input').focus(function(){
        //But if another input gains focus printPage won't fire
        clearTimeout(doPrintPage);
      });
    });
} );
</script>       