 <div class="box box-info">
   <div class="box-body">
     <div class="table-responsive">
       <table id="item" class="table table-bordered table-striped"">
         <thead>
           <tr>
             <th>Item Number</th>
             <th>Description</th>
             <th>Location</th>
             <th>Condition Code</th>
             <th>Binnum</th>
             <th>Action</th>
           </tr>
         </thead>
<!--         <tfoot>
          <tr>
            <th>Item Number</th>
            <th>Description</th>
            <th>Location</td>
            <th>Condition Code</th>
            <th>Binnum</th>
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

<script src="<?php echo base_url(); ?>assets/bower/jquery/dist/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#item').DataTable( {
          "processing": true,
          "serverSide": true,
          "searching": true,
          "stateSave": true, //simpan page teralhir
          "ajax":{
            url : "<?php echo site_url('master_data/itemlist') ?>", // json datasource
            type: "post",  // method  , by default get
            error: function(e){  // error handling
              $(".item-error").html("");
              $("#item").append('<tbody class="item-error"><tr><th colspan="5">Sorry, Something is wrong</th></tr></tbody>');
              $("#item_processing").css("display","none");             
            }
          }
        } );

        $('#item tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );
 
        // DataTable
        var table = $('#item').DataTable();
     
        // Apply the search
        table.columns().every( function () {
            var that = this;
     
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
      } );
  </script>