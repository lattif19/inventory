
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
        <?php foreach ($query as $row => $value) {?>
          <tr>
            <td><?= $value->trx_timestamp ?></td>
            <td><?= $value->trx_code ?></td>
            <td><?= $value->item_number ?></td>
            <td><?php 
            if ($value->receivedqty < "1000000") {
                echo $value->receivedqty;
              } else {
                echo "";
            } 
            ?>
             
           </td>
            <td><?= $value->NAME ?></td>
            <td>
              <a href="<?php echo base_url();?>transaction/receiving_non_po/detail/<?= $value->trx_detail_id ?>" class="btn btn-info btn-sm"><i class="fa fa-info"> Detail</i></a>
              <a onclick="myFunctionPrint('<?= $value->trx_id ?>')" class="btn btn-warning btn-sm"><i class="fa fa-info"> Print</i></a>
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
</div><!-- /.box -->
<!-- href="<?php echo base_url();?>report/receiving_non_po/<?= $value->trx_id ?>" -->
<script src="<?php echo base_url(); ?>assets/bower/jquery/dist/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    myFunctionPrint=function(trxId){
        // var qtyPrint = prompt('Please enter Qty','10');
        // if (qtyPrint != null && qtyPrint != "") {
          var url = '<?php echo base_url(); ?>report/receiving_non_po/'+trxId;
          var W = window.open(url);
        // }
    }
   </script>


<!-- <script>
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

  </script>  -->

<script>
$(document).ready(function() {
	var oTable=$('#receiving').dataTable({
		// Date Sorting
		columnDefs: [
	       { type: 'date-eu', targets: ([0])}
	     ],
		 //// order table onload
		"order": [[ 0, 'desc' ]],
	});

	var startdate;
	var enddate;
	//instantiate datepicker and choose your format of the dates
	$('#daterangepicker').daterangepicker({
	        ranges: {
	        'All dates' : [moment().subtract(10, 'year'), moment().add(10, 'year')],
	           "Today": [moment(), moment()],
	           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	           '7 last days': [moment().subtract(6, 'days'), moment()],
	           '30 last days': [moment().subtract(29, 'days'), moment()],
	           'This month': [moment().startOf('month'), moment().endOf('month')],
	           'Last month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	        },
	    "opens": "right",
		format: 'YYYY-MM-DD'
	},
	
	function(start, end,label) {
	// Parse it to a moment
	var s = moment(start.toISOString());
	var e = moment(end.toISOString());
	startdate = s.format("YYYY-MM-DD");
	enddate = e.format("YYYY-MM-DD");
	});

	//Filter the datatable on the datepicker apply event with reportage 1
	$('#daterangepicker').on('apply.daterangepicker', function(ev, picker) {
	startdate=picker.startDate.format('YYYY-MM-DD');
	enddate=picker.endDate.format('YYYY-MM-DD');
	$.fn.dataTableExt.afnFiltering.push(
	function( oSettings, aData, iDataIndex ) {
	if(startdate!=undefined){
	// 1 here is the column where my dates are.
	//Convert to YYYY-MM-DD format from DD/MM/YYYY
	var coldate = aData[1].split("/");
	var d = new Date(coldate[2], coldate[1]-1 , coldate[0]);
	var date = moment(d.toISOString());
	date =    date.format("YYYY-MM-DD");

	//Remove hyphens from dates
	dateMin=startdate.replace(/-/g, "");
	dateMax=enddate.replace(/-/g, "");
	date=date.replace(/-/g, "");

	//console.log(dateMin, dateMax, date);

	// run through cases to filter results
	if ( dateMin == "" && date <= dateMax){
	return true;
	} else if ( dateMin =="" && date <= dateMax ){
	return true;
	} else if ( dateMin <= date && "" == dateMax ){
	return true;
	} else if ( dateMin <= date && date <= dateMax ){
	return true;
	}

	// all failed
	return false;
			}
		}
	);
	oTable.fnDraw();
	});
    
    // Setup - add a text input to each footer cell
    $('#receiving .filters .FilterinputSearch').each( function () {
        var title = $('#receiving tfoot .FilterinputSearch').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );

     $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'YYYY/MM/DD h:mm A'});
 
    // DataTable
    var table = $('#receiving').DataTable();
 
} );
</script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>