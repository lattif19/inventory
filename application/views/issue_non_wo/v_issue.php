<?php if($this->uri->segment(4)=="success"){?>
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i>Saved!</h4>
    Success save Transaction as Complete.
  </div>
<?php } ?>
 <div class="box box-info">
   <div class="box-header with-border">
    <a href="<?php echo base_url(); ?>transaction/issue_non_wo/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
   </div><!-- /.box-header -->
   <div class="box-body">
     <div class="table-responsive">
       <table id="issue" class="table table-bordered table-striped">
         <thead>
           <tr>
             <th>Date</th>
             <th>Transaction Number</th>
             <th>Issue By</th>
             <th>Issue To</th>
             <th>Item Number</th>
             <th>Qty</th>
             <th>Action</th>
           </tr>
         </thead>
         <tbody>
         <?php foreach ($query->result() as $row => $value) {?>
         <tr>
           <td><?= $value->trx_timestamp ?></td>
           <td><?= $value->trx_code ?></td>
           <td><?= $value->enterby ?></td>
           <td><?= $value->issueto ?></td>
           <td><?= $value->item_number ?></td>
           <td><?php
           if ($value->issuedqty < "1000000") {
             echo $value->issuedqty;
           } else {
             echo "";
           }
           ?>
             
           </td>
           <td>
             <a href="<?php echo base_url();?>transaction/issue_non_wo/detail/<?= $value->trx_detail_id ?>" class="btn btn-info btn-sm"><i class="fa fa-info"> Detail</i></a>
             <a href="#" onclick="myFunctionPrint('<?= $value->trx_id ?>')" class="btn btn-warning btn-sm"><i class="fa fa-print"> Print</i></a>
           </td>
         </tr>
         <?php } ?>
         </tbody>
      </table>
    </div><!-- /.table-responsive -->
  </div><!-- /.box-body --> 
  <!-- <div class="box-footer">
    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-warning btn-sm pull-left"><i class="fa fa-arrow-left"></i> Back</a>
  </div> -->
</div><!-- /.box -->
<script>
    myFunctionPrint=function(trxId){
        // var qtyPrint = prompt('Please enter Qty','10');
        // if (qtyPrint != null && qtyPrint != "") {
          var url = '<?php echo base_url(); ?>report/print-issue/'+trxId;
          var W = window.open(url);
        // }
    }
   </script>
<script>
  $(document).ready(function() {
 
    // DataTable
    $('#issue').DataTable({
       stateSave: true,
       order: [[ 0, "desc" ]]
    });
 
} );
</script>
<script src="//code.jquery.com/jquery-1.12.4.js" type="text/javascript" charset="utf-8" async defer></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" type="text/javascript" charset="utf-8" async defer></script>