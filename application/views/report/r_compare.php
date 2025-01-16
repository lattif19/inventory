<div class="box">
  <div class="box-header">
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table id="r_compare" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Item Number</th>
            <th>Description</th>
            <th>Condition</th>
            <th>Warehouse</th>
            <th>Issue Unit</th>
            <th>Books</th>
            <th>SO</th>
            <th>Deviation</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($reportCompare as $key => $value) { ?>
          <tr>
            <td><?= $value->item_number ?></td>
            <td><?= $value->DESCRIPTION ?></td>
            <td><?= $value->condition_code ?></td>
            <td><?= $value->location_id ?></td>
            <td><?= $value->issue_unit ?></td>
            <td></td>
            <td><?= $value->qty_so ?></td>
            <td></td>
            <td>
              <a href="" class="btn btn-success btn-sm"><i class="fa fa-download"></i>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box-body -->
  <script>
     $(document).ready(function() {
          var table = $('#r_compare').DataTable();
       
          $('#r_compare tbody').on( 'click', 'tr', function () {
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
