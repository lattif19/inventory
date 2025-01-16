 <div class="box box-info">
   <div class="box-header with-border">
     <h3 class="box-title">Latest Orders</h3>
     <div class="box-tools pull-right">
       <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
       <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
     </div>
   </div><!-- /.box-header -->
   <div class="box-body">
     <div class="table-responsive">
       <table id="commodity" class="table table-bordered table-striped"">
         <thead>
           <tr>
             <th>Commodity</th>
             <th>Description</th>
           </tr>
         </thead>
         <tbody>
         <?php foreach ($query->result() as $key => $value) { ?>
          <tr>
            <td><?= $value->name ?></td>
            <td><?= $value->description ?></td>
          </tr>
          <?php } ?>
         </tbody>
      </table>
    </div><!-- /.table-responsive -->
  </div><!-- /.box-body -->

   <script>
     $(document).ready(function() {
          var table = $('#commodity').DataTable();
       
          $('#commodity tbody').on( 'click', 'tr', function () {
              if ( $(this).hasClass('selected') ) {
                  $(this).removeClass('selected');
              }
              else {
                  table.$('tr.selected').removeClass('selected');
                  $(this).addClass('selected');
              }
          } );
       
          $('#button').click( function () {
              table.row('.selected').remove().draw( false );
          } );
      } );
      </script>                 
</div><!-- /.box -->