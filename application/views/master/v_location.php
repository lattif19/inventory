 <div class="box box-info">
   <div class="box-body">
     <div class="table-responsive">
       <table id="location" class="table table-bordered table-striped"">
         <thead>
           <tr>
             <th>Location</th>
             <th>Description</th>
             <th>Type</th>
             <th>Status</th>
           </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
    </div><!-- /.table-responsive -->
  </div><!-- /.box-body -->
</div><!-- /.box -->
<script src="<?php echo base_url(); ?>assets/bower/jquery/dist/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#location').DataTable( {
          "processing": true,
          "serverSide": true,
          "stateSave": true, //simpan page teralhir
          "ajax":{
            url : "<?php echo site_url('master_data/locationlist') ?>", // json datasource
            type: "post",  // method  , by default get
          }
        } );
      } );
    </script>