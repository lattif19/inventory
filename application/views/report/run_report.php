<?php
 $title = "Report Issue (WO) - ".date("Y-m-d H:i:s");
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=$title.xls");
 header("Pragma: no-cache");
 header("Expires: 0");
?>
<table id="example" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>WO Number</th>
      <th>Item Number</th>
      <th>Name</th>
      <th>Location</th>
      <th>Issue QTY</th>
      <th>Issue To</th>
      <th>Shipper</th>
      <th>Enter By</th>
      <th>Time Transaction</th>
    </tr>
  </thead>
  <tbody>
    <?php echo "Generate at ".date('Y-m-d H:i:s');foreach ($issuereport as $key) {?>
    <tr >
      <td><?php echo $key->wonum;?></td>
      <td><?php echo $key->item_number;?></td>
      <td><?php echo $key->description_name_trx;?></td>
      <td><?php echo $key->loc_name;?></td>
      <td><?php echo $key->issuedqty;?></td>
      <td><?php echo $key->issueto;?></td>
      <td><?php echo $key->shipper_name;?></td>
      <td><?php echo $key->enterby;?></td>
      <td><?php echo $key->trx_timestamp;?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
