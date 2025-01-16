<div class="box">
  <div class="box-header">
  <!-- <a href="<?php echo base_url(); ?>transaction/stockopname/add-periode" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a> -->
  <a href="<?php echo base_url();?>transaction/stockopname/upload" class="btn btn-success btn-sm"><i class="fa fa-upload"></i></a>
  </div><!-- /.box-header -->


  <div class="box-body">
    <div class="table-responsive">
      <table id="listStockopname" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>ID SO</th>
            <th>Warehouse</th>
            <th>Person</th>
            <th>Type</th>
            <th>File</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($getStockopname as $row) { ?>
          <tr>
            <td><?php echo $row->trx_so_date; ?></td>
            <td><?php echo $row->id_so; ?></td>
            <td><?php echo $row->name; ?></td>
            <td><?php echo $row->trx_so_user; ?></td>
            <td>
            <?php  
              if ($row->trx_so_type == "0") {
                echo "Import";
              } elseif ($row->trx_so_type = "1") {
                echo "Manual";
              }
            ?>
            </td>
            <td><?php echo $row->trx_so_file; ?></td>
            <td>
              <a href="<?php echo base_url();?>transaction/stockopname/detail-stockopname/<?php echo $row->trx_so_id; ?>" class="btn btn-info btn-sm"><i class="fa fa-info"></i> Detail</a>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
     </div><!-- /.table-responsive -->
    <!-- <div class="box-footer">
      <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-warning btn-sm pull-left"><i class="fa fa-arrow-left"></i> Back</a>
    </div> -->
   </div><!-- /.box-body -->
</div>

<script>
  $(document).ready(function() {
    $('#listStockopname').DataTable({
      stateSaving:true,
      order:[[0. "DESC"]]
    });
       
    
  } );
</script>