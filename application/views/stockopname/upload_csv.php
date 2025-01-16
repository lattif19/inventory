<div class="row">

<div class="col-md-6">
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
<!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
    </div><!-- /.box-header -->
    <!-- form start -->
    <form action="<?php echo base_url();?>transaction/stockopname/saveCSV" method="POST" enctype="multipart/form-data" class="form-horizontal">
      <div class="box-body">
        <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Upload CSV</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" id="userfile" name="userfile">
          </div>
        </div>
      </div><!-- /.box-body -->
      <div class="box-footer">
        <button type="submit" class="btn btn-primary btn-sm pull-right" name="import" id="submit">Upload</button>
        <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-warning btn-sm pull-left"><i class="fa fa-arrow-left"></i> Back</a>
      </div><!-- /.box-footer -->
    </form>
  </div><!-- /.box -->
</div><!--/.col (right) -->
</div>   <!-- /.row -->