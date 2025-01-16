<div class="row">
  <!-- Left col -->
  <div class="col-md-12">
    <!-- MAP & BOX PANE -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple">
          <div class="inner">
            <?php foreach ($VIEWPO as $key => $value) { ?>
            <h3><?php echo $value->TOTAL_PO; ?></h3>
            <p>PURCHASE ORDERS</p>
          </div>
          <div class="icon">
            <i class="fa fa-file"></i>
          </div>
          <a href="#" class="small-box-footer">
            <i class="fa fa-arrow-circle-right"></i>
          </a>      
          <?php } ?>
        </div>
      </div><!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <?php foreach ($VIEWWORKORDER as $key => $value) { ?>
            <h3><?php echo $value->TOTAL_WO; ?></h3>
            <p>WORK ORDERS</p>
          </div>
          <div class="icon">
            <i class="fa fa-file-o"></i>
          </div>
          <a href="#" class="small-box-footer">
            <i class="fa fa-arrow-circle-right"></i>
          </a>      
          <?php } ?>
        </div>
      </div><!-- ./col -->

      <div class="col-lg-3 col-xs-6 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <?php foreach ($item as $key => $value) { ?>
            <h3><?php echo $value->total_item; ?></h3>
            <p>ITEM BALANCES INVENTORY SYSTEM</p>
          </div>
          <div class="icon">
            <i class="fa fa-list"></i>
          </div>
          <a href="#" class="small-box-footer">
            <i class="fa fa-arrow-circle-right"></i>
          </a>  
          <?php } ?>    
        </div>
      </div><!-- ./col -->

      <div class="col-lg-3 col-xs-6 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-orange">
          <div class="inner">
            <?php foreach ($INVmaximo as $key => $value) { ?>
            <h3><?php echo $value->TOTAL_ITEM; ?></h3>
            <p>ITEM BALANCES MAXIMO</p>
          </div>
          <div class="icon">
            <i class="fa fa-cog" aria-hidden="true"></i>
          </div>
          <a href="#" class="small-box-footer">
            <i class="fa fa-arrow-circle-right"></i>
          </a> 
          <?php } ?>         
        </div>
      </div><!-- ./col -->

    </div><!-- /.row -->
  </div><!-- /.col -->           
</div><!-- /.row --><!-- Info boxes -->




<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <div class="col-md-3">
    <!-- PRODUCT LIST -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Last Receive</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <?php foreach ($lastReceive->result() as $row) { ?>
        <ul class="products-list product-list-in-box">
          <li class="item">
            <div class="">
              <a href="javascript::;" class="product-title"><a href="<?php echo base_url();?>transaction/receiving/detail/<?php echo $row->trx_id; ?>"><?php echo $row->trx_code; ?></a><span class="label label-warning pull-right"><?php echo $row->trx_timestamp; ?></span></a>
              <span class="product-description"></span>
            </div>
          </li><!-- /.item -->
        </ul>
        <?php } ?>
      </div><!-- /.box-body -->
      <div class="box-footer text-center">
        <a href="<?php echo base_url();?>transaction/receiving" class="uppercase">View All Products</a>
      </div><!-- /.box-footer -->
    </div><!-- /.box -->
  </div><!-- /.col -->

  <div class="col-md-3">
    <!-- PRODUCT LIST -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Last Issue</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <?php foreach ($lastIssue->result() as $row) { ?>
        <ul class="products-list product-list-in-box">
          <li class="item">
            <div class="">
              <a href="javascript::;" class="product-title"><a href="<?php echo base_url();?>transaction/issue/detail/<?php echo $row->trx_id; ?>" ><?php echo $row->trx_code; ?></a><span class="label label-warning pull-right"><?php echo $row->trx_timestamp; ?></span></a>
              <span class="product-description"></span>
            </div>
          </li><!-- /.item -->
        </ul>
        <?php } ?>
      </div><!-- /.box-body -->
      <div class="box-footer text-center">
        <a href="<?php echo base_url();?>transaction/issue" class="uppercase">View All Products</a>
      </div><!-- /.box-footer -->
    </div><!-- /.box -->
  </div><!-- /.col -->

  <div class="col-md-3">
    <!-- PRODUCT LIST -->
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Last Return To Vendor</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <?php foreach ($lastVendor->result() as $row) { ?>
        <ul class="products-list product-list-in-box">
          <li class="item">
            <div class="">
              <a href="javascript::;" class="product-title"><a href="<?php echo base_url();?>transaction/rtrn-vendor/detail/<?php echo $row->trx_id; ?>" ><?php echo $row->trx_code; ?></a><span class="label label-warning pull-right"><?php echo $row->trx_timestamp; ?></span></a>
              <span class="product-description">
              </span>
            </div>
          </li><!-- /.item -->
        </ul>
        <?php } ?>
      </div><!-- /.box-body -->
      <div class="box-footer text-center">
        <a href="<?php echo base_url();?>transaction/rtrn-vendor" class="uppercase">View All Products</a>
      </div><!-- /.box-footer -->
    </div><!-- /.box -->
  </div><!-- /.col -->

  <div class="col-md-3">
    <!-- PRODUCT LIST -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Last Return To Warehouse</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <?php foreach ($lastWarehouse->result() as $row) { ?>
        <ul class="products-list product-list-in-box">
          <li class="item">
            <div class="">
              <a href="javascript::;" class="product-title"><a href="<?php echo base_url();?>transaction/rtrn-warehouse/detail/<?php echo $row->trx_id; ?>" ><?php echo $row->trx_code; ?></a><span class="label label-warning pull-right"><?php echo $row->trx_timestamp; ?></span></a>
              <span class="product-description">
              </span>
            </div>
          </li><!-- /.item -->
        </ul>
        <?php } ?>
      </div><!-- /.box-body -->
      <div class="box-footer text-center">
        <a href="<?php echo base_url();?>transaction/rtrn-warehouse" class="uppercase">View All Products</a>
      </div><!-- /.box-footer -->
    </div><!-- /.box -->
  </div><!-- /.col -->            
</div><!-- /.row -->


<div class="row">
  <!-- Left col -->
  <div class="col-md-12">
    <!-- MAP & BOX PANE -->
    <div class="row">

      <div class="col-md-4">
        <!-- PRODUCT LIST -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">List Item Non PO</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <?php foreach ($alertPO->result() as $row) { ?>
            <ul class="products-list product-list-in-box">
              <li class="item">
                <div class="">
                  <a href="javascript::;" class="product-title"><a href="<?php echo base_url();?>transaction/receiving-non-po/detail/<?php echo $row->trx_id; ?>" ><?php echo $row->item_number; ?> - <?php echo $row->enterby; ?></a><span class="label label-warning pull-right"><?php echo $row->trx_timestamp; ?></span></a>
                  <span class="product-description">
                  </span>
                </div>
              </li><!-- /.item -->
            </ul>
            <?php } ?>
          </div><!-- /.box-body -->
          <div class="box-footer text-center">
            <a href="<?php echo base_url();?>transaction/receiving-non-po" class="uppercase">View All Products</a>
          </div><!-- /.box-footer -->
        </div><!-- /.box -->
      </div><!-- /.col -->


      <div class="col-md-4">
        <!-- PRODUCT LIST -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">List Item Non WO</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <?php foreach ($alertWO->result() as $row) { ?>
            <ul class="products-list product-list-in-box">
              <li class="item">
                <div class="">
                  <a href="javascript::;" class="product-title"><a href="<?php echo base_url();?>transaction/issue-non-wo/detail/<?php echo $row->trx_id; ?>" ><?php echo $row->item_number; ?> - <?php echo $row->issueto; ?> - <?php echo $row->enterby; ?></a><span class="label label-warning pull-right"><?php echo $row->trx_timestamp; ?></span></a>
                  <span class="product-description">
                  </span>
                </div>
              </li><!-- /.item -->
            </ul>
            <?php } ?>
          </div><!-- /.box-body -->
          <div class="box-footer text-center">
            <a href="<?php echo base_url();?>transaction/issue-non-wo" class="uppercase">View All Products</a>
          </div><!-- /.box-footer -->
        </div><!-- /.box -->
      </div><!-- /.col -->


      <!-- Browser Usage -->
      <div class="col-md-4">
      	<div class="info-box bg-yellow">
          <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Alert Transaction Without PO</span>
            <?php foreach ($withoutPO->result() as $key => $value) { ?>
             <span class="info-box-number"><?= $value->total_without_po ?></span>
            <div class="progress">
              <div class="progress-bar" style="width: 50%"></div>
            </div>
            <span class="progress-description">
              <!-- 50% Increase in 30 Days -->
            </span>
            <?php } ?>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
        <div class="info-box bg-green">
          <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Alert Transaction Without WO</span>
            <?php foreach ($withoutWO->result() as $key => $value) { ?>
            <span class="info-box-number"><?= $value->total_without_wo ?></span>
            <div class="progress">
              <div class="progress-bar" style="width: 20%"></div>
            </div>
            <span class="progress-description">
              <!-- 20% Increase in 30 Days -->
            </span>
            <?php } ?>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div>
    </div><!-- /.row -->
  </div><!-- /.col -->           
</div><!-- /.row -->

<div class="row">
  <div class="col-md-8">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Book</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <table id="book" class="table no-margin">
            <thead>
              <tr>
                <th>Last</th>
                <th>Item Number</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Saldo</th>
                <th>Status</th>
                <th>Trx</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dataItem as $row) { ?>
              <tr>
                <td><?php echo $row->timestamp; ?></td>
                <td><span class="label label-success"><?php echo $row->item_number; ?></span></td>
                <td>
                  <?php
                  if ($row->trx == "Dr") {
                    echo $row->qty;
                  } else {
                    echo "-";
                  }
                  ?>
                </td>
                <td>
                  <?php 
                  if ($row->trx == "Kr") {
                    echo $row->qty;
                  } else {
                    echo "-";
                  }
                  ?>
                </td>
                <td><?php echo $row->currentBalance; ?></td>
                <td>
                  <?php
                  if ($row->trx_code == "1") {
                    echo '<span class="label label-default">'.$row->trx_detail.'</span>';
                  } elseif ($row->trx_code == "2") {
                    echo '<span class="label label-warning">'.$row->trx_detail.'</span>';
                  } elseif ($row->trx_code == "3") {
                    echo '<span class="label label-success">'.$row->trx_detail.'</span>';
                  } elseif ($row->trx_code == "4") {
                    echo '<span class="label label-info">'.$row->trx_detail.'</span>';
                  } elseif ($row->trx_code == "5") {
                    echo '<span class="label label-default">'.$row->trx_detail.'</span>';
                  }
                  ?>
                </td>
                <td><?php echo $row->trx_reff; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div><!-- /.table-responsive -->
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col -->


  <div class="col-md-4">
    <div class="info-box bg-red">
      <span class="info-box-icon"><i class="ion-ios-monitor-outline"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Free Hardisk</span>
        <span class="info-box-number"><?php 
          $bytes = disk_free_space("."); 
          $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
          $base = 1024;
          $class = min((int)log($bytes , $base) , count($si_prefix) - 1);    echo sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] . '<br />';


          ?></span>
          <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
          </div>
          <span class="progress-description">
            Information of available space from machine.
          </span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->




      <div class="info-box bg-orange">
        <span class="info-box-icon"><i class="ion-gear-b"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">CPU Usage</span>
          <span class="info-box-number">
            <?php 

            function get_server_cpu_usage(){

              $load = sys_getloadavg();
              return round($load[0],2);

            }
echo get_server_cpu_usage()." %"; // 123 kb
?>
</span>
<div class="progress">
  <div class="progress-bar" style="width: 40%"></div>
</div>
<span class="progress-description">
            Information of CPU from machine.
</span>
</div><!-- /.info-box-content -->
</div><!-- /.info-box -->   


<div class="info-box bg-aqua">
  <span class="info-box-icon"><i class="ion-battery-empty"></i></span>
  <div class="info-box-content">
    <span class="info-box-text">Memory Usage</span>
    <span class="info-box-number">



      <?php 

      function get_server_memory_usage(){

        $free = shell_exec('free');
        $free = (string)trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        $memory_usage = $mem[2]/$mem[1]*100;

        return round($memory_usage,2);
      }
echo get_server_memory_usage()." %"; // 123 kb
?>
</span>
<div class="progress">
  <div class="progress-bar" style="width: 40%"></div>
</div>
<span class="progress-description">
            Information of RAM from machine.
</span>
</div><!-- /.info-box-content -->
</div><!-- /.info-box -->   
<div class="info-box bg-purple">
  <span class="info-box-icon"><i class="ion-ios-people-outline"></i></span>
  <div class="info-box-content">
    <span class="info-box-text">User Online</span>
    <span class="info-box-number">

      <?php 
      echo exec("netstat -plan | grep :80 | wc -l");
      ?>
    </span>
    <div class="progress">
      <div class="progress-bar" style="width: 40%"></div>
    </div>
    <span class="progress-description">
      
            Information online user access to machine.
    </span>
  </div><!-- /.info-box-content -->
</div><!-- /.info-box -->   
</div>
</div><!-- /.row -->

<script>
  $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#book tfoot th').each( function () {
      var title = $(this).text();
      $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );

    // DataTable
    var table = $('#book').DataTable({
      "lengthMenu": [[5, 10, -1], [5, 10, "All"]]
    });

   // // Apply the search
   //  table.columns().every( function () {
   //    var that = this;

   //    $( 'input', this.footer() ).on( 'keyup change', function () {
   //      if ( that.search() !== this.value ) {
   //        that
   //        .search( this.value )
   //        .draw();
   //      }
   //    } );
   //  } );
  } );
</script>