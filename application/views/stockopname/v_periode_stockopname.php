<div class="box">
  <div class="box-header">
  <a href="<?php echo base_url(); ?>transaction/stockopname/add-periode" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table id="periode" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>SO Name</th>
            <th>SO Start Date</th>
            <th>SO End Date</th>
            <th>SO Location</th>
            <th>So Note</th>
            <th>So Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($periodeSO as $row) :?>
          <tr>
            <td><?php echo $row->so_name; ?></td>
            <td><?php echo $row->so_start_date; ?></td>
            <td><?php echo $row->so_end_date; ?></td>
            <td><?php echo $row->name; ?></td>
            <td><?php echo $row->so_note; ?></td>
            <td>
              <?php 
                if ($row->so_status == 0) {
                  echo "<span class='label label-primary'>Active</span>";
                } elseif ($row->so_status == 1) {
                  echo "<span class='label label-danger'>Closed</span>";
                } elseif ($row->so_status == 2) {
                  echo "<span class='label label-success'>Posted</span>";
                } elseif ($row->so_status == 3) {
                  echo "<span class='label label-warning'>Canceled</span>";
                }
              ?>  
            </td>
            <td>
              <a href="<?php echo base_url(); ?>transaction/stockopname/update/<?php echo $row->id_so; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
              <a href="<?php echo base_url(); ?>transaction/stockopname/detail-periode/<?php echo $row->id_so; ?>" class="btn btn-info btn-sm"><i class="fa fa-view"></i> Detail</a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <!-- <div class="box-footer">
      <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-warning btn-sm pull-left"><i class="fa fa-arrow-left"></i> Back</a>
    </div> -->
   </div><!-- /.box-body -->
</div>
<script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#periode tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#periode').DataTable();
 
} );
</script>