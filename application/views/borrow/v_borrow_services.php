<div class="box">
  <div class="box-header">
    <a href="<?php echo base_url(); ?>transaction/borrow/add-services" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
    <a href="" class="btn btn-default btn-sm"><i class="fa fa-print"></i></a>
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table id="borrow_services" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Transaction Number</th>
            <th>Name</th>
            <th></th>
          </tr>
        </thead>
        <thead class="filters">
          <tr>
            <td id="reservation">Date</td>
            <td>Transaction Number</td>
            <td>Name</td>
          </tr>
        </thead>
        <tbody>
        
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>
              <a href="<?php echo base_url(); ?>transaction/borrow/detail/" class="btn btn-info btn-sm"><i class="fa fa-info"></i> Detail</a>
            </td>
          </tr>
        
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box-body -->
</div><!-- /.box -->

<script>
     $(document).ready(function() {
          var table = $('#borrow_services').DataTable();
       
          $('#borrow_services tbody').on( 'click', 'tr', function () {
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

     $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#borrow_services .filters td').each( function () {
            var title = $('#borrow_services thead th').eq( $(this).index() ).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );
     
     
        // Apply the search
        table.columns().eq( 0 ).each( function ( colIdx ) {
            $( 'input', $('.filters td')[colIdx] ).on( 'keyup change', function () {
                table
                    .column( colIdx )
                    .search( this.value )
                    .draw();
          });
        });
      });

</script>