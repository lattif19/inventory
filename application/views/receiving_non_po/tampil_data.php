
 <div class="box box-info">
   <div class="box-header with-border">
    <a href="<?php echo base_url(); ?>transaction/receiving_non_po/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
   </div><!-- /.box-header -->
   <div class="box-body">
     <div class="table-responsive">
     <table id="receiving" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Date Transaction</th>
            <th>Transaction Code</th>
            <th>Item Number</th>
            <th>Qty</th>
            <th>Company</th>
            <th>Action</th>
          </tr>
        </thead>
        <!-- <tfoot class="filters">
          <tr>
            <th>
              <div class="input-prepend input-group"> <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                <input type="text" style="width: 100px; font-size: 10px;" name="daterangepicker" id="daterangepicker" class="form-control" value="">
              </div>
            </th>
            <th class="FilterinputSearch">Transaction Number</th>
            <th class="FilterinputSearch">Item Number</th>
            <th class="FilterinputSearch">Qty</th>
            <th class="FilterinputSearch">Company</th>
            <th></th>
          </tr>
        </tfoot> -->
        <tbody>
        
        </tbody>
    </table>
    </div><!-- /.table-responsive -->
    <!-- <div class="box-footer">
      <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-warning btn-sm pull-left"><i class="fa fa-arrow-left"></i> Back</a>
    </div> -->
  </div><!-- /.box-body --> 
</div><!-- /.box -->
<!-- href="<?php echo base_url();?>report/receiving_non_po/<?= $value->trx_id ?>" -->
<script>
    myFunctionPrint=function(trxId){
        // var qtyPrint = prompt('Please enter Qty','10');
        // if (qtyPrint != null && qtyPrint != "") {
          var url = '<?php echo base_url(); ?>report/receiving_non_po/'+trxId;
          var W = window.open(url);
        // }
    }
   </script>


<script>
  $(document).ready(function() {
    var selected = [];
 
    $("#receiving").DataTable({
        "processing": true,
        "serverSide": true,
          "stateSave": true, 
        "ajax":{
            url : "<?php echo site_url('transaction/receiving-non-po/getReceivingData') ?>", // json datasource
            type: "post",  // method  , by default get
            error: function(e){  // error handling
              $(".receiving-error").html("");
              $("#receiving").append('<tbody class="receiving-error"><tr><th colspan="3">Sorry, Something is wrong</th></tr></tbody>');
              $("#receiving_processing").css("display","none");             
            }
        },
        "rowCallback": function( row, data ) {
            if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
                $(row).addClass('selected');
            }
        }
    });

 
    $('#receiving tbody').on('click', 'tr', function () {
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
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>