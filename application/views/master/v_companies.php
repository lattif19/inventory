 <div class="box box-info">
   <div class="box-body">
     <div class="table-responsive">
       <table id="company" class="table table-bordered table-striped"">
         <thead>
           <tr>
             <th>Company ID</th>
             <th>Name</th>
             <th>Address 1</th>
             <th>Address 2</th>
             <th>Address 3</th>
             <th>Address 4</th>
             <th>Contact</th>
             <th>Phone</th>
             <th>Fax</th>
           </tr>
         </thead>
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
        var dataTable = $('#company').DataTable( {
          "processing": true,
          "serverSide": true,
          "stateSave": true, //simpan page teralhir
          "ajax":{
            url : "<?php echo site_url('master_data/companieslist') ?>", // json datasource
            type: "post",  // method  , by default get
          }
          
        } );
      } );
    </script>      