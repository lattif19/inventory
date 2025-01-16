<?php
 $title = "Report Monitoring - ".date("Y-m-d H:i:s");
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=$title.xls");
 header("Pragma: no-cache");
 header("Expires: 0");
?>
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>Item Number</th>
      <th>Location</th>
      <th>Bin</th>
      <th>Barcode Balances</th>
      <th>Maximo Balances</th>
      <th>Selisih</th>
    </tr>
  </thead>
  <tbody>
  <?php echo "Generate at ".date('Y-m-d H:i:s');foreach ($result as $key) {?>
    <tr >
      <td><?php echo $key->item_number;?></td>
      <td><?php echo $key->location;?></td>
      <td><?php echo $key->binnum;?></td>
      <td><?php echo $key->qty;?></td>
      <td><?php echo $key->qtyMaximo;?></td>
      <td><?php if($key->selisih>0){echo "+";}?><?php echo $key->selisih;?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>