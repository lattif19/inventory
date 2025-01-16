<div class="box">
  <div class="box-header">
    <a href="<?php echo base_url(); ?>transaction/borrow/add-items" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
    <a href="" class="btn btn-default btn-sm"><i class="fa fa-print"></i></a>
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table id="borrow_items" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Borrowing Number</th>
            <th>Borrower</th>
            <th></th>
          </tr>
        </thead>
        <thead class="filters">
          <tr>
            <td id="reservation">Date</td>
            <td>Borrowing Number</td>
            <td>Borrower</td>
          </tr>
        </thead>
        <tbody>        
          <tr>
            <td>1</td>
            <td>1</td>
            <td>1</td>
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
          var table = $('#borrow_items').DataTable();
       
          $('#borrow_items tbody').on( 'click', 'tr', function () {
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
        $('#borrow_items .filters td').each( function () {
            var title = $('#borrow_items thead th').eq( $(this).index() ).text();
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