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
      <?php   echo $info;   ?>
    </strong>
</div>

<?php
}
?>
<div class="box">
  <div class="box-header">
  <!-- <a href="<?php echo base_url(); ?>transaction/adjustment/importFromSO" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Import</a> -->
<!--   <button type="button" class="btn btn-primary" type="button" class="btn btn-info btn-flat"  data-toggle="modal" data-target="#myModal">Import</button>
  <a href="<?php echo base_url(); ?>transaction/adjustment/emptyTableSummary" onClick="return confirm('anda yakin akan menghapus data ini')"; class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete</a>
  <a href="<?php echo base_url(); ?>transaction/adjustment/importToAdjustment" class="btn btn-success pull-right btn-sm"><i class="fa fa-trash-o"></i> Adjus Auto</a> -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table id="list" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Item Number</th>
            <th>Location</th>
            <th>Qty So</th>
            <th>Qty System</th>
            <th>Qty Adjustemnt</th>
            <th>Trx Timestamp</th>
            <th>Enter By</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($DataAdjustment as $key => $value) { ?>
          <tr>
            <td><?= $value->item_number ?></td>
            <td><?= $value->name ?></td>
            <td><?= $value->actual_qty ?></td>
            <td><?= $value->system_qty ?></td>
            <td><?= $value->adjustment_qty ?></td>
            <td><?= $value->trx_timestamp ?></td>
            <td><?= $value->enterby ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div><!-- /.table-responsive -->
  </div><!-- /.box-body -->
</div><!-- /.box -->
<?php 
// $url="FLOOR/F5";
// $url=str_replace('/','-',$url);
// echo "<pre>";
// echo $url;
// echo "<br>";

// $str='http://www.example.com/Music/\2011 Hits\Balle Lakka.mp3';
// $str=str_replace(array('','//','-'),'/',$str);
// echo $str;
?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/sweetalert-master/dist/sweetalert.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/sweetalert-master/dist/sweetalert.min.js"></script>

<script>
  $(document).ready(function() { 
    $("#list").DataTable();
  } );

  </script> 
