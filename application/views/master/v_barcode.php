 <div class="box box-info" ng-app="">
   <div class="box-body">
     <div class="table-responsive">
       <table id="barcode" class="table table-bordered table-striped" ng-init="qtyPrint[0]=2">
         <thead>
           <tr>
             <th>Item Number </th>
             <th>Description</th>
             <!-- <th>Qty Print</th> -->
             <th>Action</th>
           </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
    </div><!-- /.table-responsive -->
  </div><!-- /.box-body --> 

  <!-- <div class="box-footer">
    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-warning btn-sm pull-left"><i class="fa fa-arrow-left"></i> Back</a>
  </div> -->


  <script>
    myFunctionPrint=function(itemNumber){
        var qtyPrint = prompt('Please enter Qty','10');
        if (qtyPrint != null && qtyPrint != "") {
          var url = '<?php echo base_url(); ?>master-data/get-barcode/'+itemNumber+'/'+qtyPrint;
          var W = window.open(url);
        }
    }
   </script>

</div><!-- /.box -->
<script src="<?php echo base_url(); ?>assets/bower/jquery/dist/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(document).ready(function() {
    var selected = [];
 
    $("#barcode").DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            url : "<?php echo site_url('master_data/barcodelist') ?>", // json datasource
            type: "post",  // method  , by default get
            error: function(e){  // error handling
              $(".item-error").html("");
              $("#item").append('<tbody class="item-error"><tr><th colspan="3">Sorry, Something is wrong</th></tr></tbody>');
              $("#item_processing").css("display","none");             
            }
        },
        "rowCallback": function( row, data ) {
            if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
                $(row).addClass('selected');
            }
        }
    });

 
    $('#barcode tbody').on('click', 'tr', function () {
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
