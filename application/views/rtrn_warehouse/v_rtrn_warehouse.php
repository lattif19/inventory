<div class="box">
  <div class="box-header">
  <a href="<?php echo base_url(); ?>transaction/rtrn_warehouse/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
  <!-- <a href="" class="btn btn-default btn-sm"><i class="fa fa-print"></i></a> -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <table id="return_warehouse" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Date</th>
          <th>Transacion Number</th>
          <th>Name</th>
          <th>WO Number</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($dataWO->result() as $key => $value) { ?>
        <tr>
          <td><?= $value->trx_timestamp ?></td>
          <td><?= $value->trx_code ?></td>
          <td><?= $value->enterby ?></td>
          <td><?= $value->wonum ?></td>
          <td>
            <a href="<?php echo base_url(); ?>transaction/rtrn_warehouse/detail/<?= $value->trx_id ?>" class="btn btn-info btn-sm"><i class="fa fa-info"></i> Detail</a>
              <a href="#" onclick="myFunctionPrint('<?= $value->trx_id ?>')"  class="btn btn-warning btn-sm"><i class="fa fa-info"> Print</i></a>
          </td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div><!-- /.box -->

<script>
    myFunctionPrint=function(trxId){
        // var qtyPrint = prompt('Please enter Qty','10');
        // if (qtyPrint != null && qtyPrint != "") {
          var url = '<?php echo base_url(); ?>report/print_rtrn_warehouse/'+trxId;
          var W = window.open(url);
        // }
    }
   </script>
<script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#return_warehouse tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#return_warehouse').DataTable({
      "order":[[1,"desc"]],
      "state_saving":true
    });
} );
</script>

<!-- <script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js"></script>
 
<script type="text/javascript">
    $(document).ready(function() {
        $('#FlagsExport').DataTable({
            "pageLength": 50,
            dom: 'Bfrtip',
            buttons: ['copy','csv','excel','pdf','print']
        });
    });
</script>
           -->    