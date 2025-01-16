 <div class="box box-info">
   <div class="box-header with-border">
   </div><!-- /.box-header -->
   <div class="box-body">
     <div class="table-responsive">
       <table id="person" class="table table-bordered table-striped"">
         <thead>
           <tr>
             <th>Person Id</th>
             <th>First Name</th>
             <th>Last Name</th>
           </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
    </div><!-- /.table-responsive -->
  </div><!-- /.box-body -->   
</div><!-- /.box -->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#person').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url : "<?php echo site_url('admin/personlist') ?>", // json datasource
            type: "post",  // method  , by default get
          }
        } );
      } );
    </script>