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
  <button type="button" class="btn btn-primary" type="button" class="btn btn-info btn-flat"  data-toggle="modal" data-target="#myModal">Import</button>
  <a href="<?php echo base_url(); ?>transaction/adjustment/emptyTableSummary" onClick="return confirm('anda yakin akan menghapus data ini')"; class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete</a>
  <a href="<?php echo base_url(); ?>transaction/adjustment/importToAdjustment" class="btn btn-success pull-right btn-sm"><i class="fa fa-trash-o"></i> Adjus Auto</a>
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table id="adjustment" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Item Number</th>
            <th>Location</th>
            <th>Condition Code</th>
            <th>Qty So</th>
            <th>Qty System</th>
            <th>Qty Diff</th>
            <th>Adjustment</th>
            <!-- <th>Action</th> -->
          </tr>
        </thead>
      </table>
    </div><!-- /.table-responsive -->
  </div><!-- /.box-body -->
</div><!-- /.box -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Import SO</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Select Import</h3>
              </div><!-- /.box-header -->
              <div class="box-body">
                <form action="<?php echo base_url();?>transaction/adjustment/getImport" method="POST">
                  <div class="form-group">
                    <select name="location" class="form-control select2">
                      <option value="WH">WH</option>
                      <option value="WH2">WH #2</option>
                      <option value="WH3">WH #3</option>
                    </select>
                  </div>
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Import</button>
                  </div>
                </form>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </div><!-- /.col --> 
        </div><!-- /.col -->  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/sweetalert-master/dist/sweetalert.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/sweetalert-master/dist/sweetalert.min.js"></script>

<script>
  $(document).ready(function() {
    var selected = [];
 
    $("#adjustment").DataTable({
        "processing": true,
        "serverSide": true,
          "stateSave": true, 
        "ajax":{
            url : "<?php echo site_url('transaction/adjustment/getData') ?>", // json datasource
            type: "post",  // method  , by default get
            error: function(e){  // error handling
              $(".adjustment-error").html("");
              $("#adjustment").append('<tbody class="adjustment-error"><tr><th colspan="3">Sorry, Something is wrong</th></tr></tbody>');
              $("#adjustment_processing").css("display","none");             
            }
        },
        "rowCallback": function( row, data ) {
            if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
                $(row).addClass('selected');
            }
        }
    });
    
    $('#adjustment tbody').on('click', 'tr', function () {
        var id = this.id;
        var index = $.inArray(id, selected);
 
        if ( index === -1 ) {
            selected.push( id );
        } else {
            selected.splice( index, 1 );
        }
 
        $(this).toggleClass('selected');
    } );
  } );

  </script> 
