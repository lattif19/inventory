 <div class="box box-info">
   <div class="box-header with-border">
   </div><!-- /.box-header -->
   <div class="box-body">
     <div class="table-responsive">
       <table id="log_activities" class="table table-bordered table-striped"">
         <thead>
           <tr>
             <th>Long Time</th>
             <th>Modul</th>
             <th>User Action</th>
             <th>Activity ID</th>
             <th>Message</th>
           </tr>
         </thead>
         <tbody>
         <?php foreach ($data->result() as $key => $value) { ?>
         <tr>
           <td><?= $value->longtime ?></td>
           <td><?= $value->modul ?></td>
           <td><?= $value->user_action ?></td>
           <td><?= $value->activity_id ?></td>
           <td><?= $value->message ?></td>
         </tr>
         <?php } ?>
         </tbody>
      </table>
    </div><!-- /.table-responsive -->
  </div><!-- /.box-body -->
</div><!-- /.box -->
<script>
  $(document).ready(function() {
      var table = $('#log_activities').DataTable();
   
      $('#log_activities tbody').on( 'click', 'tr', function () {
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