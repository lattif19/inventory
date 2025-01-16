    <?php 
      $info = $this->session->flashdata('info'); 
      if(!empty($info)){    
      ?>
      <div class="alert alert-block alert-success">
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
<div class="box">
  <div class="box-header">
    <a href="<?php echo base_url();?>admin/shipper-add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
  </div><!-- /.box-header -->
  <div class="box-body">
    <table id="shipper" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Shipper Barcode</th>
          <th>Name</th>
          <th>Company Name</th>
          <th>Shipper Type</th>
          <th></th>
       </tr>
      </thead>
      <tbody>
      <?php foreach ($dataShipper as $key => $value) { ?>
        <tr>
          <td><?= $value->shipper_barcode ?></td>
          <td><?= $value->name ?></td>
          <td><?= $value->NAME ?></td>
          <td><?php if ($value->type == "1") { echo "Internal"; } elseif ($value->type == "2") {echo "External"; } ?></td>
          <td>
            <a href="<?php echo base_url();?>admin/shipper-detail/<?= $value->shipper_id ?>" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>
            <a href="<?php echo base_url();?>admin/shipper_edit/<?= $value->shipper_id ?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
            <!-- <a href="<?php echo base_url();?>admin/print_shipper/<?= $value->shipper_barcode  ?>" class="btn btn-success btn-xs"><i class="fa fa-print"></i></a> -->
            <a href="#" onclick="myFunctionPrint('<?= $value->shipper_barcode ?>')" class="btn btn-success btn-xs"><i class="fa fa-print"></i></a>           
            <a href="<?php echo base_url();?>admin/delete-shipper/<?= $value->shipper_id ?>" class="btn btn-danger btn-xs" onClick="return confirm('anda yakin akan menghapus data ini');"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div><!-- /.box-body -->
</div><!-- /.box -->

<script>
    myFunctionPrint=function(shipper_barcode){
        // var qtyPrint = prompt('Please enter Qty','10');
        // if (qtyPrint != null && qtyPrint != "") {
          var url = '<?php echo base_url(); ?>admin/print_shipper/'+shipper_barcode;
          var W = window.open(url);
        // }
    }
   </script>

<script>
     $(document).ready(function() {
          var table = $('#shipper').DataTable();
       
          $('#shipper tbody').on( 'click', 'tr', function () {
              if ( $(this).hasClass('selected') ) {
                  $(this).removeClass('selected');
              }
              else {
                  table.$('tr.selected').removeClass('selected');
                  $(this).addClass('selected');
              }
          } );
       
          $('#button').click( function () {
              table.row('.selected').remove().draw( false );
          } );
      } );
      </script>         