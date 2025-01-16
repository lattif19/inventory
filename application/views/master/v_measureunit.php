 <div class="box box-info">
   <div class="box-body">
     <div class="table-responsive">
       <table id="measureunit" class="table table-bordered table-striped"">
         <thead>
           <tr>
             <th>Measureunit ID</th>
             <th>Name</th>
            </tr>
         </thead>
         <tbody>
      </table>
    </div><!-- /.table-responsive -->
    

    <!-- <div class="box-footer">
      <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-warning btn-sm pull-left"><i class="fa fa-arrow-left"></i> Back</a>
    </div> -->
  </div><!-- /.box-body -->
  <script src="<?php echo base_url(); ?>assets/bower/jquery/dist/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#measureunit').DataTable( {
          "processing": true,
          "serverSide": true,
          "stateSave": true, //simpan page teralhir
          "ajax":{
            url : "<?php echo site_url('master_data/measureunitlist') ?>", // json datasource
            type: "post",  // method  , by default get
          }
        } );
      } );
    </script>      
</div><!-- /.box -->