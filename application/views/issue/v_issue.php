 <div class="box box-info" ng-app="">
 <div class="box-header with-border">
    <a href="<?php echo base_url(); ?>transaction/issue/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
   </div><!-- /.box-header -->
   <div class="box-body">
     <div class="table-responsive">
       <table id="issue" class="table table-bordered table-striped" ng-init="qtyPrint[0]=2">
         <thead>
           <tr>
             <th>Timestamp</th>
             <th>Transaction Code</th>
             <th>Enter By</th>
             <th>Wo Number</th>
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
</div><!-- /.box -->

<script src="<?php echo base_url(); ?>assets/bower/jquery/dist/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    myFunctionPrint=function(trxId){
        // var qtyPrint = prompt('Please enter Qty','10');
        // if (qtyPrint != null && qtyPrint != "") {
          var url = '<?php echo base_url(); ?>report/print_issue/'+trxId;
          var W = window.open(url);
        // }
    }
   </script>
   
<script>
  $(document).ready(function() {
    var selected = [];
 
    $("#issue").DataTable({
        "order":[[1, 'desc']],
        "processing": true,
        "serverSide": true,  
        "stateSave": true, 
        "ajax":{
            url : "<?php echo site_url('transaction/issue/getIssueData') ?>", // json datasource
            type: "post",  // method  , by default get
            error: function(e){  // error handling
              $(".issue-error").html("");
              $("#issue").append('<tbody class="issue-error"><tr><th colspan="3">Sorry, Something is wrong</th></tr></tbody>');
              $("#issue_processing").css("display","none");             
            }
        },
        "order":[[1, 'desc']],
        "rowCallback": function( row, data ) {
            if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
                $(row).addClass('selected');
            }
        }
    });

 
    $('#issue tbody').on('click', 'tr', function () {
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
