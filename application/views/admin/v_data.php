<div class="box">
 <?php
        if (validation_errors() || $this->session->flashdata('info')) {
      ?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
          <i class="fa fa-warning"> <strong>Warning!</strong></i>
          <?php echo validation_errors(); ?>
          <?php echo $this->session->flashdata('info'); ?>
      </div>
      <?php } ?>
  <div class="box-header">
    <a href="<?php echo base_url(); ?>index.php/admin/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
    <a href="" class="btn btn-default btn-sm"><i class="fa fa-print"></i></a>
    <!-- <a href="<?php echo base_url();?>admin/downloadExcel" class="btn btn-info btn-sm pull-right"><i class="fa fa-download"></i></a> -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <table id="data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Username</th>
          <th>Status</th>
          <th>Level</th>          
          <th>Tools</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data as $key => $value) { ?>
        <tr>
          <td><?= $value->username ?></td>
          <td><?= $value->username ?></td>
          <td><?= $value->status ?></td>
          <td><?php if($value->level = 2){ echo "user"; } elseif($value->level = 1) { echo "admin"; }elseif($value->level = 0){ echo "super Admin";}  ?></td>
          <td>
            <a href="<?php echo base_url();?>admin/edit/<?= $value->user_id ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
            <a href="<?php echo base_url();?>admin/delete/<?= $value->user_id ?>" class="btn btn-danger btn-xs" onClick="return confirm('anda yakin akan menghapus data ini');"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div><!-- /.box-body -->
</div><!-- /.box -->
<script>
     $(document).ready(function() {
          var table = $('#data').DataTable();
       
          $('#data tbody').on( 'click', 'tr', function () {
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