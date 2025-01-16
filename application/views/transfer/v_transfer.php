 <div class="box box-info" ng-app="">
 <div class="box-header with-border">
    <a href="<?php echo base_url(); ?>transaction/transfer/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
   </div><!-- /.box-header -->
   <div class="box-body">
     <div class="table-responsive">
       <table id="transfer" class="table table-bordered table-striped" ng-init="qtyPrint[0]=2">
         <thead>
           <tr>
             <th>Transfer Date</th>
             <th>Item Number</th>
             <th>Qty</th>
             <th>From Location</th>
             <th>To Location</th>
             <th>From Bin</th>
             <th>To Bin</th>
           </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
    </div><!-- /.table-responsive -->
  </div><!-- /.box-body --> 
</div><!-- /.box -->


<script>
  $(document).ready(function() {
    var selected = [];
 
    $("#transfer").DataTable({
        "processing": true,
        "serverSide": true,
          "stateSave": true, 
        "ajax":{
            url : "<?php echo site_url('transaction/transfer/getDataTransfer') ?>", // json datasource
            type: "post",  // method  , by default get
            error: function(e){  // error handling
              $(".transfer-error").html("");
              $("#transfer").append('<tbody class="transfer-error"><tr><th colspan="3">Sorry, Something is wrong</th></tr></tbody>');
              $("#transfer_processing").css("display","none");             
            }
        },
        "rowCallback": function( row, data ) {
            if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
                $(row).addClass('selected');
            }
        }
    });

 
    $('#transfer tbody').on('click', 'tr', function () {
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
